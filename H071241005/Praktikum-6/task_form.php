<?php
require 'functions.php';
require_login();
$user = current_user();
if ($user['role'] === 'team_member') { http_response_code(403); exit; }

$id = $_GET['id'] ?? null;
$project_id_prefill = $_GET['project_id'] ?? null;
$editing = $id !== null;

$error = '';
$task = ['nama_tugas'=>'','deskripsi'=>'','status'=>'belum','project_id'=>$project_id_prefill,'assigned_to'=>null];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_tugas']);
    $des = trim($_POST['deskripsi']);
    $status = $_POST['status'] ?? 'belum';
    $project_id = $_POST['project_id'];
    $assigned_to = $_POST['assigned_to'] ?: null;

    $task = [
        'nama_tugas' => $nama,
        'deskripsi' => $des,
        'status' => $status,
        'project_id' => $project_id,
        'assigned_to' => $assigned_to
    ];

    if (empty($nama)) {
        $error = "Nama tugas wajib diisi.";
    }
    if (empty($error) && empty($project_id)) {
        $error = "Proyek wajib dipilih.";
    }

    if (empty($error)) {
        $stmt = $pdo->prepare("SELECT id FROM tasks WHERE nama_tugas = ? AND project_id = ? AND id != ?");
        $stmt->execute([$nama, $project_id, $id ?? 0]);
        if ($stmt->fetch()) {
            $error = "Nama tugas tersebut sudah ada di dalam proyek ini.";
        }
    }
    
    if (empty($error) && $user['role'] === 'project_manager') {
        $stmt = $pdo->prepare("SELECT manager_id FROM projects WHERE id = ?");
        $stmt->execute([$project_id]);
        $p = $stmt->fetch();
        if (!$p || $p['manager_id'] != $user['id']) { 
            $error = "Anda tidak memiliki akses ke proyek ini.";
        }
    }

    if (empty($error)) {
        if ($editing) {
            $stmt = $pdo->prepare("UPDATE tasks SET nama_tugas=?, deskripsi=?, status=?, project_id=?, assigned_to=? WHERE id=?");
            $stmt->execute([$nama,$des,$status,$project_id,$assigned_to,$id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO tasks (nama_tugas, deskripsi, status, project_id, assigned_to) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nama,$des,$status,$project_id,$assigned_to]);
        }
        header("Location: tasks.php?project_id=".$project_id);
        exit;
    }

} elseif ($editing) { 
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
    $task = $stmt->fetch();
    if (!$task) { echo "Tugas tidak ditemukan"; exit; }
    if ($user['role']==='project_manager') {
        $stmt = $pdo->prepare("SELECT manager_id FROM projects WHERE id = ?");
        $stmt->execute([$task['project_id']]);
        $p = $stmt->fetch();
        if (!$p || $p['manager_id'] != $user['id']) { echo "Akses terlarang"; exit; }
    }
}

if ($user['role'] === 'superadmin') {
    $projects = $pdo->query("SELECT id, nama_proyek FROM projects")->fetchAll();
} else {
    $stmt = $pdo->prepare("SELECT id, nama_proyek FROM projects WHERE manager_id = ?");
    $stmt->execute([$user['id']]);
    $projects = $stmt->fetchAll();
}
if ($user['role'] === 'superadmin') {
    $members = $pdo->query("SELECT id, username FROM users WHERE role='team_member'")->fetchAll();
} else {
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE role='team_member' AND project_manager_id = ?");
    $stmt->execute([$user['id']]);
    $members = $stmt->fetchAll();
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title><?= $editing ? 'Edit' : 'Tambah' ?> Tugas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4">
<div class="container col-md-8">
  <h3><?= $editing ? 'Edit' : 'Tambah' ?> Tugas</h3>
  
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>
  <form method="post">
    <div class="mb-2"><label>Nama Tugas</label><input class="form-control" name="nama_tugas" value="<?=htmlspecialchars($task['nama_tugas'])?>" required></div>
    <div class="mb-2"><label>Deskripsi</label><textarea class="form-control" name="deskripsi"><?=htmlspecialchars($task['deskripsi'])?></textarea></div>
    <div class="mb-2">
      <label>Project</label>
      <select name="project_id" class="form-select" required>
        <option value="">-- Pilih Proyek --</option>
        <?php foreach($projects as $p): ?>
          <option value="<?=$p['id']?>" <?= $task['project_id']==$p['id'] ? 'selected':'' ?>><?=$p['nama_proyek']?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-2">
      <label>Assigned To (Team Member)</label>
      <select name="assigned_to" class="form-select">
        <option value="">-- pilih --</option>
        <?php foreach($members as $m): ?>
          <option value="<?=$m['id']?>" <?= $task['assigned_to']==$m['id'] ? 'selected':'' ?>><?=$m['username']?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-2">
      <label>Status</label>
      <select name="status" class="form-select">
        <option value="belum" <?= $task['status']=='belum' ? 'selected':'' ?>>belum</soption>
        <option value="proses" <?= $task['status']=='proses' ? 'selected':'' ?>>proses</option>
        <option value="selesai" <?= $task['status']=='selesai' ? 'selected':'' ?>>selesai</option>
      </select>
    </div>
    <button class="btn btn-primary">Simpan</button>
  </form>
  <a href="tasks.php<?= $task['project_id'] ? '?project_id='.$task['project_id'] : '' ?>">Kembali</a>
</div>
</body></html>