<?php
session_start();
require 'koneksi.php';

// ----------- CEK ROLE ADMIN -------------
if (!isset($_SESSION['user']) || strtoupper($_SESSION['user']['role']) !== 'ADMIN') {
    die("Akses ditolak. Hanya Admin yang dapat mengakses halaman ini.");
}

// ----------- HAPUS USER -------------
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($user_id === 0) {
        die("ID user tidak ditemukan");
    }

    // Cek user ada atau tidak
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 0) { //jumlah tabel
        mysqli_stmt_close($stmt);
        die("User tidak ditemukan di database.");
    }

    mysqli_stmt_close($stmt);

    // Eksekusi hapus user
    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: admin_dashboard.php?success=User+berhasil+dihapus");
        exit;
    } else {
        $error = mysqli_error($conn);
        mysqli_stmt_close($stmt);
        die("Gagal menghapus user: $error");
    }
}

// ----------- AMBIL DATA PROJECT MANAGER -------------
$pm_result = mysqli_query($conn, "SELECT id, username FROM users WHERE role = 'MANAGER'");
$message = '';

// ----------- TAMBAH USER -------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username           = trim($_POST['username']);
    $password           = trim($_POST['password']);
    $role               = strtoupper(trim($_POST['role']));
    $project_manager_id = isset($_POST['project_manager_id']) ? trim($_POST['project_manager_id']) : NULL;

    // Validasi input dasar
    if (empty($username) || empty($password) || empty($role)) {
        $message = "<p class='text-red-300 font-medium bg-red-500/20 backdrop-blur-sm border border-red-500/30 rounded-lg px-4 py-3'>Semua field wajib diisi!</p>";
    } 
    elseif ($role === 'MEMBER' && (empty($project_manager_id) || $project_manager_id === '')) {
        $message = "<p class='text-red-300 font-medium bg-red-500/20 backdrop-blur-sm border border-red-500/30 rounded-lg px-4 py-3'>Member wajib memiliki Manager!</p>";
    } 
    else {

        // Cek apakah username sudah digunakan
        $stmt_check = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt_check, "s", $username);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check); 
        $user_exists = mysqli_stmt_num_rows($stmt_check) > 0;
        mysqli_stmt_close($stmt_check);

        if ($user_exists) {
            $message = "<p class='text-red-300 font-medium bg-red-500/20 backdrop-blur-sm border border-red-500/30 rounded-lg px-4 py-3'>Username '$username' sudah digunakan. Silakan pilih username lain.</p>";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Jika role MANAGER, maka tidak perlu project_manager_id
            if ($role === 'MANAGER') {
                $project_manager_id = NULL;
            }

            $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssi", $username, $password_hash, $role, $project_manager_id); //isi data

            if (mysqli_stmt_execute($stmt)) {
                $message = "<p class='text-green-300 font-medium bg-green-500/20 backdrop-blur-sm border border-green-500/30 rounded-lg px-4 py-3'>User berhasil ditambahkan!</p>";
            } else {
                $message = "<p class='text-red-300 font-medium bg-red-500/20 backdrop-blur-sm border border-red-500/30 rounded-lg px-4 py-3'>Terjadi kesalahan: " . mysqli_error($conn) . "</p>";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 font-sans min-h-screen flex items-center justify-center p-6">

    <div class="backdrop-blur-md bg-purple-800/40 border border-purple-700/50 rounded-2xl shadow-2xl p-8 w-full max-w-md">
        <h2 class="text-3xl font-bold text-white mb-6 text-center">Tambah User</h2>
        <a href="admin_dashboard.php" class="inline-flex items-center gap-2 text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 px-4 py-2 rounded-lg mb-4 transition font-medium shadow-md">
            <span>&larr;</span> Kembali ke Dashboard
        </a>

        <?php if (!empty($message)) echo $message; ?>

        <form method="POST" class="space-y-5 mt-4">
            <div>
                <label class="block text-purple-200 font-medium mb-2">Username:</label>
                <input type="text" name="username" placeholder="Masukkan username" required
                       class="w-full px-4 py-3 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white/10 text-white placeholder-white/50 backdrop-blur-sm">
            </div>

            <div>
                <label class="block text-purple-200 font-medium mb-2">Password:</label>
                <div class="relative">
                    <input id="passwordInput" type="password" name="password" placeholder="Masukkan password" required
                           class="w-full pr-12 px-4 py-3 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white/10 text-white placeholder-white/50 backdrop-blur-sm">
                    <button id="togglePassword" type="button"
                            class="absolute inset-y-0 right-2 flex items-center px-2 text-white/80 hover:text-white">
                        <span id="toggleEmoji">👁️</span>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-purple-200 font-medium mb-2">Role:</label>
                <select name="role" id="role" onchange="togglePM()" required
                        class="w-full px-4 py-3 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white/10 text-white backdrop-blur-sm">
                    <option value="" class="bg-purple-900 text-white">--Pilih Role--</option>
                    <option value="MANAGER" class="bg-purple-900 text-white">Manager</option>
                    <option value="MEMBER" class="bg-purple-900 text-white">Member</option>
                </select>
            </div>

            <div id="pm_select" class="hidden">
                <label class="block text-purple-200 font-medium mb-2">
                    Pilih Manager <span class="text-orange-400">*</span>
                </label>
                <select name="project_manager_id" id="project_manager_id"
                        class="w-full px-4 py-3 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white/10 text-white backdrop-blur-sm">
                    <option value="" class="bg-purple-900 text-white">-- Pilih Manager --</option>
                    <?php 
                    mysqli_data_seek($pm_result, 0);
                    while($pm = mysqli_fetch_assoc($pm_result)) : ?>
                        <option value="<?= htmlspecialchars($pm['id']) ?>" class="bg-purple-900 text-white"><?= htmlspecialchars($pm['username']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit"
                    class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-4 py-3 rounded-lg transition transform hover:scale-105 shadow-lg">
                Tambah User
            </button>
        </form>
    </div>

    <script>
        function togglePM() {
            const role = document.getElementById('role').value;
            const pmSelect = document.getElementById('pm_select');
            const pmDropdown = document.getElementById('project_manager_id');

            if (role === 'MEMBER') {
                pmSelect.classList.remove('hidden');
                pmDropdown.setAttribute('required', 'required');
            } else {
                pmSelect.classList.add('hidden');
                pmDropdown.removeAttribute('required');
                pmDropdown.value = '';
            }
        }

        const pwdInput = document.getElementById('passwordInput');
        const toggleBtn = document.getElementById('togglePassword');
        const toggleEmoji = document.getElementById('toggleEmoji');

        toggleBtn.addEventListener('click', () => {
            const hidden = pwdInput.type === 'password';
            pwdInput.type = hidden ? 'text' : 'password';
            toggleEmoji.textContent = hidden ? '🙈' : '👁️';
        });
    </script>

</body>
</html>