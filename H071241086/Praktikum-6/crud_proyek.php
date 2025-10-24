<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user'])) {
    die("Akses ditolak");
}

$user_role = $_SESSION['user']['role'];
$user_id = $_SESSION['user']['id'];
$pemberitahuan = "";

// HAPUS PROYEK
if (isset($_GET['hapus_id'])) {
    $hapus_id = (int)$_GET['hapus_id'];

    if ($user_role === 'MANAGER') {
        $sql = "DELETE FROM projects WHERE id=? AND manager_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $hapus_id, $user_id);
    } elseif ($user_role === 'ADMIN') {
        $sql = "DELETE FROM projects WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $hapus_id);
    } else {
        die("Akses ditolak");
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($user_role === 'MANAGER') {
        header("Location: manager_dashboard.php");
    } else {
        header("Location: admin_dashboard.php");
    }
    exit();
}

// TAMBAH PROYEK (MANAGER ONLY)
if ($user_role === 'MANAGER' && isset($_POST['tambah'])) {
    $nama = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $mulai = $_POST['tanggal_mulai'];
    $selesai = $_POST['tanggal_selesai'];

    if (empty($nama) || empty($mulai) || empty($selesai)) {
        $pemberitahuan = "Semua field wajib diisi!";
    } else {
        $cek = mysqli_prepare($conn, "SELECT COUNT(*) FROM projects WHERE nama_proyek=? AND manager_id=?");
        mysqli_stmt_bind_param($cek, "si", $nama, $user_id);
        mysqli_stmt_execute($cek);
        mysqli_stmt_bind_result($cek, $jumlah);
        mysqli_stmt_fetch($cek);
        mysqli_stmt_close($cek);

        if ($jumlah > 0) {
            $pemberitahuan = "Nama proyek '$nama' sudah ada!";
        } else {
            $sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssi", $nama, $deskripsi, $mulai, $selesai, $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $pemberitahuan = "Proyek '$nama' berhasil ditambahkan.";
        }
    }
}


// UPDATE PROYEK (MANAGER ONLY)
if ($user_role === 'MANAGER' && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $nama = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $mulai = $_POST['tanggal_mulai'];
    $selesai = $_POST['tanggal_selesai'];

    if (empty($nama) || empty($mulai) || empty($selesai)) {
        $pemberitahuan = "Semua field wajib diisi!";
    } else {
        $sql = "UPDATE projects 
                SET nama_proyek=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=?
                WHERE id=? AND manager_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssii", $nama, $deskripsi, $mulai, $selesai, $id, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $pemberitahuan = "Proyek berhasil diperbarui.";
    }
}

// AMBIL DATA PROYEK UNTUK EDIT (MANAGER ONLY)
$edit_data = null;
if ($user_role === 'MANAGER' && isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    $sql = "SELECT * FROM projects WHERE id=? AND manager_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $edit_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $edit_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>
        <?php
        if ($user_role === 'MANAGER') {
            echo $edit_data ? 'Edit Proyek' : 'Tambah Proyek';
        } else {
            echo 'Hapus Proyek';
        }
        ?>
    </title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 font-sans min-h-screen flex items-center justify-center p-6">
    <?php if ($user_role === 'MANAGER'): ?>
    <div class="backdrop-blur-md bg-purple-800/40 border border-purple-700/50 p-8 rounded-2xl shadow-2xl w-full max-w-md">
        <h1 class="text-3xl font-bold text-center text-white mb-6">
            <?= $edit_data ? 'Edit Proyek' : 'Tambah Proyek' ?>
        </h1>

        <a href="manager_dashboard.php" class="inline-flex items-center gap-2 text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 px-4 py-2 rounded-lg mb-4 transition font-medium shadow-md">
            <span>&larr;</span> Kembali ke Dashboard
        </a>

        <?php if (!empty($pemberitahuan)): ?>
            <div class="p-3 mb-4 bg-yellow-500/20 backdrop-blur-sm border border-yellow-500/30 text-yellow-200 rounded-lg">
                <?= htmlspecialchars($pemberitahuan) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5 mt-4">
            <?php if ($edit_data): ?>
                <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-purple-200 font-medium mb-2">Nama Proyek:</label>
                <input type="text" name="nama_proyek" placeholder="Masukkan nama proyek" required
                       value="<?= htmlspecialchars($edit_data['nama_proyek'] ?? '') ?>"
                       class="w-full px-4 py-3 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white/10 text-white placeholder-white/50 backdrop-blur-sm">
            </div>

            <div>
                <label class="block text-purple-200 font-medium mb-2">Deskripsi:</label>
                <textarea name="deskripsi" rows="3" placeholder="Masukkan deskripsi proyek"
                          class="w-full px-4 py-3 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white/10 text-white placeholder-white/50 backdrop-blur-sm"><?= htmlspecialchars($edit_data['deskripsi'] ?? '') ?></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-purple-200 font-medium mb-2">Tanggal Mulai:</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" required
                           value="<?= htmlspecialchars($edit_data['tanggal_mulai'] ?? '') ?>"
                           class="w-full px-4 py-3 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white/10 text-white backdrop-blur-sm">
                </div>
                <div>
                    <label class="block text-purple-200 font-medium mb-2">Tanggal Selesai:</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" required
                           value="<?= htmlspecialchars($edit_data['tanggal_selesai'] ?? '') ?>"
                           class="w-full px-4 py-3 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white/10 text-white backdrop-blur-sm">
                </div>
            </div>

            <button type="submit" name="<?= $edit_data ? 'update' : 'tambah' ?>"
                    class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-4 py-3 rounded-lg transition transform hover:scale-105 shadow-lg">
                <?= $edit_data ? 'Simpan Perubahan' : 'Tambah Proyek' ?>
            </button>
        </form>
    </div>
    <?php else: ?>
    <div class="backdrop-blur-md bg-purple-800/40 border border-purple-700/50 p-8 rounded-2xl shadow-2xl w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-white mb-6">Admin Hanya Bisa Hapus Proyek</h1>
        <?php if (!empty($pemberitahuan)): ?>
            <div class="p-3 mb-4 bg-yellow-500/20 backdrop-blur-sm border border-yellow-500/30 text-yellow-200 rounded-lg">
                <?= htmlspecialchars($pemberitahuan) ?>
            </div>
        <?php endif; ?>
        <a href="admin_dashboard.php" class="inline-flex items-center gap-2 text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 px-4 py-2 rounded-lg transition font-medium shadow-md">
            <span>&larr;</span> Kembali ke Dashboard
        </a>
    </div>
    <?php endif; ?>

    <script>
        const mulaiInput = document.getElementById('tanggal_mulai');
        const selesaiInput = document.getElementById('tanggal_selesai');

        if (mulaiInput && selesaiInput) {
            mulaiInput.addEventListener('change', () => {
                selesaiInput.min = mulaiInput.value;
                if (selesaiInput.value < mulaiInput.value) selesaiInput.value = mulaiInput.value;
            });

            selesaiInput.addEventListener('change', () => {
                mulaiInput.max = selesaiInput.value;
                if (mulaiInput.value > selesaiInput.value) mulaiInput.value = selesaiInput.value;
            });

            if (mulaiInput.value) selesaiInput.min = mulaiInput.value;
            if (selesaiInput.value) mulaiInput.max = selesaiInput.value;
        }
    </script>
</body>
</html>