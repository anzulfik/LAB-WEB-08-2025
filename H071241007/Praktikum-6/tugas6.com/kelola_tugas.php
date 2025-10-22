<?php
session_start();
require 'koneksi.php';

//atasi anomali url
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: login.php?error=Akses ditolak");
    exit();
}

$error_message_for_popup = '';
if (isset($_GET['error'])) {
    $error_message_for_popup = htmlspecialchars($_GET['error']);
}

$success_message_for_popup = '';
if (isset($_GET['status']) && $_GET['status'] == 'sukses') {
    $success_message_for_popup = "User baru berhasil ditambahkan!";
}

if ($_SESSION['role'] != 'Project Manager') {
    die("Error: Hanya Project Manager yang boleh mengakses halaman ini.");
}

$logged_in_pm_id = $_SESSION['user_id'];

if (!isset($_GET['project_id'])) {
    die("Error: ID Proyek tidak ditemukan.");
}
$project_id = $_GET['project_id'];

//cek kepemilikan proyekk
$sql_check_owner = "SELECT nama_proyek FROM projects WHERE id = ? AND manager_id = ?";

$stmt_check_owner = mysqli_prepare($conn, $sql_check_owner);
mysqli_stmt_bind_param($stmt_check_owner, "ii", $project_id, $logged_in_pm_id);
mysqli_stmt_execute($stmt_check_owner);

$result_owner = mysqli_stmt_get_result($stmt_check_owner);

if (mysqli_num_rows($result_owner) == 0) {
    die("Akses ditolak: Anda bukan manajer dari proyek ini.");
}
$project = mysqli_fetch_assoc($result_owner);
$nama_proyek = $project['nama_proyek'];
mysqli_stmt_close($stmt_check_owner);


//dorpdown bagian TM
$sql_tm = "SELECT id, username FROM users WHERE role = 'Team Member' AND project_manager_id = ?";
$stmt_tm = mysqli_prepare($conn, $sql_tm);
mysqli_stmt_bind_param($stmt_tm, "i", $logged_in_pm_id);
mysqli_stmt_execute($stmt_tm);
$team_members_result = mysqli_stmt_get_result($stmt_tm);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Tugas Proyek</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <a href="dashboard.php">&larr; Kembali ke Dashboard</a>
        <h2>Kelola Tugas: <?php echo htmlspecialchars($nama_proyek); ?></h2>
        
        <h3>Tambah Tugas Baru</h3>
        
        <?php if(isset($_GET['status']) && $_GET['status'] == 'tugas_sukses'): ?>
            <p style="color: green;">Tugas baru berhasil ditambahkan!</p>
        <?php endif; ?>
         <?php if(isset($_GET['status']) && $_GET['status'] == 'tugas_update_sukses'): ?>
            <p style="color: green;">Tugas berhasil di-update!</p>
        <?php endif; ?>
         <?php if(isset($_GET['status']) && $_GET['status'] == 'tugas_hapus_sukses'): ?>
            <p style="color: green;">Tugas berhasil dihapus!</p>
        <?php endif; ?>
        
        <form action="proses_tambah_tugas.php" method="POST">
            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
            
            <div>
                <label for="nama_tugas">Nama Tugas:</label>
                <input type="text" id="nama_tugas" name="nama_tugas" required>
            </div>
            <div>
                <label for="deskripsi">Deskripsi Tugas:</label>
                <textarea id="deskripsi" name="deskripsi"></textarea>
            </div>
            <div>
                <label for="assigned_to">Tugaskan Kepada:</label>
                <select id="assigned_to" name="assigned_to" required>
                    <option value="">-- Pilih Team Member --</option>
                    <?php

                    mysqli_data_seek($team_members_result, 0); 
                    if (mysqli_num_rows($team_members_result) > 0) {
                        while ($tm = mysqli_fetch_assoc($team_members_result)) {
                            echo '<option value="' . $tm['id'] . '">' . htmlspecialchars($tm['username']) . '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>Anda belum memiliki Team Member</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit">Tambah Tugas</button>
        </form>
        
        <hr style="margin: 30px 0;">

        <h3>Daftar Tugas Saat Ini</h3>
        <ul class="task-list">
            <?php
            $sql_tasks = "SELECT t.*, u.username AS assigned_user FROM tasks t LEFT JOIN users u ON t.assigned_to = u.id WHERE t.project_id = ?";
            $stmt_tasks = mysqli_prepare($conn, $sql_tasks);
            mysqli_stmt_bind_param($stmt_tasks, "i", $project_id);
            mysqli_stmt_execute($stmt_tasks);
            $tasks_result = mysqli_stmt_get_result($stmt_tasks);

            if (mysqli_num_rows($tasks_result) > 0) {
                while ($task = mysqli_fetch_assoc($tasks_result)) {
                    echo '<li class="task-item">';
                    echo '<strong>' . htmlspecialchars($task['nama_tugas']) . '</strong><br>';
                    echo '<p>' . htmlspecialchars($task['deskripsi']) . '</p>';
                    echo 'Status: <span>' . htmlspecialchars($task['status']) . '</span>';
                    echo 'Ditugaskan ke: <span>' . htmlspecialchars($task['assigned_user'] ?? 'N/A') . '</span>';
                    
                    echo '<div style="margin-top: 10px; font-size: 0.9em;">';
                    echo '<a href="edit_tugas.php?id=' . $task['id'] . '" style="color: #f0ad4e;">Edit</a> | ';
                    echo '<a href="hapus_tugas.php?id=' . $task['id'] . '&project_id=' . $project_id . '" style="color: #d9534f;" onclick="return confirm(\'Hapus tugas ini?\')">Hapus</a>';
                    echo '</div>';
                    
                    echo '</li>';
                }
            } else {
                echo '<p>Belum ada tugas untuk proyek ini.</p>';
            }
            ?>
        </ul>

    </div>

</body>
</html>