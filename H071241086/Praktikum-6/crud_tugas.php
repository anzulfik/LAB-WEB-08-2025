<?php
session_start();
require 'koneksi.php';

// CEK LOGIN
if (!isset($_SESSION['user'])) {
    die("Akses ditolak. Harap login terlebih dahulu.");
}

$role = strtoupper($_SESSION['user']['role']);
$user_id = $_SESSION['user']['id'];

// ROLE MEMBER → LANGSUNG UBAH STATUS
if ($role === 'MEMBER') {
    $tugas_id = isset($_GET['id']) ? (int)$_GET['id'] : 0; //ternery
    $sql = "SELECT t.id, t.nama_tugas, t.status, p.nama_proyek
            FROM tasks t
            JOIN projects p ON t.project_id = p.id
            WHERE t.id=? AND t.assigned_to=?"; //filter
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $tugas_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $task = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$task) {
        die("Tugas tidak ditemukan atau Anda tidak memiliki akses.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST['status'];
        $update = mysqli_prepare($conn, "UPDATE tasks SET status=? WHERE id=? AND assigned_to=?");
        mysqli_stmt_bind_param($update, "sii", $status, $tugas_id, $user_id);
        mysqli_stmt_execute($update);
        mysqli_stmt_close($update);

        header("Location: member_dashboard.php");
        exit();
    }

    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Ubah Status Tugas</title>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>
    <body class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 font-sans min-h-screen">
        <header class="bg-gradient-to-r from-purple-800 to-purple-900 text-white py-4 px-6 flex justify-between items-center shadow-2xl border-b border-purple-700">
            <h1 class="text-xl font-bold">Ubah Status Tugas</h1>
            <a href="member_dashboard.php"
               class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 px-4 py-2 rounded-lg text-sm transition shadow-lg">Kembali</a>
        </header>

        <main class="max-w-lg mx-auto mt-8 backdrop-blur-md bg-purple-800/40 border border-purple-700/50 p-6 rounded-2xl shadow-2xl">
            <h2 class="text-xl font-semibold text-white mb-2"><?= htmlspecialchars($task['nama_tugas']) ?></h2>
            <p class="text-purple-200 mb-4">Proyek: <?= htmlspecialchars($task['nama_proyek']) ?></p>

            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-purple-200 font-medium mb-2">Status:</label>
                    <select name="status" required
                            class="w-full px-4 py-3 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white/10 text-white backdrop-blur-sm">
                        <option value="belum" <?= $task['status'] === 'belum' ? 'selected' : '' ?> class="bg-purple-900 text-white">Belum</option>
                        <option value="proses" <?= $task['status'] === 'proses' ? 'selected' : '' ?> class="bg-purple-900 text-white">Proses</option>
                        <option value="selesai" <?= $task['status'] === 'selesai' ? 'selected' : '' ?> class="bg-purple-900 text-white">Selesai</option>
                    </select>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-4 py-3 rounded-lg transition shadow-lg">
                    Simpan Perubahan
                </button>
            </form>
        </main>
    </body>
    </html>
    <?php
    exit();
}

// ROLE MANAGER → CRUD TUGAS
if ($role !== 'MANAGER') {
    die("Akses ditolak");
}

$manager_id  = $user_id;
$project_id  = $_GET['project_id'] ?? 0;
$pemberitahuan = "";


