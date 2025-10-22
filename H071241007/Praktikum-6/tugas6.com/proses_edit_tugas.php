<?php
session_start();
require 'koneksi.php';

// Hanya PM
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Project Manager') {
    die("Akses ditolak.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pm_id = $_SESSION['user_id'];
    $task_id = $_POST['task_id'];
    $project_id = $_POST['project_id'];
    
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi = $_POST['deskripsi'];
    $assigned_to = $_POST['assigned_to'];
    $status = $_POST['status'];

    //veriv kalo ini betul proyeknya
    $sql_check = "SELECT id FROM projects WHERE id = ? AND manager_id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "ii", $project_id, $pm_id);
    mysqli_stmt_execute($stmt_check);

    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) == 0) {
        die("Akses ditolak. Anda bukan manajer proyek ini.");
    }

    //update tugas
    $sql_update = "UPDATE tasks SET nama_tugas = ?, deskripsi = ?, assigned_to = ?, status = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "ssisi", $nama_tugas, $deskripsi, $assigned_to, $status, $task_id);

    if (mysqli_stmt_execute($stmt_update)) {
        header("Location: kelola_tugas.php?project_id=" . $project_id . "&status=tugas_update_sukses");
    } else {
        echo "Error: " . mysqli_stmt_error($stmt_update);
    }
    
    mysqli_stmt_close($stmt_check);
    mysqli_stmt_close($stmt_update);
    mysqli_close($conn);
}
?>