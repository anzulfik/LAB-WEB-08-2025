<?php
require 'functions.php';
require_login();
$user = current_user();

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($user['role'] === 'superadmin') {
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($user['role'] === 'project_manager') {
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ? AND manager_id = ?");
        $stmt->execute([$id, $user['id']]);
    } else {
        http_response_code(403); exit;
    }
    header("Location: projects.php");
    exit;
}

if ($user['role'] === 'superadmin') {
    $stmt = $pdo->query("SELECT p.*, u.username as manager FROM projects p LEFT JOIN users u ON p.manager_id = u.id ORDER BY p.id DESC");
    $projects = $stmt->fetchAll();
} elseif ($user['role'] === 'project_manager') {
    $stmt = $pdo->prepare("SELECT p.*, u.username as manager FROM projects p LEFT JOIN users u ON p.manager_id = u.id WHERE manager_id = ? ORDER BY p.id DESC");
    $stmt->execute([$user['id']]);
    $projects = $stmt->fetchAll();
} else { 
    $stmt = $pdo->prepare("SELECT DISTINCT p.*, u.username as manager FROM projects p JOIN tasks t ON p.id = t.project_id LEFT JOIN users u ON p.manager_id=u.id WHERE t.assigned_to = ? ORDER BY p.id DESC");
    $stmt->execute([$user['id']]);
    $projects = $stmt->fetchAll();
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Proyek</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4">
<div class="container">
  <h3>Daftar Proyek</h3>
  <?php if($user['role'] !== 'team_member'): ?>
    <a class="btn btn-success mb-2" href="project_form.php">Tambah Proyek</a>
  <?php endif; ?>
  <table class="table">
    <thead><tr><th>ID</th><th>Nama</th><th>Manager</th><th>Mulai</th><th>Selesai</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php foreach($projects as $p): ?>
        <tr>
          <td><?=$p['id']?></td>
          <td><?=htmlspecialchars($p['nama_proyek'])?></td>
          <td><?=htmlspecialchars($p['manager'] ?? '-')?></td>
          <td><?=$p['tanggal_mulai']?></td>
          <td><?=$p['tanggal_selesai']?></td>
          <td>
            <a class="btn btn-sm btn-info" href="tasks.php?project_id=<?=$p['id']?>">Tugas</a>
            <?php if($user['role'] === 'superadmin' || ($user['role']==='project_manager' && $p['manager_id']==$user['id'])): ?>
              <a class="btn btn-sm btn-primary" href="project_form.php?id=<?=$p['id']?>">Edit</a>
              <a class="btn btn-sm btn-danger" href="projects.php?delete=<?=$p['id']?>" onclick="return confirm('Hapus proyek?')">Hapus</a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <a href="dashboard.php">Kembali</a>
</div>
</body></html>
