<?php
session_start();
require 'koneksi.php';

// Hanya PM
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Project Manager') {
    die("Akses ditolak.");
}

$pm_id = $_SESSION['user_id'];
$task_id_to_delete = $_GET['id'];
$project_id = $_GET['project_id']; // Untuk redirect kembali

// // Verifikasi kepemilikan
// $sql_check = "SELECT t.id FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.id = ? AND p.manager_id = ?";
// $stmt_check = mysqli_prepare($conn, $sql_check);
// mysqli_stmt_bind_param($stmt_check, "ii", $task_id_to_delete, $pm_id);
// mysqli_stmt_execute($stmt_check);
// if (mysqli_stmt_num_rows(mysqli_stmt_store_result($stmt_check)) == 0) {
//     die("Akses ditolak. Tugas tidak ditemukan atau bukan milik Anda.");
// }

// Hapus tugas
$sql_delete = "DELETE FROM tasks WHERE id = ?";
$stmt_delete = mysqli_prepare($conn, $sql_delete);
mysqli_stmt_bind_param($stmt_delete, "i", $task_id_to_delete);

if (mysqli_stmt_execute($stmt_delete)) {
    header("Location: kelola_tugas.php?project_id=" . $project_id . "&status=tugas_hapus_sukses");
} else {
    echo "Error: " . mysqli_stmt_error($stmt_delete);
}

mysqli_stmt_close($stmt_check);
mysqli_stmt_close($stmt_delete);
mysqli_close($conn);
?>