// MODE: UBAH STATUS (MANAGER)
if (isset($_GET['ubah_status_id'])) {
    $id_tugas = (int)$_GET['ubah_status_id'];
    $sql = "SELECT t.*, p.nama_proyek  
            FROM tasks t
            JOIN projects p ON t.project_id = p.id
            WHERE t.id=? AND p.manager_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_tugas, $manager_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $task = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$task) {
        die("Tugas tidak ditemukan atau tidak boleh diakses.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST['status'];
        $sql = "UPDATE tasks t
                JOIN projects p ON t.project_id = p.id
                SET t.status=? 
                WHERE t.id=? AND p.manager_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sii", $status, $id_tugas, $manager_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: crud_tugas.php?project_id=" . $task['project_id']);
        exit();
    }

    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Ubah Status Tugas</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 min-h-screen font-sans">
        <header class="bg-gradient-to-r from-purple-800 to-purple-900 text-white py-4 px-6 flex justify-between items-center shadow-2xl border-b border-purple-700">
            <h1 class="text-xl font-bold">Ubah Status Tugas</h1>
            <a href="crud_tugas.php?project_id=<?= $task['project_id'] ?>"
               class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 px-4 py-2 rounded-lg text-sm transition shadow-lg">Kembali</a>
        </header>

        <main class="max-w-3xl mx-auto mt-8 backdrop-blur-md bg-purple-800/40 border border-purple-700/50 p-6 rounded-2xl shadow-2xl">
            <h2 class="text-xl font-semibold text-white mb-4">
                <?= htmlspecialchars($task['nama_tugas']) ?> 
                (<?= htmlspecialchars($task['nama_proyek']) ?>)
            </h2>

            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-purple-200 font-medium mb-2">Status:</label>
                    <select name="status"
                            class="w-full px-4 py-3 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white/10 text-white backdrop-blur-sm">
                        <option value="belum" <?= $task['status'] === 'belum' ? 'selected' : '' ?> class="bg-purple-900 text-white">Belum</option>
                        <option value="proses" <?= $task['status'] === 'proses' ? 'selected' : '' ?> class="bg-purple-900 text-white">Proses</option>
                        <option value="selesai" <?= $task['status'] === 'selesai' ? 'selected' : '' ?> class="bg-purple-900 text-white">Selesai</option>
                    </select>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-4 py-3 rounded-lg transition shadow-lg">
                    Simpan
                </button>
            </form>
        </main>
    </body>
    </html>
    <?php
    exit();
}


// HAPUS TUGAS
if (isset($_GET['hapus_id']) && isset($_GET['project_id'])) {
    $hapus_id = (int)$_GET['hapus_id'];
    $project_id = (int)$_GET['project_id'];

    $sql = "DELETE t FROM tasks t
            JOIN projects p ON t.project_id = p.id
            WHERE t.id=? AND p.manager_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $hapus_id, $manager_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: crud_tugas.php?project_id=$project_id"); //tampil di url
    exit();
}


// TAMBAH TUGAS
if (isset($_POST['tambah'])) {
    $nama_tugas  = trim($_POST['nama_tugas']);
    $assigned_to = $_POST['assigned_to'];
    $project_id  = $_POST['project_id'];

    if (!empty($nama_tugas) && !empty($assigned_to) && !empty($project_id)) {
        $cek = mysqli_prepare($conn, "SELECT COUNT(*) FROM tasks WHERE nama_tugas=? AND project_id=?");
        mysqli_stmt_bind_param($cek, "si", $nama_tugas, $project_id);
        mysqli_stmt_execute($cek);
        mysqli_stmt_bind_result($cek, $jumlah);
        mysqli_stmt_fetch($cek);
        mysqli_stmt_close($cek);

        if ($jumlah > 0) {
            $pemberitahuan = "Tugas dengan nama '$nama_tugas' sudah ada dalam proyek ini.";
        } else {
            $sql = "INSERT INTO tasks (nama_tugas, project_id, assigned_to) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sii", $nama_tugas, $project_id, $assigned_to);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $pemberitahuan = "Tugas '$nama_tugas' berhasil ditambahkan.";
        }
    } else {
        $pemberitahuan = "Semua field wajib diisi!";
    }
}

// AMBIL DATA PROYEK & TUGAS
$project_list = [];
$res = mysqli_prepare($conn, "SELECT id, nama_proyek FROM projects WHERE manager_id=?");
mysqli_stmt_bind_param($res, "i", $manager_id);
mysqli_stmt_execute($res);
$r = mysqli_stmt_get_result($res);
while ($row = mysqli_fetch_assoc($r)) $project_list[] = $row;
mysqli_stmt_close($res);

if ($project_id == 0 && count($project_list) > 0) $project_id = $project_list[0]['id'];

$members = [];
$res = mysqli_prepare($conn, "SELECT id, username FROM users WHERE role='MEMBER' AND project_manager_id=?");
mysqli_stmt_bind_param($res, "i", $manager_id);
mysqli_stmt_execute($res);
$r = mysqli_stmt_get_result($res);
while ($row = mysqli_fetch_assoc($r)) $members[] = $row;
mysqli_stmt_close($res);

