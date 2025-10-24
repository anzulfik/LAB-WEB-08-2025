<?php
require 'functions.php'; 
require_login();       
$user = current_user();  

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status_id'])) {
    $tid = (int)$_POST['change_status_id'];
    $newstatus = $_POST['status'];
    
    $stmt = $pdo->prepare("SELECT assigned_to FROM tasks WHERE id = ?"); 
    $stmt->execute([$tid]);
    $r = $stmt->fetch();
    
    if ($r && $r['assigned_to'] == $user['id']) { 
        $stmt = $pdo->prepare("UPDATE tasks SET status = ? WHERE id = ?");
        $stmt->execute([$newstatus, $tid]);
    }
    
    $project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;
    if (!$project_id && isset($_POST['project_id'])) {
        $project_id = (int)$_POST['project_id'];
    }

    header("Location: tasks.php" . ($project_id ? "?project_id=$project_id":''));
    exit;
}

$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT p.manager_id FROM tasks t JOIN projects p ON t.project_id=p.id WHERE t.id = ?");
    $stmt->execute([$id]);
    $r = $stmt->fetch();
    if (!$r) { header("Location: tasks.php"); exit; }

    if ($user['role'] === 'superadmin' || ($user['role']==='project_manager' && $r['manager_id']==$user['id'])) {
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
    } else {
        http_response_code(403);
        exit;
    }
    header("Location: tasks.php" . ($project_id ? "?project_id=$project_id":''));
    exit;
}

$params = [];
$q = "SELECT t.*, p.nama_proyek, u.username as assigned_user, p.manager_id FROM tasks t LEFT JOIN projects p ON t.project_id=p.id LEFT JOIN users u ON t.assigned_to = u.id";
$where = [];
if ($project_id) { $where[] = "t.project_id = ?"; $params[] = $project_id; }

if ($user['role'] === 'project_manager') {
    $where[] = "(p.manager_id = ?)";
    $params[] = $user['id'];
} elseif ($user['role'] === 'team_member') {
    $where[] = "(t.assigned_to = ?)";
    $params[] = $user['id'];
}

if ($where) $q .= " WHERE " . implode(' AND ', $where);
$q .= " ORDER BY t.id DESC";
$stmt = $pdo->prepare($q);
$stmt->execute($params);
$tasks = $stmt->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Tugas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4">
<div class="container">
  <h3>Daftar Tugas <?= $project_id ? " (Project $project_id)" : "" ?></h3>
  <?php if($user['role'] !== 'team_member'): ?>
    <a class="btn btn-success mb-2" href="task_form.php<?= $project_id ? '?project_id='.$project_id : '' ?>">Tambah Tugas</a>
  <?php endif; ?>
  <table class="table">
    <thead><tr><th>ID</th><th>Nama</th><th>Project</th><th>Assigned</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php foreach($tasks as $t): ?>
        <tr>
          <td><?=$t['id']?></td>
          <td><?=htmlspecialchars($t['nama_tugas'])?></td>
          <td><?=htmlspecialchars($t['nama_proyek'])?></td>
          <td><?=htmlspecialchars($t['assigned_user'] ?? '-')?></td>
          <td><?=$t['status']?></td>
          <td>
            <?php if($user['role'] === 'superadmin' || ($user['role']==='project_manager' && $t['manager_id']==$user['id'])): ?>
              <a class="btn btn-sm btn-primary" href="task_form.php?id=<?=$t['id']?>">Edit</a>
              <a class="btn btn-sm btn-danger" href="tasks.php?delete=<?=$t['id']?>" onclick="return confirm('Hapus tugas?')">Hapus</a>
            <?php endif; ?>

            <?php if($user['role'] === 'team_member' && $t['assigned_to'] == $user['id']): ?>
              <form method="post" action="tasks.php<?= $project_id ? '?project_id='.$project_id : '' ?>" style="display:inline-block">
                <input type="hidden" name="change_status_id" value="<?=$t['id']?>">
                <?php if ($project_id): ?>
                <input type="hidden" name="project_id" value="<?=$project_id?>">
                <?php endif; ?>
                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm" style="display:inline-block; width:auto;">
                  <option value="belum" <?= $t['status']=='belum' ? 'selected':'' ?>>belum</option>
                  <option value="proses" <?= $t['status']=='proses' ? 'selected':'' ?>>proses</option>
                  <option value="selesai" <?= $t['status']=='selesai' ? 'selected':'' ?>>selesai</option>
                </select>
              </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <a href="dashboard.php">Kembali</a>
</div>
</body></html>