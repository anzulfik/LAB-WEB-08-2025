<?php
require 'koneksi.php';
session_start();

// =======================================================
// VALIDASI AKSES
// =======================================================
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'member' || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$member_id = (int)$_SESSION['user_id'];

// =======================================================
// UPDATE STATUS TUGAS
// =======================================================
if (isset($_POST['update_status'])) {
    $task_id = (int)$_POST['task_id'];
    $status  = $_POST['status'];

    $stmt = $conn->prepare("UPDATE tasks SET status=? WHERE id=? AND assigned_to=?");
    $stmt->bind_param("sii", $status, $task_id, $member_id);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard_member.php");
    exit;
}

// =======================================================
// AMBIL DATA PROYEK
// =======================================================
$projects_query = "
    SELECT DISTINCT p.* 
    FROM projects p 
    JOIN tasks t ON p.id = t.project_id 
    WHERE t.assigned_to = ?
";
$stmt_projects = $conn->prepare($projects_query);
$stmt_projects->bind_param("i", $member_id);
$stmt_projects->execute();
$projects = $stmt_projects->get_result();
$stmt_projects->close();

// =======================================================
// AMBIL DATA TUGAS
// =======================================================
$tasks_query = "
    SELECT t.*, p.nama_proyek 
    FROM tasks t 
    JOIN projects p ON t.project_id = p.id 
    WHERE t.assigned_to = ?
    ORDER BY t.status ASC, p.nama_proyek ASC
";
$stmt_tasks = $conn->prepare($tasks_query);
$stmt_tasks->bind_param("i", $member_id);
$stmt_tasks->execute();
$tasks = $stmt_tasks->get_result();
$stmt_tasks->close();

// =======================================================
// STATISTIK
// =======================================================
$total_done_query = "SELECT COUNT(*) AS total FROM tasks WHERE assigned_to=? AND status='selesai'";
$stmt_done = $conn->prepare($total_done_query);
$stmt_done->bind_param("i", $member_id);
$stmt_done->execute();
$total_done = $stmt_done->get_result()->fetch_assoc()['total'];
$stmt_done->close();

