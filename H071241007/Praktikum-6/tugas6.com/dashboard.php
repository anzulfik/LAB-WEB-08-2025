<?php
session_start();
require 'koneksi.php';

//atasi anomali url
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: login.php?error=Anda harus login");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - <?php echo htmlspecialchars($role); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="header">
        <h1>Manajemen Proyek</h1>
        <div>
            <span>Halo, <?php echo htmlspecialchars($username); ?>!</span>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome">
            Selamat Datang, <strong><?php echo htmlspecialchars($username); ?></strong>
            <span class="role-badge"><?php echo htmlspecialchars($role); ?></span>
        </div>

        <hr>

        <?php if ($role == 'Super Admin'): ?>
            <h2>Panel Super Admin</h2>
            <div class="menu">
                <a href="kelola_user.php">Kelola Semua User</a>
            </div>
            
            <h3>Daftar Seluruh Proyek</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Proyek</th>
                        <th>Manajer Proyek</th>
                        <th>Tanggal Mulai</th>
                        <th>Target Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //admin bisa lihat semua proyek dan nama manajernya
                    $sql = "SELECT p.*, u.username AS manager_name FROM projects p JOIN users u ON p.manager_id = u.id ORDER BY p.tanggal_mulai DESC";
                    $result = mysqli_query($conn, $sql);
                    while($proyek = mysqli_fetch_assoc($result)):
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($proyek['nama_proyek']); ?></td>
                            <td><?php echo htmlspecialchars($proyek['manager_name']); ?></td>
                            <td><?php echo $proyek['tanggal_mulai']; ?></td>
                            <td><?php echo $proyek['tanggal_selesai']; ?></td>
                            <td class="action-links">
                                <a href="hapus_proyek.php?id=<?php echo $proyek['id']; ?>" class="delete" onclick="return confirm('Anda yakin ingin menghapus proyek ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        <?php elseif ($role == 'Project Manager'): ?>
            <h2>Panel Project Manager</h2>
            <div class="menu">
                <a href="buat_proyek.php">Buat Proyek Baru</a>
            </div>

            <h3>Proyek Milik Anda</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Proyek</th>
                        <th>Tanggal Mulai</th>
                        <th>Target Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //manajer cuma bisa lihat proyeknya sendiri (manager_id = user_id)
                    $sql = "SELECT * FROM projects WHERE manager_id = ? ORDER BY tanggal_mulai DESC";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $user_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while($proyek = mysqli_fetch_assoc($result)):
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($proyek['nama_proyek']); ?></td>
                            <td><?php echo $proyek['tanggal_mulai']; ?></td>
                            <td><?php echo $proyek['tanggal_selesai']; ?></td>
                            <td class="action-links">
                                <a href="kelola_tugas.php?project_id=<?php echo $proyek['id']; ?>">Kelola Tugas</a>
                                <a href="edit_proyek.php?id=<?php echo $proyek['id']; ?>" class="edit">Edit</a>
                                <a href="hapus_proyek.php?id=<?php echo $proyek['id']; ?>" class="delete" onclick="return confirm('Anda yakin ingin menghapus proyek ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        <?php elseif ($role == 'Team Member'): ?>
            <h2>Panel Team Member</h2>
            <p>Berikut adalah daftar tugas yang ditugaskan kepada Anda.</p>
            
            <h3>Tugas Saya</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Tugas</th>
                        <th>Proyek</th>
                        <th>Status</th>
                        <th>Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //member cuma bisa lihat tugas yang assigned_to = user_id
                    $sql = "SELECT t.*, p.nama_proyek 
                            FROM tasks t 
                            JOIN projects p ON t.project_id = p.id 
                            WHERE t.assigned_to = ? 
                            ORDER BY p.nama_proyek, t.status";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $user_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while($tugas = mysqli_fetch_assoc($result)):
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($tugas['nama_tugas']); ?></td>
                            <td><?php echo htmlspecialchars($tugas['nama_proyek']); ?></td>
                            <td><?php echo htmlspecialchars($tugas['status']); ?></td>
                            <td>
                                <form action="proses_update_status_tugas.php" method="POST" style="margin:0;">
                                    <input type="hidden" name="task_id" value="<?php echo $tugas['id']; ?>">
                                    <select name="status_baru" onchange="this.form.submit()">
                                        <option value="belum" <?php if($tugas['status'] == 'belum') echo 'selected'; ?>>Belum</option>
                                        <option value="proses" <?php if($tugas['status'] == 'proses') echo 'selected'; ?>>Proses</option>
                                        <option value="selesai" <?php if($tugas['status'] == 'selesai') echo 'selected'; ?>>Selesai</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
    </div>
</body>
</html>