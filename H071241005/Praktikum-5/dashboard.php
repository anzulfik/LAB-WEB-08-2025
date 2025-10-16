<?php
session_start();
require 'data.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #fff;
            color: #000;
        }
        h1, h2 {
            margin-bottom: 10px;
        }
        a {
            color: #d00;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background: #f5f5f5;
        }
        hr {
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <?php if ($user['username'] === 'adminxxx'): ?>
        <h1>Selamat Datang, Admin!</h1>
        <p><a href="logout.php">Logout</a></p>
        <hr>
        <h2>Data Semua Pengguna</h2>
        <table>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
            </tr>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <h1>Selamat Datang, <?= htmlspecialchars($user['name']) ?>!</h1>
        <p><a href="logout.php">Logout</a></p>
        <hr>
        <h2>Data Akun Anda</h2>
        <table>
            <tr><th>Nama</th><td><?= htmlspecialchars($user['name']) ?></td></tr>
            <tr><th>Username</th><td><?= htmlspecialchars($user['username']) ?></td></tr>
            <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
            <tr><th>Fakultas</th><td><?= htmlspecialchars($user['faculty'] ?? '-') ?></td></tr>
            <tr><th>Angkatan</th><td><?= htmlspecialchars($user['batch'] ?? '-') ?></td></tr>
        </table>
    <?php endif; ?>
</body>
</html>
