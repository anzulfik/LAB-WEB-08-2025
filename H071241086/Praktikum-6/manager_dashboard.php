<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'MANAGER') {
    die("Akses ditolak");
}

$manager_id = $_SESSION['user']['id'];

// Hitung total proyek
$sql = "SELECT COUNT(*) as total_proyek FROM projects WHERE manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_proyek = mysqli_fetch_assoc($result)['total_proyek'] ?? 0;

// Hitung total tugas
$sql = "SELECT COUNT(*) as total_tugas FROM tasks t
        JOIN projects p ON t.project_id = p.id
        WHERE p.manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_tugas = mysqli_fetch_assoc($result)['total_tugas'] ?? 0;


// Hitung status tugas
$status = ['belum' => 0, 'proses' => 0, 'selesai' => 0];

$sql = "SELECT status, COUNT(*) as jumlah 
        FROM tasks t 
        JOIN projects p ON t.project_id = p.id
        WHERE p.manager_id=? 
        GROUP BY status"; // menggabungkan status

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $status[$row['status']] = $row['jumlah'];
}

// Ambil daftar proyek
$sql = "SELECT * FROM projects WHERE manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$projects = [];
while ($p = mysqli_fetch_assoc($result)) {
    $projects[] = $p;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Manager</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 min-h-screen font-sans">

    <header class="bg-gradient-to-r from-purple-800 to-purple-900 text-white shadow-2xl border-b border-purple-700
                   p-4 sm:p-6 flex flex-col sm:flex-row justify-between items-center gap-3">
        <h1 class="text-xl sm:text-2xl font-bold">Dashboard Manager</h1>

        <div class="flex flex-wrap gap-2 sm:gap-3">
            <a href="crud_proyek.php"
               class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-5 py-2.5 rounded-lg font-semibold transition shadow-lg">
               Tambah Proyek
            </a>
            <a href="logout.php"
               class="bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-lg font-semibold transition shadow-lg">
               Logout
            </a>
        </div>
    </header>

    <main class="p-4 sm:p-6 max-w-7xl mx-auto">

        <section class="mb-8">
            <h2 class="text-lg sm:text-xl font-semibold text-white mb-4">Ringkasan</h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-purple-800/40 backdrop-blur-sm border border-purple-700/50 rounded-xl shadow-2xl p-5 text-center hover:bg-purple-700/40 transition">
                    <h3 class="text-purple-200 font-medium">Jumlah Proyek</h3>
                    <p class="text-3xl font-bold text-white mt-2"><?= $total_proyek ?></p>
                </div>

                <div class="bg-purple-800/40 backdrop-blur-sm border border-purple-700/50 rounded-xl shadow-2xl p-5 text-center hover:bg-purple-700/40 transition">
                    <h3 class="text-purple-200 font-medium">Jumlah Tugas</h3>
                    <p class="text-3xl font-bold text-white mt-2"><?= $total_tugas ?></p>
                </div>

                <div class="bg-purple-800/40 backdrop-blur-sm border border-purple-700/50 rounded-xl shadow-2xl p-5 text-center hover:bg-purple-700/40 transition">
                    <h3 class="text-purple-200 font-medium">Status Tugas</h3>
                    <div class="mt-2 space-y-1">
                        <p class="text-sm text-purple-100">Belum: <span class="font-semibold text-white"><?= $status['belum'] ?></span></p>
                        <p class="text-sm text-purple-100">Proses: <span class="font-semibold text-white"><?= $status['proses'] ?></span></p>
                        <p class="text-sm text-purple-100">Selesai: <span class="font-semibold text-white"><?= $status['selesai'] ?></span></p>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h2 class="text-lg sm:text-xl font-semibold text-white mb-4">Daftar Proyek</h2>

            <?php if (count($projects) === 0): ?>
                <p class="text-purple-200">Belum ada proyek.</p>
            <?php else: ?> // 
                <div class="overflow-x-auto bg-purple-800/40 backdrop-blur-sm rounded-2xl shadow-2xl border border-purple-700/50">
                    <table class="min-w-full">
                        <thead class="bg-purple-900/60">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                    Nama Proyek
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                    Deskripsi
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                    Tanggal Mulai
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                    Tanggal Selesai
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-purple-700/30">
                            <?php foreach ($projects as $p): ?>
                                <tr class="hover:bg-purple-700/30 transition">
                                    <td class="px-6 py-4 text-white font-medium">
                                        <?= htmlspecialchars($p['nama_proyek']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-purple-200">
                                        <?= htmlspecialchars($p['deskripsi']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-purple-200">
                                        <?= htmlspecialchars($p['tanggal_mulai']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-purple-200">
                                        <?= htmlspecialchars($p['tanggal_selesai']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="crud_proyek.php?edit_id=<?= $p['id'] ?>"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition shadow-md">
                                                Edit
                                            </a>
                                            <a href="crud_proyek.php?hapus_id=<?= $p['id'] ?>"
                                                onclick="return confirm('Yakin ingin menghapus proyek ini?')"
                                                class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition shadow-md">
                                                Hapus
                                            </a>
                                            <a href="crud_tugas.php?project_id=<?= $p['id'] ?>"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition shadow-md">
                                                Tugas
                                            </a>
                                        </div>
                                    </td>
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