<?php
session_start();
require 'koneksi.php';

//khusus member
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Team Member') {
    die("Akses ditolak.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tm_id = $_SESSION['user_id'];
    $task_id = $_POST['task_id'];
    $status_baru = $_POST['status_baru'];

    $sql = "UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sii", $status_baru, $task_id, $tm_id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php?status=update_sukses");
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>