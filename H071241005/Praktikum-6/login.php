<?php
session_start();
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
 
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login - Manajemen Proyek</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f8f9fa;
        font-family: "Inter", sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }
    .card {
        width: 360px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 2rem;
        background-color: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    h3 {
        text-align: center;
        margin-bottom: 1.5rem;
        font-weight: 600;
        color: #333;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0069d9;
    }
    label {
        font-weight: 500;
        color: #555;
    }
</style>
</head>
<body>
    <div class="card">
        <h3>Login</h3>
        <?php if($error): ?>
            <div class="alert alert-danger text-center py-2"><?=$error?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100 py-2">Masuk</button>
        </form>
    </div>
</body>
</html>