$total_project = $projects->num_rows;
$total_task    = $tasks->num_rows;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Team Member | ZR manajemen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        body { background-color: #1e0b1fff; font-family: 'Inter', sans-serif; color: #fdf2f8; min-height: 100vh; }
        .bg-card { background-color: #2a0e30; }
        .text-pink-400 { color: #f472b6; }
        .bg-pink-500 { background-color: #ec4899; }
        .bg-pink-500:hover { background-color: #f472b6; }
        .border-pink-700 { border-color: #be185d; }
        .bg-header { background-color: #2a0e30; }
        .status-badge-belum { background-color: #facc15; }
        .status-badge-proses { background-color: #3b82f6; }
        .status-badge-selesai { background-color: #10b981; }
        .stat-card { transition: transform 0.3s ease, box-shadow 0.3s ease; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.2),0 2px 4px -2px rgba(0,0,0,0.2); }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3 rgba(244,114,182,0.3),0 4px 6px -4 rgba(244,114,182,0.3); }
        .table-row-hover:hover { background-color: rgba(58,18,67,0.6); }

        @media (max-width:768px) {
            .responsive-table table, .responsive-table thead, .responsive-table tbody,
            .responsive-table th, .responsive-table td, .responsive-table tr { display: block; }
            .responsive-table thead tr { position: absolute; top:-9999px; left:-9999px; }
            .responsive-table tr { border:1px solid #be185d; margin-bottom:0.75rem; border-radius:0.75rem; }
            .responsive-table td { border:none; border-bottom:1px solid #4a1d52; position:relative; padding-left:50%; text-align:right; padding-top:0.5rem; padding-bottom:0.5rem; }
            .responsive-table td:before { position:absolute; top:50%; transform:translateY(-50%); left:1rem; width:40%; padding-right:10px; white-space:nowrap; text-align:left; font-weight:600; color:#f472b6; content:attr(data-label); }
            .responsive-table td.full-row { display:block; text-align:left; padding-left:1rem; padding-right:1rem; border-bottom:none; }
            .responsive-table td.full-row:before { content:none; }
        }
    </style>
</head>

<body class="text-pink-50">

    <!-- HEADER -->
    <!-- HEADER -->
    <header class="bg-[#2a0e30] p-4 flex justify-between items-center shadow-md sticky top-0 z-10 border-b border-pink-700">
        <h1 class="text-2xl font-bold text-pink-400">
            👥 ZR Team Member
        </h1>
        <div class="flex items-center gap-4">
            <span class="text-pink-200 font-medium">
                💼 <?= htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?> (Team Member)
            </span>
            <a href="logout.php" 
            class="bg-pink-500 hover:bg-pink-400 px-3 py-1.5 rounded-full text-white font-semibold text-sm shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-sign-out-alt"></i> 
                <span class="hidden md:inline-block ml-1">Logout</span>
            </a>
        </div>
    </header>

    <main class="p-6 md:p-10 space-y-10">
        


        <!-- STATISTIK -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-card p-6 rounded-xl stat-card flex items-center justify-between border-b-4 border-pink-400">
                <div><p class="text-pink-300 text-sm font-medium mb-1">Total Proyek</p><h2 class="text-4xl font-extrabold text-pink-400"><?= $total_project; ?></h2></div>
                <div class="text-pink-400 text-3xl opacity-70"><i class="fas fa-project-diagram"></i></div>
            </div>
            <div class="bg-card p-6 rounded-xl stat-card flex items-center justify-between border-b-4 border-pink-400">
                <div><p class="text-pink-300 text-sm font-medium mb-1">Total Tugas</p><h2 class="text-4xl font-extrabold text-pink-400"><?= $total_task; ?></h2></div>
                <div class="text-pink-400 text-3xl opacity-70"><i class="fas fa-list-check"></i></div>
            </div>
            <div class="bg-card p-6 rounded-xl stat-card flex items-center justify-between border-b-4 border-green-500">
                <div><p class="text-pink-300 text-sm font-medium mb-1">Tugas Selesai</p><h2 class="text-4xl font-extrabold text-green-400"><?= $total_done; ?></h2></div>
                <div class="text-green-400 text-3xl opacity-70"><i class="fas fa-check-double"></i></div>
            </div>
        </section>

        <!-- DAFTAR PROYEK -->
        <section class="bg-card p-6 rounded-xl shadow-xl">
            <h2 class="text-2xl font-bold text-pink-400 mb-6 border-b border-pink-700 pb-2"><i class="fas fa-folder-open mr-2"></i> Proyek yang Anda Ikuti</h2>
            <div class="overflow-x-auto rounded-lg border border-pink-700/50">
                <table class="min-w-full text-sm divide-y divide-pink-700/50">
                    <thead class="bg-[#1f0a22] text-pink-300 uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-4 text-left">Nama Proyek</th>
                            <th class="py-3 px-4 text-center whitespace-nowrap">Periode</th>
                            <th class="py-3 px-4 text-left hidden lg:table-cell">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-700/30">
                        <?php if ($projects->num_rows > 0): ?>
                            <?php while ($p = $projects->fetch_assoc()): ?>
                                <tr class="text-center table-row-hover">
                                    <td class="py-3 px-4 text-left font-medium text-pink-50"><?= htmlspecialchars($p['nama_proyek']); ?></td>
                                    <td class="py-3 px-4 text-xs whitespace-nowrap text-pink-200"><?= $p['tanggal_mulai']; ?> s/d <?= $p['tanggal_selesai']; ?></td>
                                    <td class="py-3 px-4 text-left hidden lg:table-cell text-xs text-pink-300/80"><?= substr(htmlspecialchars($p['deskripsi']), 0, 100); ?>...</td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="py-8 text-center text-pink-300/80 italic">Anda belum ditugaskan pada proyek manapun.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- DAFTAR TUGAS -->
        <section class="bg-card p-6 rounded-xl shadow-xl">
            <h2 class="text-2xl font-bold text-pink-400 mb-6 border-b border-pink-700 pb-2"><i class="fas fa-clipboard-list mr-2"></i> Tugas Anda</h2>
            <div class="overflow-x-auto responsive-table">
                <table class="min-w-full text-sm divide-y divide-pink-700/50">
                    <thead class="bg-[#1f0a22] text-pink-300 uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-2">Nama Tugas</th>
                            <th class="py-3 px-2">Proyek</th>
                            <th class="py-3 px-2 hidden lg:table-cell">Deskripsi</th>
                            <th class="py-3 px-2">Status</th>
                            <th class="py-3 px-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-700/30">
                        <?php if ($tasks->num_rows > 0): ?>
                            <?php while ($t = $tasks->fetch_assoc()): ?>
                                <tr class="text-center table-row-hover">
                                    <td class="py-3 px-2 text-left font-medium" data-label="Tugas"><?= htmlspecialchars($t['nama_tugas']); ?></td>
                                    <td class="py-3 px-2 text-pink-200" data-label="Proyek"><?= htmlspecialchars($t['nama_proyek']); ?></td>
                                    <td class="py-3 px-2 text-left text-xs text-pink-300/80 hidden lg:table-cell" data-label="Deskripsi"><?= substr(htmlspecialchars($t['deskripsi']), 0, 80); ?>...</td>
                                    <td class="py-3 px-2" data-label="Status Saat Ini">
                                        <span class="py-1 px-3 text-xs font-bold rounded-full text-[#1a0b1f] status-badge-<?= strtolower($t['status']); ?> shadow-md"><?= ucfirst($t['status']); ?></span>
                                    </td>
                                    <td class="py-3 px-2 full-row" data-label="Ubah Status">
                                        <form method="POST" class="flex items-center justify-center space-x-2">
                                            <input type="hidden" name="task_id" value="<?= $t['id']; ?>">
                                            <select name="status" class="bg-[#1f0a22] border border-pink-700 rounded-md text-sm px-2 py-1 focus:ring-2 focus:ring-pink-400/70 focus:border-pink-400/70 transition w-full md:w-auto">
                                                <option value="belum" <?= $t['status']=='belum'?'selected':''; ?>>Belum</option>
                                                <option value="proses" <?= $t['status']=='proses'?'selected':''; ?>>Proses</option>
                                                <option value="selesai" <?= $t['status']=='selesai'?'selected':''; ?>>Selesai</option>
                                            </select>
                                            <button type="submit" name="update_status" class="bg-pink-500 hover:bg-pink-400 text-white px-3 py-1.5 rounded-md text-sm font-semibold transition shadow-md hover:scale-[1.03]"><i class="fas fa-save"></i> Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="py-8 text-center text-pink-300/80 italic">Anda belum memiliki tugas yang ditugaskan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>
</body>
</html>
