<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php"); 
    exit;
}

$user = $_SESSION['user'];
$role = $user['role'];
$user_id = $user['id'];

$stats = [];

if ($role === 'super admin') {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
    $row = mysqli_fetch_assoc($result);
    $stats['total_users'] = $row['total'];
    mysqli_free_result($result);

    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM projects");
    $row = mysqli_fetch_assoc($result);
    $stats['total_projects'] = $row['total'];
    mysqli_free_result($result);

} elseif ($role === 'project manager') {
    $stmt_p = mysqli_prepare($conn, "SELECT COUNT(*) FROM projects WHERE manager_id = ?");
    mysqli_stmt_bind_param($stmt_p, "i", $user_id);
    mysqli_stmt_execute($stmt_p);
    mysqli_stmt_bind_result($stmt_p, $my_projects);
    mysqli_stmt_fetch($stmt_p);
    $stats['my_projects'] = $my_projects;
    mysqli_stmt_close($stmt_p);

    $stmt_t = mysqli_prepare($conn, "SELECT COUNT(t.id) FROM tasks t JOIN projects p ON t.project_id = p.id WHERE p.manager_id = ?");
    mysqli_stmt_bind_param($stmt_t, "i", $user_id);
    mysqli_stmt_execute($stmt_t);
    mysqli_stmt_bind_result($stmt_t, $tasks_in_my_projects);
    mysqli_stmt_fetch($stmt_t);
    $stats['tasks_in_my_projects'] = $tasks_in_my_projects;
    mysqli_stmt_close($stmt_t);

    $stmt_pending = mysqli_prepare($conn, "SELECT COUNT(t.id) FROM tasks t JOIN projects p ON t.project_id = p.id WHERE p.manager_id = ? AND t.status != 'selesai'");
    mysqli_stmt_bind_param($stmt_pending, "i", $user_id);
    mysqli_stmt_execute($stmt_pending);
    mysqli_stmt_bind_result($stmt_pending, $pending_tasks);
    mysqli_stmt_fetch($stmt_pending);
    $stats['pending_tasks'] = $pending_tasks;
    mysqli_stmt_close($stmt_pending);

} elseif ($role === 'team member') {
    $stmt_all = mysqli_prepare($conn, "SELECT COUNT(*) FROM tasks WHERE assigned_to = ?");
    mysqli_stmt_bind_param($stmt_all, "i", $user_id);
    mysqli_stmt_execute($stmt_all);
    mysqli_stmt_bind_result($stmt_all, $total_my_tasks);
    mysqli_stmt_fetch($stmt_all);
    $stats['total_my_tasks'] = $total_my_tasks;
    mysqli_stmt_close($stmt_all);

    $stmt_pending = mysqli_prepare($conn, "SELECT COUNT(*) FROM tasks WHERE assigned_to = ? AND status IN ('belum', 'proses')");
    mysqli_stmt_bind_param($stmt_pending, "i", $user_id);
    mysqli_stmt_execute($stmt_pending);
    mysqli_stmt_bind_result($stmt_pending, $pending_my_tasks);
    mysqli_stmt_fetch($stmt_pending);
    $stats['pending_my_tasks'] = $pending_my_tasks;
    mysqli_stmt_close($stmt_pending);

    $stmt_done = mysqli_prepare($conn, "SELECT COUNT(*) FROM tasks WHERE assigned_to = ? AND status = 'selesai'");
    mysqli_stmt_bind_param($stmt_done, "i", $user_id);
    mysqli_stmt_execute($stmt_done);
    mysqli_stmt_bind_result($stmt_done, $done_my_tasks);
    mysqli_stmt_fetch($stmt_done);
    $stats['done_my_tasks'] = $done_my_tasks;
    mysqli_stmt_close($stmt_done);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard <?= htmlspecialchars($role) ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="style.css">
</head>

<body class="min-h-screen flex flex-col items-center bg-cover bg-centert overflow-x-hidden relative pixel-font" style="background-image: url('asset/bg-dash-tuprak6.png'); background-repeat: repeat-y;">
    <div class="absolute inset-0 pointer-events-none select-none z-20" style="background-image: url('asset/bg-hiasan-tp6.png'); background-repeat: repeat-y; background-size: contain; background-position: center top;">
    </div>
<div class="w-full max-w-6xl mx-auto mt-6 border-retro-window shadow-[4px_4px_0_0_#000000] relative z-30">
    <div class="retro-header flex justify-between items-center">
        <span>TUPRAK DASHBOARD - <?= htmlspecialchars(ucwords($role)) ?></span>
        <div class="flex items-center space-x-4">
            <span class="text-sm">Selamat Datang, <b><?= htmlspecialchars($user['username']) ?></b></span>
            <div class="buttons flex space-x-1">
                <div class="btn">_</div>
                <div class="btn">□</div>
                <div class="btn">X</div>
            </div>
        </div>
    </div>

    <div class="retro-nav flex flex-wrap items-center gap-2 px-2 py-1">
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

  <div class="relative z-30 max-w-6xl w-full py-10 px-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 mt-4">
    <?php if ($role === 'super admin'): ?>
        <div class="border-retro-window bg-[#C3C3C3] p-4 text-center shadow-[2px_2px_0_0_#000000]">
            <p class="text-sm">TOTAL PENGGUNA</p>
            <span class="text-3xl font-extrabold text-blue-900"><?= $stats['total_users'] ?></span>
        </div>
        <div class="border-retro-window bg-[#C3C3C3] p-4 text-center shadow-[2px_2px_0_0_#000000]">
            <p class="text-sm">PROJECT KESELURUHAN</p>
            <span class="text-3xl font-extrabold text-green-700"><?= $stats['total_projects'] ?></span>
        </div>
    <?php elseif ($role === 'project manager'): ?>
        <div class="border-retro-window bg-[#C3C3C3] p-4 text-center shadow-[2px_2px_0_0_#000000]">
            <p class="text-sm">PROJECT DIKELOLA</p>
            <span class="text-3xl font-extrabold text-green-700"><?= $stats['my_projects'] ?></span>
        </div>
        <div class="border-retro-window bg-[#C3C3C3] p-4 text-center shadow-[2px_2px_0_0_#000000]">
            <p class="text-sm">TOTAL TUGAS TIM</p>
            <span class="text-3xl font-extrabold text-purple-700"><?= $stats['tasks_in_my_projects'] ?></span>
        </div>
        <div class="border-retro-window bg-[#C3C3C3] p-4 text-center shadow-[2px_2px_0_0_#000000]">
            <p class="text-sm">TUGAS PENDING</p>
            <span class="text-3xl font-extrabold text-red-600"><?= $stats['pending_tasks'] ?></span>
        </div>
    <?php elseif ($role === 'team member'): ?>
        <div class="border-retro-window bg-[#C3C3C3] p-4 text-center shadow-[2px_2px_0_0_#000000]">
            <p class="text-sm">TUGAS DITUGASKAN</p>
            <span class="text-3xl font-extrabold text-blue-700"><?= $stats['total_my_tasks'] ?></span>
        </div>
        <div class="border-retro-window bg-[#C3C3C3] p-4 text-center shadow-[2px_2px_0_0_#000000]">
            <p class="text-sm">BELUM SELESAI</p>
            <span class="text-3xl font-extrabold text-red-600"><?= $stats['pending_my_tasks'] ?></span>
        </div>
        <div class="border-retro-window bg-[#C3C3C3] p-4 text-center shadow-[2px_2px_0_0_#000000]">
            <p class="text-sm">TELAH SELESAI</p>
            <span class="text-3xl font-extrabold text-green-600"><?= $stats['done_my_tasks'] ?></span>
        </div>
    <?php endif; ?>
    </div>
  </div>
</body>
</html>
