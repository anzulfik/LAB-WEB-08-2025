<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$role = ($user['role']);
$uid = $user['id'];

if (isset($_POST['add_task']) && $role === 'project manager') {
    $nama = trim($_POST['nama_tugas']);
    $desc = trim($_POST['deskripsi']);
    $project_id = $_POST['project_id'];
    $assigned_to = $_POST['assigned_to'];

    $stmt = mysqli_prepare($conn, "SELECT id FROM projects WHERE id=? AND manager_id=?");
    mysqli_stmt_bind_param($stmt, "ii", $project_id, $uid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $stmt2 = mysqli_prepare($conn, "SELECT id FROM users WHERE id=? AND project_manager_id=? AND role='team member'");
        mysqli_stmt_bind_param($stmt2, "ii", $assigned_to, $uid);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_store_result($stmt2);

        if (mysqli_stmt_num_rows($stmt2) > 0) {
            $status = 'belum';
            $insert = mysqli_prepare($conn, "INSERT INTO tasks (nama_tugas, deskripsi, status, project_id, assigned_to) VALUES (?,?,?,?,?)");
            mysqli_stmt_bind_param($insert, "sssii", $nama, $desc, $status, $project_id, $assigned_to);
            mysqli_stmt_execute($insert);
        }
    }
}

