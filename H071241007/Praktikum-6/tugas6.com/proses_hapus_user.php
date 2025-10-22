<?php
session_start();
require 'koneksi.php';

//khusus sosok asli Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Super Admin') {
    die("Akses ditolak.");
}

$user_id_to_delete = $_GET['id'];

//cek apakah manajer ini punya proyek?
$sql_check = "SELECT COUNT(*) AS project_count FROM projects WHERE manager_id = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, "i", $user_id_to_delete);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);
$row = mysqli_fetch_assoc($result_check);

if ($row['project_count'] > 0) {
    $error_msg = urlencode("Error: Tidak bisa menghapus PM ini. Dia masih memiliki " . $row['project_count'] . " proyek. Hapus dulu proyeknya.");
    header("Location: kelola_user.php?error=" . $error_msg);
    exit();
}
mysqli_stmt_close($stmt_check);


$sql_delete = "DELETE FROM users WHERE id = ?";
$stmt_delete = mysqli_prepare($conn, $sql_delete);
mysqli_stmt_bind_param($stmt_delete, "i", $user_id_to_delete);

if (mysqli_stmt_execute($stmt_delete)) {
    header("Location: kelola_user.php?status=hapus_sukses");
} else {
    $error_msg = urlencode("Error: User tidak bisa dihapus, mungkin masih terkait data lain.");
    header("Location: kelola_user.php?error=" . $error_msg);
}

mysqli_stmt_close($stmt_delete);
mysqli_close($conn);
?>