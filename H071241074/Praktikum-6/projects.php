<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$role = $user['role'];
$uid = $user['id'];

if (isset($_POST['add_project'])) {
    $nama = $_POST['nama_proyek'];
    $desc = $_POST['deskripsi'];
    $tgl_mulai = $_POST['tanggal_mulai'];
    $tgl_selesai = $_POST['tanggal_selesai'];
    $manager_id = $role == 'super admin' ? $_POST['manager_id'] : $uid;

    $stmt = mysqli_prepare($conn, "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssi", $nama, $desc, $tgl_mulai, $tgl_selesai, $manager_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if (isset($_GET['delete'])) {
    $stmt = mysqli_prepare($conn, "DELETE FROM projects WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $_GET['delete']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: projects.php");
    exit;
}

if (isset($_POST['update_project'])) {
    $id = $_POST['project_id'];
    $nama = $_POST['nama_proyek'];
    $desc = $_POST['deskripsi'];
    $tgl_mulai = $_POST['tanggal_mulai'];
    $tgl_selesai = $_POST['tanggal_selesai'];

    $stmt = mysqli_prepare($conn, "UPDATE projects SET nama_proyek=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=? WHERE id=? AND manager_id=?");
    mysqli_stmt_bind_param($stmt, "ssssii", $nama, $desc, $tgl_mulai, $tgl_selesai, $id, $uid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    // header("Location: projects.php");
    // exit;
}

if ($role == 'super admin') {
    $result = mysqli_query($conn, "
        SELECT p.*, u.username AS manager_name FROM projects p LEFT JOIN users u ON p.manager_id = u.id
    ");
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
} elseif ($role == 'project manager') {
    $stmt = mysqli_prepare($conn, "
        SELECT p.*, u.username AS manager_name FROM projects p LEFT JOIN users u ON p.manager_id = u.id WHERE p.manager_id=?
    ");
    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
} else {
    $stmt_user_manager = mysqli_prepare($conn, "SELECT project_manager_id FROM users WHERE id=?");
    mysqli_stmt_bind_param($stmt_user_manager, "i", $uid);
    mysqli_stmt_execute($stmt_user_manager);
    mysqli_stmt_bind_result($stmt_user_manager, $team_member_manager_id);
    mysqli_stmt_fetch($stmt_user_manager);
    mysqli_stmt_close($stmt_user_manager);

    if ($team_member_manager_id) {
        $stmt = mysqli_prepare($conn, "
            SELECT p.*, COALESCE(u.username, 'Tidak Diketahui') AS manager_name FROM projects p LEFT JOIN users u ON p.manager_id = u.id WHERE p.manager_id = ?
        ");
        mysqli_stmt_bind_param($stmt, "i", $team_member_manager_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
    } else {
        $stmt = mysqli_prepare($conn, "
            SELECT DISTINCT p.*, COALESCE(u.username, 'Tidak Diketahui') AS manager_name FROM projects p LEFT JOIN tasks t ON p.id = t.project_id AND t.assigned_to = ? LEFT JOIN users u ON p.manager_id = u.id WHERE t.id IS NOT NULL OR p.manager_id = ?
        ");
        mysqli_stmt_bind_param($stmt, "ii", $uid, $uid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Projects - <?= htmlspecialchars(ucwords($role)) ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="style.css">
</head>

<body class="relative min-h-screen pixel-font overflow-x-hidden bg-center" style="background-image: url('asset/bg-dash-tuprak6.png'); background-repeat: repeat-y; background-size: contain; background-position: top center;">
<div class="absolute inset-0 pointer-events-none select-none z-20" style="background-image: url('asset/bg-hiasan-tp6.png'); background-repeat: repeat-y; background-size: contain; background-position: center top;">
</div>
<div class="w-full max-w-6xl mx-auto mt-6 border-retro-window shadow-[4px_4px_0_0_#000000] relative z-30">
    <div class="retro-header flex justify-between items-center">
        <span>TUPRAK PROJECTS - <?= htmlspecialchars(ucwords($role)) ?></span>
        <div class="flex items-center space-x-4">
            <span class="text-sm">Selamat Datang, <b><?= htmlspecialchars($user['username']) ?></b></span>
            <div class="buttons flex">
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
        <h2 class="text-lg font-bold mb-4">Projects</h2>
        <?php if($role!='team member'): ?>
        <form method="POST" class="mb-6 space-y-2">
            <input type="text" name="nama_proyek" placeholder="Nama Proyek" class="border-retro-input p-1 w-full" required>
            <input type="text" name="deskripsi" placeholder="Deskripsi" class="border-retro-input p-1 w-full" required>
            <input type="date" name="tanggal_mulai" class="border-retro-input p-1 w-full" required>
            <input type="date" name="tanggal_selesai" class="border-retro-input p-1 w-full" required>
            <?php if($role=='super admin'): ?>
            <select name="manager_id" class="border-retro-input p-1 w-full" required>
                <option value="">-- Pilih Project Manager --</option>
                <?php
                $result = mysqli_query($conn, "SELECT id, username FROM users WHERE role='project manager'");
                $managers = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($managers as $m) {
                    echo "<option value='{$m['id']}'>{$m['username']}</option>";
                }
                ?>
            </select>
            <?php endif; ?>
            <button type="submit" name="add_project" class="retro-button px-4 py-1">Add Project</button>
        </form>
        <?php endif; ?>

        <div class="overflow-x-auto">
            <table class="border-collapse border border-black w-full text-sm">
                <tr class="bg-[#C3C3C3]">
                    <th class="border border-black p-1">Nama</th>
                    <th class="border border-black p-1">Deskripsi</th>
                    <th class="border border-black p-1">Manager</th>
                    <th class="border border-black p-1">Start</th>
                    <th class="border border-black p-1">End</th>
                    <?php if($role!='team member') echo "<th class='border border-black p-1'>Action</th>"; ?>
                </tr>
                <?php foreach($projects as $p): ?>
                <tr class="hover:bg-gray-100">
                    <td class="border border-black p-1"><?= htmlspecialchars($p['nama_proyek']) ?></td>
                    <td class="border border-black p-1"><?= htmlspecialchars($p['deskripsi']) ?></td>
                    <td class="border border-black p-1"><?= htmlspecialchars($p['manager_name']) ?></td>
                    <td class="border border-black p-1"><?= htmlspecialchars($p['tanggal_mulai']) ?></td>
                    <td class="border border-black p-1"><?= htmlspecialchars($p['tanggal_selesai']) ?></td>
                    <?php if($role!='team member'): ?>
                    <td class="border border-black p-1 text-center flex justify-center space-x-1">
                        <button onclick="showEditPopup(
                            <?= $p['id'] ?>, 
                            '<?= addslashes(htmlspecialchars($p['nama_proyek'], ENT_QUOTES)) ?>', 
                            '<?= addslashes(htmlspecialchars($p['deskripsi'], ENT_QUOTES)) ?>', 
                            '<?= htmlspecialchars($p['tanggal_mulai']) ?>', 
                            '<?= htmlspecialchars($p['tanggal_selesai']) ?>'
                            )" 
                        class="retro-button bg-blue-600 text-white px-2 py-1">
                        Edit
                        </button>
                        <button onclick="showDeletePopup(<?= $p['id'] ?>)" 
                        class="retro-button bg-red-600 text-white px-2 py-1">
                        Hapus
                        </button>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<div id="retro-popup" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-[#C3C3C3] border-retro-window p-4 w-80 shadow-[4px_4px_0_0_#000000] animate-popup">
            <div class="retro-header">
                <span>⚠️ Konfirmasi</span>
                <div class="buttons">
                    <div class="btn" onclick="closePopup()">X</div>
                </div>
            </div>
            <div class="p-3 text-center">
                <p class="mb-3 font-bold">Yakin ingin menghapus project ini?</p>
                <button id="confirm-delete" class="retro-button text-white px-3 py-1 mx-1 bg-red-600">
                    Yes
                </button>
                <button onclick="closePopup()" class="retro-button px-3 py-1 mx-1 bg-gray-300">
                    No
                </button>
            </div>
        </div>
</div>

<div id="retro-popup-edit" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-[#C3C3C3] border-retro-window p-4 w-96 shadow-[4px_4px_0_0_#000000] animate-popup">
        <div class="retro-header">
            <span>Edit Project</span>
            <div class="buttons">
                <div class="btn" onclick="closeEditPopup()">X</div>
            </div>
        </div>
        <div class="p-3">
            <form id="edit-form" method="POST" class="space-y-2">
                <input type="hidden" name="project_id" id="edit-project-id">
                <input type="text" name="nama_proyek" id="edit-nama-proyek" placeholder="Nama Proyek" class="border-retro-input p-1 w-full" required>
                <input type="text" name="deskripsi" id="edit-deskripsi" placeholder="Deskripsi" class="border-retro-input p-1 w-full" required>
                <label for="edit-tanggal-mulai" class="text-xs block pt-1">Tanggal Mulai:</label>
                <input type="date" name="tanggal_mulai" id="edit-tanggal-mulai" class="border-retro-input p-1 w-full" required>
                <label for="edit-tanggal-selesai" class="text-xs block pt-1">Tanggal Selesai:</label>
                <input type="date" name="tanggal_selesai" id="edit-tanggal-selesai" class="border-retro-input p-1 w-full" required>
                
                <div class="text-right pt-2">
                    <button type="submit" name="update_project" class="retro-button px-4 py-1 bg-green-600 text-white">Update Project</button>
                    <button type="button" onclick="closeEditPopup()" class="retro-button px-4 py-1 bg-gray-300">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let projectToDelete = null;
function showDeletePopup(id) {
    projectToDelete = id;
    document.getElementById("retro-popup").classList.add("active");
}
function closePopup() {
    document.getElementById("retro-popup").classList.remove("active");
    projectToDelete = null;
}

function showEditPopup(id, nama, desc, tgl_mulai, tgl_selesai, manager_id) {
    document.getElementById("edit-project-id").value = id;
    document.getElementById("edit-nama-proyek").value = nama;
    document.getElementById("edit-deskripsi").value = desc;
    document.getElementById("edit-tanggal-mulai").value = tgl_mulai;
    document.getElementById("edit-tanggal-selesai").value = tgl_selesai;
    document.getElementById("retro-popup-edit").classList.add("active");
}

function closeEditPopup() {
    document.getElementById("retro-popup-edit").classList.remove("active");
}

document.getElementById("confirm-delete").addEventListener("click", () => {
    if (projectToDelete) window.location.href = "?delete=" + projectToDelete;
});
</script>
</body>
</html>
