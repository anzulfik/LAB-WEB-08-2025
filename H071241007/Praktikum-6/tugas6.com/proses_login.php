<?php
session_start();
require 'koneksi.php';

//atasi anomali url
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password, role FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            
            mysqli_stmt_bind_result($stmt, $user_id, $hashed_password_db, $user_role);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hashed_password_db)) {
                
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user_role;
                
                header("Location: dashboard.php");
                exit();
                
            } else {
                header("Location: login.php?error=Password yang Anda masukkan salah.");
                exit();
            }
        } else {
            //error user tidak ada
            header("Location: login.php?error=Username tidak ditemukan.");
            exit();
        }
        
        mysqli_stmt_close($stmt);
        
    } else {
        header("Location: login.php?error=Terjadi kesalahan sistem.");
        exit();
    }
    
    mysqli_close($conn);

} else {
    header("Location: login.php");
    exit();
}
?>