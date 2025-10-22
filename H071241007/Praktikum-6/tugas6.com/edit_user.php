<?php
session_start();
require 'koneksi.php';

//khusus sosok asli admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Super Admin') {
    die("Akses ditolak.");
}

//ambil id
$tm_id = $_GET['id'];

//ambil data sesuai dengan id yang diambil di atas
$sql_tm = "SELECT username, project_manager_id FROM users WHERE id = ? AND role = 'Team Member'";
$stmt_tm = mysqli_prepare($conn, $sql_tm);
mysqli_stmt_bind_param($stmt_tm, "i", $tm_id);
mysqli_stmt_execute($stmt_tm);
$result_tm = mysqli_stmt_get_result($stmt_tm);
$tm = mysqli_fetch_assoc($result_tm);

if (!$tm) {
    die("Team Member tidak ditemukan.");
}

// Simpan ID PM saat ini
$current_pm_id = $tm['project_manager_id'];

// 3. Ambil daftar SEMUA Project Manager
$sql_pm = "SELECT id, username FROM users WHERE role = 'Project Manager'";
$result_pm = mysqli_query($conn, $sql_pm);
$project_managers = [];
while ($row = mysqli_fetch_assoc($result_pm)) {
    $project_managers[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Project Manager :: Mission Control</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h1>Edit Project Manager</h1>
        <a href="kelola_user.php">Batal</a>
    </div>

    <div class="container">
        <div class="form-tambah" style="max-width: 500px; margin: auto;">
            <h3>Edit PM untuk: <?php echo htmlspecialchars($tm['username']); ?></h3>
            
            <form action="proses_edit_user.php" method="POST">
                <input type="hidden" name="tm_id" value="<?php echo $tm_id; ?>">
                
                <div>   
                    <label for="project_manager_id">Project Manager:</label>
                    <select id="project_manager_id" name="project_manager_id" required>
                        <option value="">-- Pilih PM --</option>
                        
                        <?php foreach ($project_managers as $pm): ?>
                            
                            <option value="<?php echo $pm['id']; ?>" <?php if ($pm['id'] == $current_pm_id) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($pm['username']); ?>
                            </option>
                        
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit">Update Manager</button>
            </form>
        </div>
    </div>
</body>
</html>