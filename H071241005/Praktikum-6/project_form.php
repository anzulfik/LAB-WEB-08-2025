<?php
require 'functions.php';
require_login();
$user = current_user();

$id = $_GET['id'] ?? null;
$editing = $id !== null;

if ($user['role'] === 'team_member') { http_response_code(403); exit; }

$error = '';
$project = ['nama_proyek'=>'','deskripsi'=>'','tanggal_mulai'=>'','tanggal_selesai'=>'','manager_id'=>null];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $mulai = $_POST['tanggal_mulai'] ?: null;
    $selesai = $_POST['tanggal_selesai'] ?: null;
    $manager_id = $user['role'] === 'superadmin' ? ($_POST['manager_id']?:null) : $user['id'];
    
    $project = [
        'nama_proyek' => $nama,
        'deskripsi' => $deskripsi,
        'tanggal_mulai' => $mulai,
        'tanggal_selesai' => $selesai,
        'manager_id' => $manager_id
    ];

    if (empty($nama)) {
        $error = "Nama proyek wajib diisi.";
    }

    if (empty($error) && !empty($mulai) && !empty($selesai) && $selesai < $mulai) {
        $error = "Tanggal selesai tidak boleh lebih awal dari tanggal mulai.";
    }

    if (empty($error)) {
        $stmt = $pdo->prepare("SELECT id FROM projects WHERE nama_proyek = ? AND id != ?");
        $stmt->execute([$nama, $id ?? 0]);
        if ($stmt->fetch()) {
            $error = "Nama proyek sudah digunakan. Silakan gunakan nama lain.";
        }
    }

    if (empty($error)) {
        if ($editing) {

            if ($user['role'] === 'project_manager') {
                $stmt = $pdo->prepare("UPDATE projects SET nama_proyek=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=? WHERE id=? AND manager_id=?");
                $stmt->execute([$nama,$deskripsi,$mulai,$selesai,$id,$user['id']]);
            } else {
                $stmt = $pdo->prepare("UPDATE projects SET nama_proyek=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=?, manager_id=? WHERE id=?");
                $stmt->execute([$nama,$deskripsi,$mulai,$selesai,$manager_id,$id]);
            }
        } else {
            $stmt = $pdo->prepare("INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nama,$deskripsi,$mulai,$selesai,$manager_id]);
        }
        header("Location: projects.php");
        exit;
    }

} elseif ($editing) { 
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();
    if (!$project) { echo "Project tidak ditemukan"; exit; }
    if ($user['role']==='project_manager' && $project['manager_id'] != $user['id']) {
        echo "Akses terlarang."; exit;
    }
}

$allPM = $pdo->query("SELECT id, username FROM users WHERE role='project_manager'")->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title><?= $editing ? 'Edit' : 'Tambah' ?> Proyek</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4">
<div class="container col-md-8">
  <h3><?= $editing ? 'Edit' : 'Tambah' ?> Proyek</h3>
  
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>
  <form method="post">
    <div class="mb-2"><label>Nama Proyek</label><input class="form-control" name="nama_proyek" value="<?=htmlspecialchars($project['nama_proyek'])?>" required></div>
    <div class="mb-2"><label>Deskripsi</label><textarea class="form-control" name="deskripsi"><?=htmlspecialchars($project['deskripsi'])?></textarea></div>
    <div class="row">
      <div class="col-md-6 mb-2"><label>Tanggal Mulai</label><input type="date" class="form-control" name="tanggal_mulai" value="<?=$project['tanggal_mulai']?>"></div>
      <div class="col-md-6 mb-2"><label>Tanggal Selesai</label><input type="date" class="form-control" name="tanggal_selesai" value="<?=$project['tanggal_selesai']?>"></div>
    </div>
    <?php if($user['role'] === 'superadmin'): ?>
      <div class="mb-2">
        <label>Manager</label>
        <select class="form-select" name="manager_id">
          <option value="">-- pilih --</option>
          <?php foreach($allPM as $pm): ?>
            <option value="<?=$pm['id']?>" <?= $project['manager_id']==$pm['id'] ? 'selected':'' ?>><?=$pm['username']?></option>
          <?php endforeach; ?>
        </select>
      </div>
    <?php endif; ?>
    <button class="btn btn-primary">Simpan</button>
  </form>
  <a href="projects.php">Kembali</a>
</div>
</body></html>