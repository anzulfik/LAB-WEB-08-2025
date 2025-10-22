<?php
session_start();
require 'koneksi.php';

//khusus sosok asli admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Super Admin') {
    header("Location: login.php?error=akses ditolak");
    die();
}

//atasi anomali url
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $tm_id = $_POST['tm_id'];
    $pm_id = $_POST['project_manager_id'];

    if (empty($tm_id) || empty($pm_id)) {
        die("Data tidak lengkap.");
    }

    //update project manager untuk member tersebut
    $sql = "UPDATE users SET project_manager_id = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $pm_id, $tm_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: kelola_user.php?status=pm_assigned");
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} else {
    header("Location: kelola_user.php");
}
?>