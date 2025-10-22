<?php
session_start();
require 'koneksi.php';

//khusus manajer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Project Manager') {
    die("Akses ditolak.");
}

$pm_id = $_SESSION['user_id'];
$task_id_to_edit = $_GET['id'];

//ambil data tugas
$sql_task = "SELECT * FROM tasks WHERE id = ?";
$stmt_task = mysqli_prepare($conn, $sql_task);
mysqli_stmt_bind_param($stmt_task, "i", $task_id_to_edit);
mysqli_stmt_execute($stmt_task);
$result_task = mysqli_stmt_get_result($stmt_task);
$task = mysqli_fetch_assoc($result_task);

if (!$task) {
    die("Tugas tidak ditemukan.");
}
mysqli_stmt_close($stmt_task);

// Verifikasi: Cek apakah tugas ini ada di dalam proyek milik PM
$project_id = $task['project_id'];
$sql_check = "SELECT id FROM projects WHERE id = ? AND manager_id = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, "ii", $project_id, $pm_id);
mysqli_stmt_execute($stmt_check);

mysqli_stmt_store_result($stmt_check);

if (mysqli_stmt_num_rows($stmt_check) == 0) {
    die("Akses ditolak. Anda bukan manajer proyek untuk tugas ini.");
}


//cari member yang dimanajeri oleh manajer ini
$sql_tm = "SELECT id, username FROM users WHERE role = 'Team Member' AND project_manager_id = ?";
$stmt_tm = mysqli_prepare($conn, $sql_tm);
mysqli_stmt_bind_param($stmt_tm, "i", $pm_id);
mysqli_stmt_execute($stmt_tm);
$team_members_result = mysqli_stmt_get_result($stmt_tm);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tugas :: Mission Control</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <div class="container">
        <a href="kelola_tugas.php?project_id=<?php echo $project_id; ?>">&larr; Batal</a>
        <h2>Edit Tugas</h2>
        
        <form action="proses_edit_tugas.php" method="POST">
            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
            
            <div>
                <label for="nama_tugas">Nama Tugas:</label>
                <input type="text" id="nama_tugas" name="nama_tugas" value="<?php echo htmlspecialchars($task['nama_tugas']); ?>" required>
            </div>
            <div>
                <label for="deskripsi">Deskripsi Tugas:</label>
                <textarea id="deskripsi" name="deskripsi"><?php echo htmlspecialchars($task['deskripsi']); ?></textarea>
            </div>
            <div>
                <label for="assigned_to">Tugaskan Kepada:</label>
                <select id="assigned_to" name="assigned_to" required>
                    <option value="">-- Pilih Team Member --</option>
                    <?php
                    while ($tm = mysqli_fetch_assoc($team_members_result)) {
                        $selected = ($tm['id'] == $task['assigned_to']) ? 'selected' : '';
                        echo '<option value="' . $tm['id'] . '" ' . $selected . '>' . htmlspecialchars($tm['username']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="belum" <?php if($task['status'] == 'belum') echo 'selected'; ?>>Belum</option>
                    <option value="proses" <?php if($task['status'] == 'proses') echo 'selected'; ?>>Proses</option>
                    <option value="selesai" <?php if($task['status'] == 'selesai') echo 'selected'; ?>>Selesai</option>
                </select>
            </div>
            <button type="submit">Update Tugas</button>
        </form>
    </div>
</body>
</html>