<?php
session_start();
require 'koneksi.php';

//khusus manajer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Project Manager') {
    die("Akses ditolak.");
}

$pm_id = $_SESSION['user_id'];
$project_id_to_edit = $_GET['id'];

//ambil data proyek di db
$sql = "SELECT * FROM projects WHERE id = ? AND manager_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $project_id_to_edit, $pm_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$project = mysqli_fetch_assoc($result);

if (!$project) {
    die("Proyek tidak ditemukan atau Anda bukan manajernya.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Proyek</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <a href="dashboard.php">&larr; Batal</a>
        <h2>Edit Proyek</h2>

        <form action="proses_edit_proyek.php" method="POST">
            <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
            <div>
                <label for="nama_proyek">Nama Proyek:</label>
                <input type="text" id="nama_proyek" name="nama_proyek" value="<?php echo htmlspecialchars($project['nama_proyek']); ?>" required>
            </div>
            <div>
                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi"><?php echo htmlspecialchars($project['deskripsi']); ?></textarea>
            </div>
            <div>
                <label for="tanggal_mulai">Tanggal Mulai:</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo $project['tanggal_mulai']; ?>" required>
            </div>
            <div>
                <label for="tanggal_selesai">Tanggal Selesai (Target):</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="<?php echo $project['tanggal_selesai']; ?>">
            </div>
            <button type="submit">Update Proyek</button>
        </form>
    </div>
</body>
</html>