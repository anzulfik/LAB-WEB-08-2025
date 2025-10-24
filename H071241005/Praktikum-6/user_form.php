<?php
require 'functions.php';
require_login();
require_role(['superadmin']);

$id = $_GET['id'] ?? null;
$editing = $id !== null;

$error = '';
$u = ['username'=>'','role'=>'project_manager','project_manager_id'=>null];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'] ?: null;
    $role = $_POST['role'];
    $pm = $_POST['project_manager_id'] ?: null;

    $u['username'] = $username;
    $u['role'] = $role;
    $u['project_manager_id'] = $pm;

    if (empty($username)) {
        $error = "Username wajib diisi.";
    }

    if (empty($error) && !$editing && empty($password)) {
        $error = "Password wajib diisi untuk user baru.";
    }
    
    if (empty($error)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $stmt->execute([$username, $id ?? 0]);
        if ($stmt->fetch()) {
            $error = "Username sudah digunakan.";
        }
    }

    if (empty($error) && $role === 'team_member' && empty($pm)) {
        $error = "Team Member harus memilih Project Manager.";
    }
    
    if ($role === 'project_manager' && !empty($pm)) {
        $pm = null;
        $u['project_manager_id'] = null;
    }

    if (empty($error)) {
        if ($editing) {
            if ($password) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET username=?, password=?, role=?, project_manager_id=? WHERE id=?");
                $stmt->execute([$username, $hash, $role, $pm, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET username=?, role=?, project_manager_id=? WHERE id=?");
                $stmt->execute([$username, $role, $pm, $id]);
            }
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $hash, $role, $pm]);
        }
        header("Location: users.php");
        exit;
    }

} elseif ($editing) { 
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $u = $stmt->fetch();
    if (!$u) { echo "User tidak ditemukan"; exit; }
}

$allPM = $pdo->query("SELECT id, username FROM users WHERE role='project_manager'")->fetchAll();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title><?= $editing ? 'Edit':'Tambah' ?> User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4">
<div class="container col-md-6">
  <h3><?= $editing ? 'Edit':'Tambah' ?> User</h3>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>
  <form method="post">
    <div class="mb-2"><label>Username</label><input class="form-control" name="username" value="<?=htmlspecialchars($u['username'])?>" required></div>
    <div class="mb-2"><label>Password <?php if($editing) echo '(kosong = tidak diubah)'; ?></label><input class="form-control" name="password" type="password" <?= $editing ? '':'required' ?>></div>
    <div class="mb-2">
      <label>Role</label>
      <select class="form-select" name="role" required>
        <option value="project_manager" <?= $u['role']=='project_manager' ? 'selected':'' ?>>Project Manager</option>
        <option value="team_member" <?= $u['role']=='team_member' ? 'selected':'' ?>>Team Member</option>
      </select>
    </div>
    <div class="mb-2">
      <label>Project Manager (wajib jika membuat Team Member)</label>
      <select class="form-select" name="project_manager_id">
        <option value="">-- pilih --</option>
        <?php foreach($allPM as $pm): ?>
          <option value="<?=$pm['id']?>" <?= $u['project_manager_id']==$pm['id'] ? 'selected':'' ?>><?=$pm['username']?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <button class="btn btn-primary">Simpan</button>
  </form>
  <a href="users.php">Kembali</a>
</div>
</body>
</html>