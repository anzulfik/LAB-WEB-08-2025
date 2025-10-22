<?php
session_start();
require 'koneksi.php';

//khusus manager
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Project Manager') {
    die("Akses ditolak.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //cek isi form
    $pm_id = $_SESSION['user_id'];
    $project_id = $_POST['project_id'];
    $nama_proyek = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    //update proyek
    $sql = "UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ? WHERE id = ? AND manager_id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssii", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $project_id, $pm_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php?status=proyek_update_sukses");
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>