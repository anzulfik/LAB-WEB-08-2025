<?php

require 'functions.php';
require_login();
require_role(['superadmin']);

$user = current_user();

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: users.php");
    exit;
}

$stmt = $pdo->query("SELECT id, username, role, project_manager_id FROM users WHERE role IN ('project_manager','team_member') ORDER BY role, username");
$users = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4">
<div class="container">
  <h3>Manajemen Users</h3>
  <a class="btn btn-success mb-2" href="user_form.php">Tambah User</a>
  <table class="table table-striped">
    <thead><tr><th>ID</th><th>Username</th><th>Role</th><th>Project Manager</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach($users as $u): ?>
      <tr>
        <td><?=$u['id']?></td>
        <td><?=htmlspecialchars($u['username'])?></td>
        <td><?=$u['role']?></td>
        <td><?=$u['project_manager_id'] ?? '-'?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="user_form.php?id=<?=$u['id']?>">Edit</a>
          <a class="btn btn-sm btn-danger" href="users.php?delete=<?=$u['id']?>" onclick="return confirm('Hapus?')">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <a href="dashboard.php">Kembali</a>
</div>
</body>
</html>
