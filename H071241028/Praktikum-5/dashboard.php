<?php
// dashboard.php
session_start();
include 'data.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
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
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #3b0a45, #a83279);
            color: #fff;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(0,0,0,0.3);
        }

        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffb6e6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            text-align: left;
        }

        th {
            background-color: rgba(255,255,255,0.2);
            color: #ffe6f7;
        }

        tr:hover {
            background: rgba(255,255,255,0.1);
        }

        .logout {
            display: inline-block;
            margin-top: 25px;
            background: #ff66b2;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
            font-weight: bold;
        }

        .logout:hover {
            background: #d44d99;
        }

        .center {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if ($user['username'] === 'adminxxx'): ?>
        <h2>Selamat Datang, Admin!</h2>
        <h3>Daftar Semua Pengguna</h3>
        <table>
            <tr>
                <th>Email</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Gender</th>
                <th>Fakultas</th>
                <th>Angkatan</th>
            </tr>
            <?php foreach ($users as $u): ?> 
                <tr>
                    <td><?= $u['email'] ?></td>
                    <td><?= $u['username'] ?></td>
                    <td><?= $u['name'] ?></td>
                    <td><?= $u['gender'] ?? '-' ?></td>
                    <td><?= $u['faculty'] ?? '-' ?></td>
                    <td><?= $u['batch'] ?? '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php else: ?>
        <h2>Selamat Datang, <?= htmlspecialchars($user['name']) ?>!</h2>
        <h3>Data Profil Anda</h3>
        <table>
            <tr>
                <th>Email</th>
                <td><?= $user['email'] ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?= $user['username'] ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?= $user['gender'] ?? '-' ?></td>
            </tr>
            <tr>
                <th>Fakultas</th>
                <td><?= $user['faculty'] ?? '-' ?></td>
            </tr>
            <tr>
                <th>Angkatan</th>
                <td><?= $user['batch'] ?? '-' ?></td>
            </tr>
        </table>
    <?php endif; ?>

    <div class="center">
        <a href="logout.php" class="logout">Logout</a>
    </div>
</div>

</body>
</html>
