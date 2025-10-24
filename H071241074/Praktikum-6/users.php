<?php
session_start();
include "db.php";

if (!isset($_SESSION['user']) || strtolower($_SESSION['user']['role']) !== 'super admin') {
    echo "<p class='text-red-600 font-bold'>Access Denied!</p>";
    exit;
}

$user = $_SESSION['user'];
$role = strtolower($user['role']); 
$uid = $user['id'];

if (isset($_POST['add_user'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_user = strtolower($_POST['role']); 
    $pm_id = $_POST['project_manager_id'] ?: null;

    $stmt = mysqli_prepare($conn, "INSERT INTO users(username, password, role, project_manager_id) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $username, $password, $role_user, $pm_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if (isset($_POST['delete_user']) && !empty($_POST['user_id'])) {
    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $_POST['user_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

$result = mysqli_query($conn, "
    SELECT u.id, u.username, u.role, u.project_manager_id, pm.username AS pm_name FROM users u LEFT JOIN users pm ON u.project_manager_id = pm.id ORDER BY u.id ASC
");
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

$result = mysqli_query($conn, "SELECT id, username FROM users WHERE role = 'project manager'");
$pms = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Users - <?= htmlspecialchars(ucwords($role)) ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="style.css">
</head>
<body class="relative min-h-screen pixel-font overflow-x-hidden bg-center" style="background-image: url('asset/bg-dash-tuprak6.png'); background-repeat: repeat-y; background-size: contain; background-position: top center;">
<div class="absolute inset-0 pointer-events-none select-none z-20" style="background-image: url('asset/bg-hiasan-tp6.png'); background-repeat: repeat-y; background-size: contain; background-position: center top;"></div>

<div class="w-full max-w-6xl mx-auto mt-6 border-retro-window shadow-[4px_4px_0_0_#000000] relative z-30">
    <div class="retro-header flex justify-between items-center">
        <span>TUPRAK USERS - <?= htmlspecialchars(ucwords($role)) ?></span>
        <div class="flex items-center space-x-4">
            <span class="text-sm">Halo, <b><?= htmlspecialchars($user['username']) ?></b></span>
            <div class="flex gap-1">
                <div class="btn">_</div>
                <div class="btn">□</div>
                <div class="btn">X</div>
            </div>
        </div>
    </div>

    <div class="retro-nav">
        <a href="dashboard.php">Dashboard</a>
        <?php if ($role === 'super admin'): ?>
            <a href="users.php">Kelola User</a>
            <a href="projects.php">Semua Project</a>
        <?php elseif ($role === 'project manager'): ?>
            <a href="projects.php">Project Saya</a>
            <a href="tasks.php">Tugas Tim</a>
        <?php elseif ($role === 'team member'): ?>
            <a href="projects.php">Project Saya</a>
            <a href="tasks.php">Tugas Saya</a>
        <?php endif; ?>
        <a href="logout.php" class="ml-auto text-red-700 font-bold">⏻ Logout</a>
    </div>
</div>

<div class="relative z-30 max-w-[1010px] mx-auto mt-6 px-4">
    <div class="border-retro-window p-4 bg-[#C3C3C3] shadow-[4px_4px_0_0_#000000]">
        <h2 class="text-lg font-bold mb-4">Tambah User Baru</h2>

        <form method="POST" class="mb-6 space-y-2">
            <input type="text" name="username" placeholder="Username" class="border-retro-input p-1 w-full" required>
            <input type="password" name="password" placeholder="Password" class="border-retro-input p-1 w-full" required>

            <select name="role" id="role-select" class="border-retro-input p-1 w-full" required onchange="togglePMSelect()">
                <option value="">-- Pilih Role --</option>
                <option value="project manager">Project Manager</option>
                <option value="team member">Team Member</option>
            </select>

            <div id="pm-select-container" class="hidden">
                <select name="project_manager_id" class="border-retro-input p-1 w-full" required>
                    <option value="">-- Pilih Project Manager --</option>
                    <?php
                    $result = mysqli_query($conn, "SELECT id, username FROM users WHERE role='project manager'");
                    while ($m = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$m['id']}'>{$m['username']}</option>";
                    }
                    mysqli_free_result($result);
                    ?>
                </select>
            </div>
            <button type="submit" name="add_user" class="retro-button px-4 py-1">Add User</button>
        </form>

        <table class="border-collapse border border-black w-full text-sm">
            <tr class="bg-[#C3C3C3]">
                <th class="border border-black p-1">Username</th>
                <th class="border border-black p-1">Role</th>
                <th class="border border-black p-1">Project Manager</th>
                <th class="border border-black p-1">Action</th>
            </tr>
            <?php foreach ($users as $u): ?>
                <tr class="hover:bg-gray-100">
                    <td class="border border-black p-1"><?= htmlspecialchars($u['username']) ?></td>
                    <td class="border border-black p-1"><?= htmlspecialchars(ucwords($u['role'])) ?></td>
                    <td class="border border-black p-1"><?= htmlspecialchars($u['pm_name'] ?? '-') ?></td>
                    <td class="border border-black p-1 text-center">
                        <button type="button" class="retro-button bg-red-600 text-white px-2 py-1"
                                onclick="openRetroPopup('<?= $u['id'] ?>')">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<div id="retro-popup" class="fixed inset-0 bg-black/50 items-center justify-center z-50">
    <div class="bg-[#C3C3C3] border-retro-window p-4 w-80 shadow-[4px_4px_0_0_#000000] animate-popup">
        <div class="retro-header">
            <span>⚠️ Konfirmasi</span>
            <div class="buttons">
                <div class="btn" onclick="closeRetroPopup()">X</div>
            </div>
        </div>
        <div class="p-3 text-center">
            <p class="mb-3 font-bold">Yakin ingin menghapus user ini?</p>
            <form method="POST">
                <input type="hidden" name="user_id" id="popupUserId" required>
                <button type="submit" name="delete_user" class="retro-button bg-red-600 text-white px-3 py-1 mx-1">Ya</button>
                <button type="button" onclick="closeRetroPopup()" class="retro-button bg-gray-300 px-3 py-1 mx-1">Tidak</button>
            </form>
        </div>
    </div>
</div>

<script>
function togglePMSelect() {
    const role = document.getElementById('role-select').value;
    const pmContainer = document.getElementById('pm-select-container');
    pmContainer.classList.toggle('hidden', role !== 'team member');
}

function openRetroPopup(userId) {
    document.getElementById('popupUserId').value = userId;
    const popup = document.getElementById('retro-popup');
    popup.classList.remove('hidden'); 
    popup.classList.add('active'); 
    popup.classList.remove('flex'); 
}

function closeRetroPopup() {
    const popup = document.getElementById('retro-popup');
    popup.classList.add('hidden'); 
    popup.classList.remove('active'); 
}
</script>
</body>
</html>
