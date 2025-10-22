<?php
session_start();
require 'koneksi.php';

//khusus manajer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Project Manager') {
    die("Akses ditolak. Hanya Project Manager yang boleh membuat proyek.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama_proyek = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $manager_id = $_SESSION['user_id']; 

    $sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)";
            
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $manager_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php?status=proyek_sukses");
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} else {
    header("Location: buat_proyek.php");
    exit();
}
?>