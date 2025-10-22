<?php
session_start();
require 'koneksi.php';

//khusus manajer

//atasi penyusup
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Project Manager') {
    die("Akses ditolak.");
}

$logged_in_pm_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $project_id = $_POST['project_id'];
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi = $_POST['deskripsi'];
    $assigned_to = $_POST['assigned_to'];
    
    //error handling kalo ada yang kosong
    if (empty($project_id) || empty($nama_tugas) || empty($assigned_to)) {
        die("Error: Data tidak lengkap.");
    }

    //cek apakah manajer nya sudah cocok
    $sql_check_owner = "SELECT id FROM projects WHERE id = ? AND manager_id = ?";
    $stmt_check_owner = mysqli_prepare($conn, $sql_check_owner);
    mysqli_stmt_bind_param($stmt_check_owner, "ii", $project_id, $logged_in_pm_id);
    mysqli_stmt_execute($stmt_check_owner);
    $result_owner = mysqli_stmt_get_result($stmt_check_owner);

    if (mysqli_num_rows($result_owner) == 0) {
        die("Akses ditolak: Anda tidak bisa menambah tugas ke proyek ini.");
    }
    mysqli_stmt_close($stmt_check_owner);

    //query tambah tugas
    $sql_insert = "INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to, status) VALUES (?, ?, ?, ?, 'belum')";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    
    mysqli_stmt_bind_param($stmt_insert, "ssii", $nama_tugas, $deskripsi, $project_id, $assigned_to);

    if (mysqli_stmt_execute($stmt_insert)) {
        header("Location: kelola_tugas.php?project_id=" . $project_id . "&status=tugas_sukses");
    } else {
        echo "Error: " . mysqli_stmt_error($stmt_insert);
    }
    
    mysqli_stmt_close($stmt_insert);
    mysqli_close($conn);

} else {
    header("Location: dashboard.php");
}
?>