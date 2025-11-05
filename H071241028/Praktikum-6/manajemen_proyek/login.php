<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Username dan password tidak boleh kosong!';
        header("Location: login.php");
        exit();
    }

    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            switch ($row['role']) {
                case 'superadmin':
                    header("Location: dashboard_superadmin.php");
                    exit();
                case 'manager':
                    header("Location: dashboard_manager.php");
                    exit();
                case 'member':
                    header("Location: dashboard_member.php");
                    exit();
            }
        } else {
            $_SESSION['error'] = 'Password salah!';
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = 'Username tidak ditemukan!';
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ZR Manajemen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: radial-gradient(circle at top left, #330030, #0a0010);
            color: #fce7f3;
            font-family: 'Poppins', sans-serif;
        }
        .glow {
            box-shadow: 0 0 20px rgba(255, 0, 128, 0.5);
        }
        .glow-text {
            text-shadow: 0 0 10px #ff4fc3, 0 0 20px #ff4fc3;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4">

    <div class="bg-[#1a001f]/90 border border-pink-600 rounded-2xl p-8 w-full max-w-md glow backdrop-blur-sm">
        <h1 class="text-center text-4xl font-extrabold text-pink-400 glow-text mb-3">ZR Manajemen</h1>
        <p class="text-center text-pink-300 mb-6 tracking-wide">Login ke Sistem Manajemen Proyek</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-pink-900/40 border border-pink-600 text-pink-200 px-4 py-2 rounded mb-4 text-center">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-pink-300 mb-1">Username</label>
                <input type="text" name="username" placeholder="Masukkan username"
                       class="w-full p-3 bg-[#100010] border border-pink-700 rounded-lg text-white placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-pink-300 mb-1">Password</label>
                <input type="password" name="password" placeholder="Masukkan password"
                       class="w-full p-3 bg-[#100010] border border-pink-700 rounded-lg text-white placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-500" required>
            </div>

            <button type="submit"
                    class="w-full py-3 bg-pink-600 hover:bg-pink-700 text-white font-semibold rounded-lg transition duration-300 glow">
                MASUK
            </button>
        </form>

        <p class="text-center text-sm text-pink-300 mt-6 opacity-80">© <?= date("Y") ?> Dibuat oleh Azzahra</p>
    </div>

</body>
</html>
