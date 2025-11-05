<?php
require 'config.php';

$username = 'superadmin';
$passwordPlain = 'admin123';
$role = 'superadmin';

$hash = password_hash($passwordPlain, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->execute([$username, $hash, $role]);

echo "Superadmin berhasil dibuat!<br>";
echo "Username: superadmin<br>Password: admin123<br>";
echo "Hapus file init_admin.php setelah login pertama.";