if (isset($_POST['delete_task']) && $role === 'project manager') {
    $task_id = $_POST['task_id'];
    $stmt = mysqli_prepare($conn, "
        DELETE t FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.id = ? AND p.manager_id = ?
    ");
    mysqli_stmt_bind_param($stmt, "ii", $task_id, $uid);
    mysqli_stmt_execute($stmt);
    header("Location: tasks.php");
    exit();
}

if (isset($_POST['update_task']) && $role === 'project manager') {
    $task_id = $_POST['task_id'];
    $nama = trim($_POST['nama_tugas']);
    $desc = trim($_POST['deskripsi']);
    $project_id = $_POST['project_id'];
    $assigned_to = $_POST['assigned_to'];

    $stmt = mysqli_prepare($conn, "
        UPDATE tasks t JOIN projects p ON t.project_id = p.id SET t.nama_tugas=?, t.deskripsi=?, t.project_id=?, t.assigned_to=? WHERE t.id=? AND p.manager_id=?
    ");
    mysqli_stmt_bind_param($stmt, "ssiiii", $nama, $desc, $project_id, $assigned_to, $task_id, $uid);
    mysqli_stmt_execute($stmt);
    header("Location: tasks.php");
    exit();
}

if (isset($_POST['update_status']) && $role === 'team member') {
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];
    if (in_array($status, ['belum', 'proses', 'selesai'])) {
        $stmt = mysqli_prepare($conn, "UPDATE tasks SET status=? WHERE id=? AND assigned_to=?");
        mysqli_stmt_bind_param($stmt, "sii", $status, $task_id, $uid);
        mysqli_stmt_execute($stmt);
    }
}

if ($role === 'project manager') {
    $stmt = mysqli_prepare($conn, "
        SELECT t.*, p.nama_proyek, u.username AS assigned_name FROM tasks t JOIN projects p ON t.project_id = p.id LEFT JOIN users u ON t.assigned_to = u.id WHERE p.manager_id = ? ORDER BY t.id DESC
    ");
    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

} elseif ($role === 'team member') {
    $stmt = mysqli_prepare($conn, "
        SELECT t.*, p.nama_proyek, u.username AS assigned_name FROM tasks t JOIN projects p ON t.project_id = p.id LEFT JOIN users u ON t.assigned_to = u.id WHERE t.assigned_to = ? ORDER BY t.id DESC
    ");
    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tasks - <?= htmlspecialchars(ucwords($role)) ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="style.css">
</head>

<body class="relative min-h-screen pixel-font overflow-x-hidden bg-center" style="background-image: url('asset/bg-dash-tuprak6.png'); background-repeat: repeat-y; background-size: contain; background-position: top center;">
<div class="absolute inset-0 pointer-events-none select-none z-20" style="background-image: url('asset/bg-hiasan-tp6.png'); background-repeat: repeat-y; background-size: contain; background-position: center top;">
</div>
<div class="w-full max-w-6xl mx-auto mt-6 border-retro-window shadow-[4px_4px_0_0_#000000] relative z-30">
    <div class="retro-header flex justify-between items-center">
        <span>TUPRAK TASKS - <?= htmlspecialchars(ucwords($role)) ?></span>
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
        <h2 class="text-lg font-bold mb-4">Tasks</h2>

        <?php if ($role === 'project manager'): ?>
        <form method="POST" class="mb-6 space-y-2">
            <input type="text" name="nama_tugas" placeholder="Nama Tugas" class="border-retro-input p-1 w-full" required>
            <input type="text" name="deskripsi" placeholder="Deskripsi" class="border-retro-input p-1 w-full" required>

            <select name="project_id" class="border-retro-input p-1 w-full" required>
                <option value="">-- Pilih Project --</option>
                <?php
                $project_result = mysqli_query($conn, "SELECT * FROM projects WHERE manager_id=$uid");
                while ($p = mysqli_fetch_assoc($project_result)) {
                    echo "<option value='{$p['id']}'>{$p['nama_proyek']}</option>";
                }
                ?>
            </select>

            <select name="assigned_to" class="border-retro-input p-1 w-full" required>
                <option value="">-- Pilih Team Member --</option>
                <?php
                $member_result = mysqli_query($conn, "SELECT * FROM users WHERE role='team member' AND project_manager_id=$uid");
                while ($m = mysqli_fetch_assoc($member_result)) {
                    echo "<option value='{$m['id']}'>{$m['username']}</option>";
                }
                ?>
            </select>

            <input type="text" name="status" placeholder="Status (contoh: belum / proses / selesai)" 
                class="border-retro-input p-1 w-full" value="belum" required>

            <button type="submit" name="add_task" class="retro-button px-4 py-1">Add Task</button>
        </form>
        <?php endif; ?>

        <div class="overflow-x-auto relative">
        <table class="border-collapse border border-black w-full text-sm">
        <tr class="bg-[#C3C3C3]">
            <th class="border border-black p-1">Tugas</th>
            <th class="border border-black p-1">Deskripsi</th>
            <th class="border border-black p-1">Project</th>
            <th class="border border-black p-1">Assigned To</th>
            <th class="border border-black p-1">Status</th>
            <?php 
            if ($role === 'team member') echo "<th class='border border-black p-1'>Action</th>"; 
            if ($role === 'project manager') echo "<th class='border border-black p-1'>Action</th>"; 
            ?>
        </tr>

        <?php foreach ($tasks as $t): ?>
        <tr class="hover:bg-gray-100">
            <td class="border border-black p-1"><?= htmlspecialchars($t['nama_tugas']) ?></td>
            <td class="border border-black p-1"><?= htmlspecialchars($t['deskripsi']) ?></td>
            <td class="border border-black p-1"><?= htmlspecialchars($t['nama_proyek']) ?></td>
            <td class="border border-black p-1"><?= htmlspecialchars($t['assigned_name'] ?? '-') ?></td>
            <td class="border border-black p-1"><?= htmlspecialchars($t['status']) ?></td>

            <?php if ($role === 'team member'): ?>
            <td class="border border-black p-1">
                <form method="POST" class="flex space-x-1">
                    <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                    <input type="text" name="status" 
                           value="<?= htmlspecialchars($t['status']) ?>" 
                           placeholder="Status baru"
                           class="border-retro-input p-1 w-24">
                    <button type="submit" name="update_status" class="retro-button px-2 py-1 bg-green-600">Update</button>
                </form>
            </td>
            <?php endif; ?>

            <?php if ($role === 'project manager'): ?>
            <td class="border border-black p-1 text-center flex justify-center space-x-1">
                <button 
                    type="button"
                    class="retro-button bg-blue-600 text-white px-2 py-1"
                    onclick="showEditTaskPopup(
                        <?= $t['id'] ?>, 
                        '<?= addslashes(htmlspecialchars($t['nama_tugas'], ENT_QUOTES)) ?>', 
                        '<?= addslashes(htmlspecialchars($t['deskripsi'], ENT_QUOTES)) ?>', 
                        '<?= $t['project_id'] ?>', 
                        '<?= $t['assigned_to'] ?>'
                        )">
                    Edit
                </button>
                <button 
                    type="button"
                    class="retro-button bg-red-600 text-white px-2 py-1"
                    onclick="openRetroPopup(<?= $t['id'] ?>)">
                    Hapus
                </button>
            </td>
        <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </table>

    <div id="retro-popup" class="fixed inset-0 bg-black/50 items-center justify-center z-50">
        <div class="bg-[#C3C3C3] border-retro-window p-4 w-80 shadow-[4px_4px_0_0_#000000] animate-popup">
            <div class="retro-header">
                <span>⚠️ Konfirmasi</span>
                <div class="buttons">
                    <div class="btn" onclick="closeRetroPopup()">X</div>
                </div>
            </div>
            <div class="p-3 text-center">
                <p class="mb-3 font-bold">Yakin ingin menghapus tugas ini?</p>
                <form method="POST">
                    <input type="hidden" name="task_id" id="popupTaskId">
                    <button type="submit" name="delete_task" class="retro-button bg-red-600 text-white px-3 py-1 mx-1">
                        Ya
                    </button>
                    <button type="button" onclick="closeRetroPopup()" class="retro-button bg-gray-300 px-3 py-1 mx-1">
                        Tidak
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="retro-popup-edit" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-[#C3C3C3] border-retro-window p-4 w-96 shadow-[4px_4px_0_0_#000000] animate-popup">
        <div class="retro-header">
            <span>Edit Tugas</span>
            <div class="buttons">
                <div class="btn" onclick="closeEditTaskPopup()">X</div>
            </div>
        </div>
        <div class="p-3">
            <form id="edit-task-form" method="POST" class="space-y-2">
                <input type="hidden" name="task_id" id="edit-task-id">
                
                <input type="text" name="nama_tugas" id="edit-nama-tugas" placeholder="Nama Tugas" class="border-retro-input p-1 w-full" required>
                <input type="text" name="deskripsi" id="edit-deskripsi-tugas" placeholder="Deskripsi" class="border-retro-input p-1 w-full" required>
                
                <select name="project_id" id="edit-project-id" class="border-retro-input p-1 w-full" required> 
                    <option value="">-- Pilih Project --</option>
                    <?php
                    $project_result = mysqli_query($conn, "SELECT * FROM projects WHERE manager_id=$uid");
                    while ($p = mysqli_fetch_assoc($project_result)) {
                        echo "<option value='{$p['id']}'>{$p['nama_proyek']}</option>";
                    }
                    ?>
                </select>

                <select name="assigned_to" id="edit-assigned-to" class="border-retro-input p-1 w-full" required>
                    <option value="">-- Pilih Team Member --</option>
                    <?php
                    $member_result = mysqli_query($conn, "SELECT * FROM users WHERE role='team member' AND project_manager_id=$uid");
                    while ($m = mysqli_fetch_assoc($member_result)) {
                        echo "<option value='{$m['id']}'>{$m['username']}</option>";
                    }
                    ?>
                </select>

                <div class="text-right pt-2">
                    <button type="submit" name="update_task" class="retro-button px-4 py-1 bg-green-600 text-white">Update Tugas</button>
                    <button type="button" onclick="closeEditTaskPopup()" class="retro-button px-4 py-1 bg-gray-300">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRetroPopup(taskId) {
    const popup = document.getElementById('retro-popup');
    document.getElementById('popupTaskId').value = taskId;
    popup.classList.remove('hidden');
    popup.classList.remove('flex'); 
    popup.classList.add('active'); 
}

function closeRetroPopup() {
    const popup = document.getElementById('retro-popup');
    popup.classList.remove('active');
}

function showEditTaskPopup(id, nama, desc, project_id, assigned_to) {
    document.getElementById("edit-task-id").value = id;
    document.getElementById("edit-nama-tugas").value = nama;
    document.getElementById("edit-deskripsi-tugas").value = desc;
    document.getElementById("edit-project-id").value = project_id;
    document.getElementById("edit-assigned-to").value = assigned_to;

    const popup = document.getElementById("retro-popup-edit");
    popup.classList.remove('hidden');
    popup.classList.add('flex'); 
    popup.classList.add("active");
}

function closeEditTaskPopup() {
    const popup = document.getElementById("retro-popup-edit");
    popup.classList.remove("active");
    popup.classList.add("hidden"); 
    popup.classList.remove("flex"); 
}
</script>
</body>
</html>
