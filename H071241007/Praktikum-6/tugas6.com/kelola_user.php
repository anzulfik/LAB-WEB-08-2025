<?php
session_start();
require 'koneksi.php';

//khusus admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Super Admin') {
    die("Akses ditolak.");
}

$error_message = '';
$success_message = '';
if (isset($_GET['error'])) {
    $error_message = htmlspecialchars($_GET['error']);
}
if (isset($_GET['status']) && $_GET['status'] == 'sukses') {
    $success_message = "User baru berhasil ditambahkan!";
}
if (isset($_GET['status']) && $_GET['status'] == 'hapus_sukses') {
    $success_message = "User berhasil dihapus.";
}
if (isset($_GET['status']) && $_GET['status'] == 'pm_assigned') {
    $success_message = "Project Manager berhasil di-update!";
}

//ambil data manajer untuk dropdown
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
    <title>Kelola User :: Mission Control</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h1>Kelola User</h1>
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>

    <div class="container">
        <div class="form-tambah">
            <h3>Tambah User Baru</h3>

            <?php if (!empty($error_message)): ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <?php if (!empty($success_message)): ?>
                <div class="sukses"><?php echo $success_message; ?></div>
            <?php endif; ?>

            <form action="proses_tambah_user.php" method="POST">
                <div>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <label for="role">Role:</label>
                    <select id="role" name="role" required onchange="togglePMLabel(this.value)">
                        <option value="">-- Pilih Role --</option>
                        <option value="Project Manager">Project Manager</option>
                        <option value="Team Member">Team Member</option>
                    </select>
                </div>
                <div id="pm_selector" style="display:none;">
                    <label for="project_manager_id">Project Manager-nya:</label>
                    <select id="project_manager_id" name="project_manager_id">
                        <option value="">-- Pilih PM --</option>
                        <?php foreach ($project_managers as $pm): ?>
                            <option value="<?php echo $pm['id']; ?>"><?php echo htmlspecialchars($pm['username']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit">Tambah User</button>
            </form>
        </div>

        <hr>

        <h3>Daftar User Saat Ini</h3>
        
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Manajer (jika TM)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //ambil semua user kecuali admin
                $sql_users = "SELECT u1.*, u2.username AS manager_name FROM users u1 LEFT JOIN users u2 ON u1.project_manager_id = u2.id WHERE u1.role != 'Super Admin' ORDER BY u1.role, u1.username";
                $result_users = mysqli_query($conn, $sql_users);
                
                while($user = mysqli_fetch_assoc($result_users)):
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td>
                            <?php 
                                //cek member yatim
                                if (empty($user['manager_name']) && $user['role'] == 'Team Member') {
                                    echo '<span style="color: #d9534f;">N/A</span>';
                                } else {
                                    echo htmlspecialchars($user['manager_name'] ?? 'N/A');
                                }
                            ?>
                        </td>
                        <td class="action-links">
                            <?php 
                                //tampilkan tombol edit jika role nya member
                                if ($user['role'] == 'Team Member'): 
                            ?>
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="edit">Edit PM</a> | 
                            <?php endif; ?>
                            
                            <a href="proses_hapus_user.php?id=<?php echo $user['id']; ?>" class="delete" onclick="return confirm('Anda yakin ingin menghapus user ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>

    <script>
        //js untuk dropdown
        function togglePMLabel(role) {
            var pmSelector = document.getElementById('pm_selector');
            var pmInput = document.getElementById('project_manager_id');
            if (role === 'Team Member') {
                pmSelector.style.display = 'block';
                pmInput.required = true;
            } else {
                pmSelector.style.display = 'none';
                pmInput.required = false;
            }
        }
    </script>
</body>
</html>