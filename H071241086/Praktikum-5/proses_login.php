<?php
session_start();

$username_input = $_POST['username']; 
$password_input = $_POST['password']; 

include 'data.php';

$login_berhasil = false;  
$user_ditemukan = null;   

foreach ($users as $user) {
    if ($user['username'] === $username_input) {
        $user_ditemukan = $user;
        break; 
    }
}

if ($user_ditemukan) {
    if (password_verify($password_input, $user_ditemukan['password'])) {
        $_SESSION['user'] = $user_ditemukan;
        $login_berhasil = true;
    }
}

if ($login_berhasil) {
    header("Location: dashboard.php");
    exit;
} else {
    $_SESSION['error'] = "Username atau password salah!";
    header("Location: login.php");
    exit;
}
?>
