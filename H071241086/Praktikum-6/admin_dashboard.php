<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'ADMIN') {
    die("Akses ditolak");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 min-h-screen font-sans">

    <nav class="bg-gradient-to-r from-purple-800 to-purple-900 p-4 shadow-2xl border-b border-purple-700">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-white text-2xl font-bold">Admin Dashboard</h1>
            <div class="flex gap-3">
                <a href="user.php" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-5 py-2.5 rounded-lg font-semibold hover:from-orange-600 hover:to-orange-700 transition shadow-lg">
                    Tambah User
                </a>
                <a href="logout.php" class="bg-red-500 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-red-600 transition shadow-lg">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 space-y-10">

        <!-- DAFTAR USER -->
        <section>
            <h2 class="text-2xl font-bold text-white mb-6">Daftar Semua User</h2>
            <div class="overflow-x-auto bg-purple-800/40 backdrop-blur-sm rounded-2xl shadow-2xl border border-purple-700/50">
                <table class="min-w-full">
                    <thead class="bg-purple-900/60">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-purple-700/30">
                        <?php
                        $user_result = mysqli_query($conn, "SELECT id, username, role FROM users");
                        while ($user = mysqli_fetch_assoc($user_result)) {
                            if ($user['id'] == $_SESSION['user']['id']) continue;

                            $role_color = match($user['role']) {
                                'MANAGER' => 'bg-green-500/20 text-green-300 border border-green-500/30',
                                'MEMBER' => 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30',
                            };
                        ?>
                        <tr class="hover:bg-purple-700/30 transition">
                            <td class="px-6 py-4 text-white font-medium"><?= htmlspecialchars($user['username']) ?></td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1.5 rounded-full text-sm font-medium <?= $role_color ?>"><?= htmlspecialchars($user['role']) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="user.php?action=delete&id=<?= $user['id'] ?>"
                                    onclick="return confirm('Yakin ingin menghapus user ini?')"
                                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md inline-block">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- DAFTAR PROYEK -->
        <section>
            <h2 class="text-2xl font-bold text-white mb-6">Daftar Semua Proyek</h2>
            <div class="overflow-x-auto bg-purple-800/40 backdrop-blur-sm rounded-2xl shadow-2xl border border-purple-700/50">
                <table class="min-w-full">
                    <thead class="bg-purple-900/60">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Nama Proyek</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Tanggal Mulai</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Tanggal Selesai</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Manager</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Member</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-purple-700/30">
                        <?php
                        $project_result = mysqli_query($conn, "
                            SELECT p.*, u.username AS manager 
                            FROM projects p 
                            LEFT JOIN users u ON p.manager_id = u.id
                        ");
                        
                        while ($row = mysqli_fetch_assoc($project_result)) {
                            $members = [];
                            $member_result = mysqli_query($conn, "
                                SELECT username 
                                FROM users 
                                WHERE project_manager_id={$row['manager_id']} 
                                AND role='MEMBER'
                            ");
                            while ($m = mysqli_fetch_assoc($member_result)) {
                                $members[] = $m['username'];
                            }
                            $members_str = implode(', ', $members); // gabung untuk satu string
                        ?>
                        <tr class="hover:bg-purple-700/30 transition">
                            <td class="px-6 py-4 text-white font-medium"><?= htmlspecialchars($row['nama_proyek']) ?></td>
                            <td class="px-6 py-4 text-purple-200"><?= htmlspecialchars($row['tanggal_mulai']) ?></td>
                            <td class="px-6 py-4 text-purple-200"><?= htmlspecialchars($row['tanggal_selesai']) ?></td>
                            <td class="px-6 py-4 text-purple-200"><?= htmlspecialchars($row['manager']) ?></td>
                            <td class="px-6 py-4 text-purple-200"><?= htmlspecialchars($members_str) ?></td>
                            <td class="px-6 py-4">
                                <a href="crud_proyek.php?hapus_id=<?= $row['id'] ?>"
                                   onclick="return confirm('Yakin ingin menghapus proyek ini?')"
                                   class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md inline-block">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</body>
</html>