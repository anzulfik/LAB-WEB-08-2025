<?php  
session_start();
require 'koneksi.php';

// CEK AKSES MEMBER
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'MEMBER') {
    die("Akses ditolak");
}

$id_member = $_SESSION['user']['id'];

// DAFTAR TUGAS YANG DITUGASKAN
$sql = "SELECT t.id, t.nama_tugas, t.status, p.nama_proyek 
        FROM tasks t
        JOIN projects p ON t.project_id = p.id
        WHERE t.assigned_to = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_member);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$tasks = [];
while ($row = mysqli_fetch_assoc($result)) {
    $tasks[] = $row;
}
mysqli_stmt_close($stmt);


// CEK MANAGER DARI MEMBER
$sql = "SELECT project_manager_id FROM users WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_member);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $manager_id);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// AMBIL DAFTAR PROYEK DARI MANAGER
$projects = [];
if ($manager_id) {
    $sql = "SELECT p.id, p.nama_proyek, p.deskripsi, p.tanggal_mulai, p.tanggal_selesai, u.username AS nama_manager
            FROM projects p
            JOIN users u ON p.manager_id = u.id
            WHERE p.manager_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $manager_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $projects[] = $row;
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Member</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 font-sans min-h-screen">

    <header class="w-full bg-gradient-to-r from-purple-800 to-purple-900 text-white p-4 sm:p-6 flex justify-between items-center shadow-2xl border-b border-purple-700">
        <h1 class="text-2xl sm:text-3xl font-bold">Dashboard Member</h1>
        <a href="logout.php" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 px-5 py-2.5 rounded-lg text-base sm:text-lg transition shadow-lg font-semibold">
            Logout
        </a>
    </header>

    <main class="w-full max-w-7xl mx-auto p-4 sm:p-6 space-y-10">

        <!-- DAFTAR TUGAS -->
        <section>
            <h2 class="text-xl sm:text-2xl font-semibold text-white mb-4">Tugas Saya</h2>

            <?php if (empty($tasks)) : ?>
                <p class="text-purple-200 text-center text-lg sm:text-xl">
                    Belum ada tugas yang ditugaskan.
                </p>
            <?php else : ?>
                <div class="space-y-4">
                    <?php foreach ($tasks as $tugas) : ?>
                        <div class="backdrop-blur-md bg-purple-800/40 border border-purple-700/50 rounded-2xl shadow-2xl p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:bg-purple-700/40 transition">
                            <div>
                                <p class="font-semibold text-white text-lg sm:text-xl">
                                    <?= htmlspecialchars($tugas['nama_tugas']) ?>
                                </p>
                                <p class="text-sm sm:text-base text-purple-200">
                                    <?= htmlspecialchars($tugas['nama_proyek']) ?>
                                </p>
                            </div>

                            <div class="flex items-center gap-4">
                                <?php
                                    $warna = '';
                                    if ($tugas['status'] === 'belum') {
                                        $warna = 'bg-red-500/20 text-red-300 border border-red-500/30';
                                    } elseif ($tugas['status'] === 'proses') {
                                        $warna = 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30';
                                    } elseif ($tugas['status'] === 'selesai') {
                                        $warna = 'bg-green-500/20 text-green-300 border border-green-500/30';
                                    }
                                ?>
                                <span class="px-3 py-1.5 text-sm sm:text-base rounded-full font-medium <?= $warna ?>">
                                    <?= ucfirst($tugas['status']) ?>
                                </span>

                                <a href="crud_tugas.php?id=<?= $tugas['id'] ?>" 
                                   class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-4 py-2 rounded-lg text-base sm:text-lg transition shadow-lg font-medium">
                                    Ubah Status
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- DAFTAR PROYEK -->
        <section>
            <h2 class="text-xl sm:text-2xl font-semibold text-white mb-4">Daftar Proyek</h2>

            <?php if (empty($projects)) : ?>
                <p class="text-purple-200 text-center text-lg sm:text-xl">
                    Belum ada proyek yang terdaftar.
                </p>
            <?php else : ?>
                <div class="overflow-x-auto backdrop-blur-md bg-purple-800/40 border border-purple-700/50 rounded-2xl shadow-2xl">
                    <table class="min-w-full">
                        <thead class="bg-purple-900/60">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Nama Proyek</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Tanggal Mulai</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Tanggal Selesai</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Manager</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-purple-700/30">
                            <?php foreach ($projects as $p): ?>
                                <tr class="hover:bg-purple-700/30 transition">
                                    <td class="px-4 py-3 text-white font-medium"><?= htmlspecialchars($p['nama_proyek']) ?></td>
                                    <td class="px-4 py-3 text-purple-200"><?= htmlspecialchars($p['deskripsi'] ?? '-') ?></td>
                                    <td class="px-4 py-3 text-purple-200"><?= htmlspecialchars($p['tanggal_mulai']) ?></td>
                                    <td class="px-4 py-3 text-purple-200"><?= htmlspecialchars($p['tanggal_selesai']) ?></td>
                                    <td class="px-4 py-3 text-purple-200"><?= htmlspecialchars($p['nama_manager']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

    </main>

</body>
</html>