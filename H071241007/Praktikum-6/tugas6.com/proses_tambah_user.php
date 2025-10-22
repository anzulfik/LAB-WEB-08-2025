<?php
session_start();
require 'koneksi.php';

//khusus sosok asli admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Super Admin') {
    die("Akses ditolak.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    //cek username
    $sql_check = "SELECT id FROM users WHERE username = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $username);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);
    
    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        //error usn unique
        $error_msg = urlencode("Error: Username '" . $username . "' sudah terpakai.");
        header("Location: kelola_user.php?error=" . $error_msg);
        exit();
    }
    mysqli_stmt_close($stmt_check);
    
    //hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $project_manager_id = NULL;
    
    //cek role team member
    if ($role == 'Team Member') {
        if (empty($_POST['project_manager_id'])) {
            $error_msg = urlencode("Error: Team Member harus memiliki Project Manager.");
            header("Location: kelola_user.php?error=" . $error_msg);
            exit();
        }
        $project_manager_id = $_POST['project_manager_id'];
    }

    //query add user baru
    $sql_insert = "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, "sssi", $username, $hashed_password, $role, $project_manager_id);
    
    if (mysqli_stmt_execute($stmt_insert)) {
        header("Location: kelola_user.php?status=sukses");
    } else {
        echo "Error: " . mysqli_stmt_error($stmt_insert);
    }
    
    mysqli_stmt_close($stmt_insert);
    mysqli_close($conn);
}
?>