$tasks = [];
$res = mysqli_prepare($conn, "SELECT t.id, t.nama_tugas, t.status, u.username AS member
                              FROM tasks t
                              JOIN users u ON t.assigned_to=u.id
                              WHERE t.project_id=? ORDER BY t.id ASC");
mysqli_stmt_bind_param($res, "i", $project_id);
mysqli_stmt_execute($res);
$r = mysqli_stmt_get_result($res);
while ($row = mysqli_fetch_assoc($r)) $tasks[] = $row;
mysqli_stmt_close($res);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Tugas Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 font-sans min-h-screen">

<header class="bg-gradient-to-r from-purple-800 to-purple-900 text-white p-5 flex justify-between items-center shadow-2xl border-b border-purple-700">
    <h1 class="text-2xl font-bold">Manajemen Tugas Proyek</h1>
    <a href="manager_dashboard.php"
       class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 px-5 py-2.5 rounded-lg transition shadow-lg font-semibold">Kembali ke Dashboard</a>
</header>

<main class="max-w-7xl mx-auto p-6 space-y-6">
    <?php if (!empty($pemberitahuan)): ?>
        <div class="p-4 bg-yellow-500/20 backdrop-blur-sm border border-yellow-500/30 text-yellow-200 rounded-lg">
            <?= htmlspecialchars($pemberitahuan) ?>
        </div>
    <?php endif; ?>

    <div class="backdrop-blur-md bg-purple-800/40 border border-purple-700/50 p-4 rounded-2xl shadow-2xl">
        <form method="GET" class="flex items-center gap-3">
            <label class="font-medium text-purple-200">Pilih Proyek:</label>
            <select name="project_id" onchange="this.form.submit()"
                    class="px-4 py-2 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white/10 text-white backdrop-blur-sm">
                <?php foreach ($project_list as $proj): ?>
                    <option value="<?= $proj['id'] ?>" <?= $proj['id']==$project_id?'selected':'' ?> class="bg-purple-900 text-white">
                        <?= htmlspecialchars($proj['nama_proyek']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <div class="backdrop-blur-md bg-purple-800/40 border border-purple-700/50 p-6 rounded-2xl shadow-2xl">
        <h2 class="text-xl font-semibold mb-4 text-white">Daftar Tugas</h2>
        <?php if (empty($tasks)): ?>
            <p class="text-purple-200">Belum ada tugas.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-purple-900/60">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-purple-300">Tugas</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-purple-300">Assigned To</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-purple-300">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-purple-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-purple-700/30">
                        <?php foreach ($tasks as $t): ?>
                            <tr class="hover:bg-purple-700/30 transition">
                                <td class="px-4 py-3 text-white"><?= htmlspecialchars($t['nama_tugas']) ?></td>
                                <td class="px-4 py-3 text-purple-200"><?= htmlspecialchars($t['member']) ?></td>
                                <td class="px-4 py-3 text-purple-200 capitalize"><?= htmlspecialchars($t['status']) ?></td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="crud_tugas.php?ubah_status_id=<?= $t['id'] ?>&project_id=<?= $project_id ?>"
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-sm transition shadow-md">Ubah Status</a>
                                        <a href="crud_tugas.php?hapus_id=<?= $t['id'] ?>&project_id=<?= $project_id ?>"
                                           onclick="return confirm('Yakin ingin menghapus?')"
                                           class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-3 py-1.5 rounded-lg text-sm transition shadow-md">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div class="backdrop-blur-md bg-purple-800/40 border border-purple-700/50 p-6 rounded-2xl shadow-2xl">
        <h2 class="text-xl font-semibold mb-4 text-white">Tambah Tugas</h2>
        <form method="POST" class="space-y-4">
            <input type="hidden" name="project_id" value="<?= $project_id ?>">
            <div>
                <label class="block text-purple-200 font-medium mb-2">Nama Tugas:</label>
                <input type="text" name="nama_tugas" placeholder="Masukkan nama tugas" required
                       class="w-full px-4 py-3 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white/10 text-white placeholder-white/50 backdrop-blur-sm">
            </div>
            <div>
                <label class="block text-purple-200 font-medium mb-2">Assign ke Member:</label>
                <select name="assigned_to" required
                        class="w-full px-4 py-3 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white/10 text-white backdrop-blur-sm">
                    <?php foreach ($members as $m): ?>
                        <option value="<?= $m['id'] ?>" class="bg-purple-900 text-white"><?= htmlspecialchars($m['username']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="tambah"
                    class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-4 py-3 rounded-lg font-semibold transition shadow-lg">
                Tambah Tugas
            </button>
        </form>
    </div>
</main>
</body>
</html>