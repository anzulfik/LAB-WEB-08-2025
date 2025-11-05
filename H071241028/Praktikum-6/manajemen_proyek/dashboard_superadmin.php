<?php
require 'koneksi.php';
session_start();

// CEK ROLE SUPERADMIN

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: login.php");
    exit;
}

// PASTIKAN $_SESSION['user_id'] TERISI

if (!isset($_SESSION['user_id'])) {
    $username_logged_in = $_SESSION['username'] ?? null;

    if ($username_logged_in) {
        $stmt_id = $conn->prepare("SELECT id FROM users WHERE username = ?");
        if ($stmt_id) {
            $stmt_id->bind_param("s", $username_logged_in);
            $stmt_id->execute();
            $result_id = $stmt_id->get_result();

            if ($result_id->num_rows > 0) {
                $user_data = $result_id->fetch_assoc();
                $_SESSION['user_id'] = $user_data['id'];
            }

            $stmt_id->close();
        }
    }
}

$current_user_id = $_SESSION['user_id'] ?? 0;


// FUNGSI PESAN FLASH

function setFlashMessage($type, $message)
{
    $_SESSION[$type] = $message;
}

function displayFlashMessage()
{
    if (isset($_SESSION['success'])) {
        echo '<div class="p-4 mb-4 text-sm text-green-200 bg-green-900 border border-green-700 rounded-lg shadow-md" role="alert">'
            . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error'])) {
        echo '<div class="p-4 mb-4 text-sm text-red-200 bg-red-900 border border-red-700 rounded-lg shadow-md" role="alert">'
            . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
}

// AMBIL STATISTIK
$total_manager = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='manager'")->fetch_assoc()['total'];
$total_member  = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='member'")->fetch_assoc()['total'];//count adalah fungsi untuk menghitung jumlah baris yang sesuai dengan kriteria tertentu
$total_project = $conn->query("SELECT COUNT(*) AS total FROM projects")->fetch_assoc()['total'];


// TAMBAH USER BARU
if (isset($_POST['tambah_user'])) {
    $username       = trim($_POST['username'] ?? '');
    $password_plain = $_POST['password'] ?? '';
    $role           = $_POST['role'] ?? '';
    $manager_id     = $_POST['project_manager_id'] ?? null;

    if ($username === '' || $password_plain === '' || $role === '') {
        setFlashMessage('error', 'Gagal menambah user! Username, password, dan role wajib diisi.');
        header("Location: dashboard_superadmin.php");
        exit;
    }

    $stmtCheckUser = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
    if (!$stmtCheckUser) {
        setFlashMessage('error', 'Gagal menambah user! (DB prepare error saat cek username)');
        header("Location: dashboard_superadmin.php");
        exit;
    }
    $stmtCheckUser->bind_param("s", $username);
    $stmtCheckUser->execute();
    $stmtCheckUser->store_result();
    if ($stmtCheckUser->num_rows > 0) {
        // username sudah terpakai
        $stmtCheckUser->close();
        setFlashMessage('error', 'Gagal menambah user! Username sudah digunakan.');
        header("Location: dashboard_superadmin.php");
        exit;
    }
    $stmtCheckUser->close();

    // Jika lolos cek username -> hash password dan masukkan user baru
    $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

    if ($role === 'manager') {
        $stmt = $conn->prepare("
            INSERT INTO users (username, password, role, project_manager_id)
            VALUES (?, ?, ?, NULL)
        ");
        if (!$stmt) {
            setFlashMessage('error', 'Gagal menambah user! (DB prepare error saat insert)');
            header("Location: dashboard_superadmin.php");
            exit;
        }
        $stmt->bind_param("sss", $username, $password_hash, $role);

    } elseif ($role === 'member') {
        if (empty($manager_id)) {
            setFlashMessage('error', 'Gagal menambah user! Team Member wajib memiliki Project Manager.');
            header("Location: dashboard_superadmin.php");
            exit;
        }

        $stmt = $conn->prepare("
            INSERT INTO users (username, password, role, project_manager_id)
            VALUES (?, ?, ?, ?)
        ");
        if (!$stmt) {
            setFlashMessage('error', 'Gagal menambah user! (DB prepare error saat insert)');
            header("Location: dashboard_superadmin.php");
            exit;
        }
        // pastikan manager_id adalah integer
        $manager_id = (int)$manager_id;
        $stmt->bind_param("sssi", $username, $password_hash, $role, $manager_id);

    } else {
        setFlashMessage('error', 'Role tidak valid.');
        header("Location: dashboard_superadmin.php");
        exit;
    }

    if ($stmt->execute()) {
        setFlashMessage('success', 'User ' . htmlspecialchars($username) . ' berhasil ditambahkan!');
    } else {
        // jika terjadi duplicate karena race condition atau constraint DB
        $dbError = $stmt->error;
        setFlashMessage('error', 'Gagal menambah user! Error: ' . $dbError);
    }

    $stmt->close();
    header("Location: dashboard_superadmin.php");
    exit;
}

    // HAPUS USER
    if (isset($_GET['hapus_user'])) {
        $id = (int)$_GET['hapus_user'];

        if ($id === $current_user_id) {
            setFlashMessage('error', 'Anda tidak bisa menghapus akun Super Admin yang sedang login.');
            header("Location: dashboard_superadmin.php");
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            setFlashMessage('success', 'User berhasil dihapus!');
        } else {
            setFlashMessage('error', 'Gagal menghapus user!');
        }

        $stmt->close();
        header("Location: dashboard_superadmin.php");
        exit;
    }

    // HAPUS PROYEK
    if (isset($_GET['hapus_proyek'])) {
        $id = (int)$_GET['hapus_proyek'];

        $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            setFlashMessage('success', 'Proyek berhasil dihapus!');
        } else {
            setFlashMessage('error', 'Gagal menghapus proyek!');
        }

        $stmt->close();
        header("Location: dashboard_superadmin.php");
        exit;
    }


// AMBIL DATA UNTUK TAMPILAN
// ============================================================
$managers      = $conn->query("SELECT id, username FROM users WHERE role='manager'");
$users         = $conn->query("
    SELECT u.*, m.username AS manager_name
    FROM users u
    LEFT JOIN users m ON u.project_manager_id = m.id
    ORDER BY u.role ASC, u.username ASC
");
$projects      = $conn->query("
    SELECT p.*, u.username AS manager_name
    FROM projects p
    LEFT JOIN users u ON p.manager_id = u.id
    ORDER BY p.id DESC
");
$managers_form = $conn->query("SELECT id, username FROM users WHERE role='manager'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard | ZR Manajemen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #1a061e;
            --card-dark: #2a0e30;
            --accent-primary: #ec4899;
            --accent-hover: #f472b6;
            --text-light: #fdf2f8;
            --text-secondary: #fbcfe8;
            --border-color: #be185d;
        }
        body { background-color: var(--bg-dark); color: var(--text-light); font-family: 'Inter', sans-serif; }
        .card { background-color: var(--card-dark); border: 1px solid rgba(251, 207, 232, 0.1); }
        .input-field { background-color: #1f0a22; border: 1px solid var(--border-color); color: var(--text-light); transition: all 0.2s; }
        .input-field:focus { border-color: var(--accent-hover); box-shadow: 0 0 0 2px rgba(244, 114, 182, 0.5); }
        .btn-primary { background-color: var(--accent-primary); color: white; transition: background-color 0.2s; }
        .btn-primary:hover { background-color: var(--accent-hover); }
        .btn-delete { background-color: #831843; color: white; transition: background-color 0.2s; }
        .btn-delete:hover { background-color: #be185d; }
        .table-header { background-color: #1f0a22; border-bottom: 2px solid var(--accent-primary); color: var(--text-secondary); }
        .table-row:nth-child(even) { background-color: rgba(42, 14, 48, 0.5); }
        .table-row:hover { background-color: #3a1243; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.querySelector('select[name="role"]');
            const managerContainer = document.getElementById('manager-select-container');

            function toggleManagerSelect() {
                if (roleSelect.value === 'member') {
                    managerContainer.classList.remove('hidden');
                    managerContainer.querySelector('select').required = true;
                } else {
                    managerContainer.classList.add('hidden');
                    managerContainer.querySelector('select').required = false;
                    managerContainer.querySelector('select').value = '';
                }
            }

            roleSelect.addEventListener('change', toggleManagerSelect);
            toggleManagerSelect();
        });
    </script>
</head>

<body>
    <!-- HEADER -->
    <header class="bg-[#2a0e30] p-4 flex justify-between items-center shadow-xl border-b border-pink-700">
        <h1 class="text-2xl font-extrabold text-pink-400 tracking-wider">
            ZR <span class="text-pink-100 font-light">ADMIN</span>
        </h1>
        <div class="flex items-center gap-4">
            <span class="px-3 py-1 bg-pink-900/50 text-pink-200 text-sm font-medium rounded-full border border-pink-700">
                👑 <?= htmlspecialchars($_SESSION['username']); ?> (Super Admin)
            </span>
            <a href="logout.php" class="px-4 py-2 rounded-lg font-semibold transition btn-delete">Logout</a>
        </div>
    </header>

    <!-- KONTEN UTAMA -->
    <main class="p-6 md:p-10 space-y-10">
        <?php displayFlashMessage(); ?>

        <!-- STATISTIK & FORM TAMBAH USER -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Stats Cards -->
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card p-6 rounded-xl shadow-xl hover:shadow-pink-900/50 transition duration-300">
                    <p class="text-pink-300 text-sm uppercase tracking-wider mb-2">Total Manager</p>
                    <h2 class="text-4xl font-extrabold text-pink-400"><?= $total_manager; ?></h2>
                </div>
                <div class="card p-6 rounded-xl shadow-xl hover:shadow-pink-900/50 transition duration-300">
                    <p class="text-pink-300 text-sm uppercase tracking-wider mb-2">Total Member</p>
                    <h2 class="text-4xl font-extrabold text-pink-400"><?= $total_member; ?></h2>
                </div>
                <div class="card p-6 rounded-xl shadow-xl hover:shadow-pink-900/50 transition duration-300">
                    <p class="text-pink-300 text-sm uppercase tracking-wider mb-2">Total Proyek</p>
                    <h2 class="text-4xl font-extrabold text-pink-400"><?= $total_project; ?></h2>
                </div>
            </div>

            <!-- Form Tambah User -->
            <section class="lg:col-span-1 card p-6 rounded-xl shadow-2xl border-pink-700 border-2">
                <h2 class="text-xl font-bold text-pink-300 mb-4 border-b pb-2 border-pink-800">➕ Tambah Pengguna Baru</h2>
                <form method="POST" class="space-y-4">
                    <input type="text" name="username" placeholder="Username" required class="input-field w-full px-4 py-2 rounded-lg" autocomplete="off">
                    <input type="password" name="password" placeholder="Password" required class="input-field w-full px-4 py-2 rounded-lg">
                    <select name="role" required class="input-field w-full px-4 py-2 rounded-lg">
                        <option value="" disabled selected>-- Pilih Role --</option>
                        <option value="manager">Project Manager</option>
                        <option value="member">Team Member</option>
                    </select>

                    <div id="manager-select-container" class="hidden">
                        <select name="project_manager_id" class="input-field w-full px-4 py-2 rounded-lg">
                            <option value="">-- Pilih Manager (untuk Member) --</option>
                            <?php while ($m = $managers_form->fetch_assoc()): ?>
                                <option value="<?= $m['id']; ?>"><?= htmlspecialchars($m['username']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <button type="submit" name="tambah_user" class="btn-primary w-full py-2 rounded-lg font-bold shadow-lg mt-4">
                        TAMBAH USER
                    </button>
                </form>
            </section>
        </div>

        <!-- TABEL DATA -->
        <div class="space-y-10">
            <!-- Daftar Pengguna -->
            <section class="card p-6 rounded-xl shadow-xl">
                <h2 class="text-xl font-bold text-pink-400 mb-6">Daftar Pengguna Sistem</h2>
                <div class="overflow-x-auto rounded-lg border border-pink-900">
                    <table class="min-w-full text-sm">
                        <thead class="table-header">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Username</th>
                                <th class="py-3 px-4 text-center">Role</th>
                                <th class="py-3 px-4 text-left">Project Manager</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($u = $users->fetch_assoc()): ?>
                                <tr class="table-row border-t border-pink-900">
                                    <td class="py-3 px-4 text-left text-pink-300"><?= $u['id']; ?></td>
                                    <td class="py-3 px-4 text-left font-medium"><?= htmlspecialchars($u['username']); ?></td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="capitalize text-xs font-semibold px-2 py-0.5 rounded-full
                                            <?= $u['role'] == 'superadmin' ? 'bg-indigo-900 text-indigo-300' : 
                                               ($u['role'] == 'manager' ? 'bg-pink-700 text-pink-100' : 'bg-purple-700 text-purple-100'); ?>">
                                            <?= $u['role']; ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-left text-pink-200"><?= $u['manager_name'] ? htmlspecialchars($u['manager_name']) : '-'; ?></td>
                                    <td class="py-3 px-4 text-center">
                                        <?php if ($u['role'] != 'superadmin' && $u['id'] != $current_user_id): ?>
                                            <a href="?hapus_user=<?= $u['id']; ?>" 
                                               onclick="return confirm('Hapus user <?= htmlspecialchars($u['username']); ?>?')" 
                                               class="btn-delete px-3 py-1 rounded-md text-xs font-medium shadow-md">Hapus</a>
                                        <?php else: ?>
                                            <span class="text-pink-600 font-semibold text-xs">DIKUNCI</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Daftar Proyek -->
            <section class="card p-6 rounded-xl shadow-xl">
                <h2 class="text-xl font-bold text-pink-400 mb-6">Daftar Semua Proyek Aktif</h2>
                <div class="overflow-x-auto rounded-lg border border-pink-900">
                    <table class="min-w-full text-sm">
                        <thead class="table-header">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Nama Proyek</th>
                                <th class="py-3 px-4 text-left">Project Manager</th>
                                <th class="py-3 px-4 text-center">Rentang Waktu</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($p = $projects->fetch_assoc()): ?>
                                <tr class="table-row border-t border-pink-900">
                                    <td class="py-3 px-4 text-left text-pink-300"><?= $p['id']; ?></td>
                                    <td class="py-3 px-4 text-left font-medium"><?= htmlspecialchars($p['nama_proyek']); ?></td>
                                    <td class="py-3 px-4 text-left text-pink-200"><?= htmlspecialchars($p['manager_name']); ?></td>
                                    <td class="py-3 px-4 text-center text-xs text-pink-300"><?= $p['tanggal_mulai']; ?> s/d <?= $p['tanggal_selesai']; ?></td>
                                    <td class="py-3 px-4 text-center">
                                        <a href="?hapus_proyek=<?= $p['id']; ?>" 
                                           onclick="return confirm('Yakin ingin hapus proyek <?= htmlspecialchars($p['nama_proyek']); ?>? Tindakan ini tidak bisa dibatalkan!')" 
                                           class="btn-delete px-3 py-1 rounded-md text-xs font-medium shadow-md">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
