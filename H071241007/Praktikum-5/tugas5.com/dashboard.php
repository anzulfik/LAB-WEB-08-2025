<?php
session_start();


if (!isset($_SESSION['user'])) {//cegah anomali url
    header('Location: login.php');
    exit();
}

require 'data.php';

$loggedInUser = $_SESSION['user'];//ambil data
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        a { color: #dc3545; text-decoration: none; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        td:first-child { font-weight: bold; width: 150px; }
    </style>
</head>
<body>

<div class="container">
    <?php if ($loggedInUser['username'] === 'adminxxx') : ?>
        <h1>Selamat Datang, Admin!</h1>
        <p>Anda login sebagai administrator. <a href="logout.php">Logout</a></p>
        <hr>
        <h3>Data Semua Pengguna</h3>
        <table>
            <head>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
            </head>
            <body>
                <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <?php endforeach; ?>
            </body>
        </table>

    <?php else : ?>
        <h1>Selamat Datang, <?php echo htmlspecialchars($loggedInUser['name']); ?>!</h1>
        <p>Anda login sebagai pengguna. <a href="logout.php">Logout</a></p>
        <hr>
        <h3>Data Anda</h3>
        <table>
            <tbody>
                <tr>
                    <td>Nama</td>
                    <td><?php echo htmlspecialchars($loggedInUser['name']); ?></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><?php echo htmlspecialchars($loggedInUser['username']); ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo htmlspecialchars($loggedInUser['email']); ?></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><?php echo htmlspecialchars($loggedInUser['gender']); ?></td>
                </tr>
                <tr>
                    <td>Fakultas</td>
                    <td><?php echo htmlspecialchars($loggedInUser['faculty']); ?></td>
                </tr>
                <tr>
                    <td>Angkatan</td>
                    <td><?php echo htmlspecialchars($loggedInUser['batch']); ?></td>
                </tr>
            </tbody>
        </table>

    <?php endif; ?>
</div>

</body>
</html>