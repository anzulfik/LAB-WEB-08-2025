<?php
session_start();
require 'koneksi.php';

//atasi anomali url
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    die("Akses ditolak.");
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
$project_id_to_delete = $_GET['id'];

if ($role == 'Project Manager') {
    //hapus untuk manajer
    $sql = "DELETE FROM projects WHERE id = ? AND manager_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $project_id_to_delete, $user_id);

} else if ($role == 'Super Admin') {
    //hapus untuk admin
    $sql = "DELETE FROM projects WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $project_id_to_delete);

}

if (mysqli_stmt_execute($stmt)) {
    // Cek apakah ada baris yang terhapus
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: dashboard.php?status=proyek_hapus_sukses");
    } else {
        //error kalo mencoba hapus proyek orang lain
        die("Error: Proyek tidak ditemukan atau Anda tidak punya hak akses.");
    }
} else {
    echo "Error: " . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>