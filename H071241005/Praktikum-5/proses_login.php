<?php
session_start();
require 'data.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$found = null;

foreach ($users as $user) {
    if ($user['username'] === $username) {
        $found = $user;
        break;
    }
}

if ($found && password_verify($password, $found['password'])) {
    $_SESSION['user'] = $found;
    header("Location: dashboard.php");
    exit;
} else {
    $_SESSION['error'] = "Username atau password salah!";
    header("Location: login.php");
    exit;
}
?>
