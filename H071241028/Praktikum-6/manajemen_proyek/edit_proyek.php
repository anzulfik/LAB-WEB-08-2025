<?php
require 'koneksi.php';
session_start();

// ==================== CEK ROLE DAN AKSES ====================
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'manager' || !isset($_GET['id'])) {
    header("Location: dashboard_manager.php");
    exit;
}

$manager_id = $_SESSION['id'];
$project_id = $_GET['id'];

// ==================== AMBIL DATA PROYEK ====================
$project_q = $conn->query("SELECT * FROM projects WHERE id = $project_id AND manager_id = $manager_id");
if ($project_q->num_rows == 0) {
    echo "<script>alert('Proyek tidak ditemukan atau Anda tidak memiliki akses!'); window.location='dashboard_manager.php';</script>";
    exit;
}
$project_data = $project_q->fetch_assoc(); 
// Ambil semua team member di bawah manager ini
$members = $conn->query("SELECT id, username FROM users WHERE project_manager_id=$manager_id AND role='member' ORDER BY username ASC");

// ==================== UPDATE PROYEK ====================
if (isset($_POST['update_proyek'])) {
    $nama = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $tgl_mulai = $_POST['tanggal_mulai'];
    $tgl_selesai = $_POST['tanggal_selesai'];

    $stmt = $conn->prepare("
        UPDATE projects 
        SET nama_proyek=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=?  
        WHERE id=? AND manager_id=?
    "); //tanda tanya (?) adalah placeholder untuk nilai yang akan di bind
    $stmt->bind_param("ssssii", $nama, $deskripsi, $tgl_mulai, $tgl_selesai, $project_id, $manager_id);

    if ($stmt->execute()) {
        echo "<script>alert('Proyek berhasil diupdate!'); window.location='edit_proyek.php?id=$project_id';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate proyek: " . $stmt->error . "');</script>";
    }
    $stmt->close();
    exit;
}

// ==================== UPDATE TUGAS ====================
if (isset($_POST['update_tugas'])) {
    $task_id = $_POST['task_id'];
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi_tugas = $_POST['deskripsi_tugas'];
    $status = $_POST['status'];
    $assigned_to = $_POST['assigned_to'] ?: NULL;

    $stmt = $conn->prepare("
        UPDATE tasks 
        SET nama_tugas=?, deskripsi=?, status=?, assigned_to=? 
        WHERE id=? AND project_id=?
    ");
    $stmt->bind_param("sssisi", $nama_tugas, $deskripsi_tugas, $status, $assigned_to, $task_id, $project_id);

    if ($stmt->execute()) {
        echo "<script>alert('Tugas berhasil diupdate!'); window.location='edit_proyek.php?id=$project_id';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate tugas: " . $stmt->error . "');</script>";
    }
    $stmt->close();
    exit;
}

// ==================== HAPUS TUGAS ====================
if (isset($_GET['hapus_tugas'])) {
    $task_id_to_delete = $_GET['hapus_tugas'];
    $conn->query("DELETE FROM tasks WHERE id=$task_id_to_delete AND project_id=$project_id");
    header("Location: edit_proyek.php?id=$project_id");
    exit;
}

// ==================== AMBIL DATA TUGAS ====================
$tasks_q = $conn->query("
    SELECT t.*, u.username AS member_name 
    FROM tasks t 
    LEFT JOIN users u ON t.assigned_to = u.id 
    WHERE t.project_id = $project_id
    ORDER BY t.id DESC
");


// Jika ada parameter task_id → ambil data tugas untuk edit
$task_to_edit = null;
if (isset($_GET['task_id'])) {
    $task_id_edit = $_GET['task_id'];
    $task_edit_q = $conn->query("SELECT * FROM tasks WHERE id=$task_id_edit AND project_id=$project_id");
    if ($task_edit_q->num_rows > 0) {
        $task_to_edit = $task_edit_q->fetch_assoc();
    }
    
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek | <?= htmlspecialchars($project_data['nama_proyek']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #1a0b1f; font-family: 'Poppins', sans-serif; }
        input[type='date']::-webkit-calendar-picker-indicator { filter: invert(0.8); }
        .status-belum { background-color: #ef4444; }
        .status-proses { background-color: #f59e0b; }
        .status-selesai { background-color: #10b981; }
    </style>
</head>

<body class="text-pink-50 max-w-7xl mx-auto">

    <!-- HEADER -->
    <header class="bg-[#2a0e30] p-4 flex justify-between items-center shadow-md sticky top-0 z-10">
        <h1 class="text-xl font-semibold text-pink-400">
            Edit Proyek: <?= htmlspecialchars($project_data['nama_proyek']); ?>
        </h1>
        <a href="dashboard_manager.php" 
           class="bg-pink-700 hover:bg-pink-600 px-4 py-2 rounded-md text-white font-semibold transition">
           ← Kembali ke Dashboard
        </a>
    </header>

    <main class="p-6 space-y-8">

        <!-- ==================== FORM EDIT PROYEK ==================== -->
        <section class="bg-[#2a0e30] p-6 rounded-xl shadow-lg">
            <h2 class="text-xl font-semibold text-pink-400 mb-4">Edit Detail Proyek</h2>
            <form method="POST" class="grid md:grid-cols-2 gap-4">
                <input type="text" name="nama_proyek" required 
                       value="<?= htmlspecialchars($project_data['nama_proyek']); ?>"
                       placeholder="Nama Proyek"
                       class="col-span-2 px-4 py-2 rounded-lg bg-[#1f0a22] border border-pink-700 focus:ring-2 focus:ring-pink-400">

                <textarea name="deskripsi" required placeholder="Deskripsi Proyek"
                          class="col-span-2 px-4 py-2 rounded-lg bg-[#1f0a22] border border-pink-700 focus:ring-2 focus:ring-pink-400"><?= htmlspecialchars($project_data['deskripsi']); ?></textarea>

                <label class="text-pink-300 text-sm">
                    Tanggal Mulai
                    <input type="date" name="tanggal_mulai" required
                           value="<?= $project_data['tanggal_mulai']; ?>"
                           class="w-full mt-1 px-4 py-2 rounded-lg bg-[#1f0a22] border border-pink-700 focus:ring-2 focus:ring-pink-400">
                </label> 

                <label class="text-pink-300 text-sm">
                    Tanggal Selesai
                    <input type="date" name="tanggal_selesai" required
                           value="<?= $project_data['tanggal_selesai']; ?>"
                           class="w-full mt-1 px-4 py-2 rounded-lg bg-[#1f0a22] border border-pink-700 focus:ring-2 focus:ring-pink-400">
                </label>

                <button type="submit" name="update_proyek"
                        class="col-span-2 bg-green-600 hover:bg-green-500 py-2 rounded-lg font-semibold transition">
                    Simpan Perubahan Proyek
                </button>
            </form>
        </section>

        <!-- ==================== FORM TAMBAH / EDIT TUGAS ==================== -->
        <section class="bg-[#2a0e30] p-6 rounded-xl shadow-lg">
            <h2 class="text-xl font-semibold text-pink-400 mb-4">
                <?= $task_to_edit ? 'Edit Tugas: ' . htmlspecialchars($task_to_edit['nama_tugas']) : 'Tambah Tugas Baru'; ?>
            </h2>

            <form method="POST" class="grid md:grid-cols-2 gap-4">
                <?php if ($task_to_edit): ?>
                    <input type="hidden" name="task_id" value="<?= $task_to_edit['id']; ?>">
                <?php endif; ?>

                <input type="text" name="nama_tugas" required
                       value="<?= $task_to_edit ? htmlspecialchars($task_to_edit['nama_tugas']) : ''; ?>"
                       placeholder="Nama Tugas"
                       class="px-4 py-2 rounded-lg bg-[#1f0a22] border border-pink-700 focus:ring-2 focus:ring-pink-400">

                <select name="assigned_to" class="px-4 py-2 rounded-lg bg-[#1f0a22] border border-pink-700 focus:ring-2 focus:ring-pink-400">
                    <option value="">-- Pilih Team Member --</option>
                    <?php
                    $members->data_seek(0);
                    while ($m = $members->fetch_assoc()):
                        $selected = ($task_to_edit && $task_to_edit['assigned_to'] == $m['id']) ? 'selected' : '';
                        echo "<option value='{$m['id']}' $selected>" . htmlspecialchars($m['username']) . "</option>";
                    endwhile; 
                    ?>
                </select>

                <textarea name="deskripsi_tugas" required placeholder="Deskripsi Tugas"
                          class="col-span-2 px-4 py-2 rounded-lg bg-[#1f0a22] border border-pink-700 focus:ring-2 focus:ring-pink-400"><?= $task_to_edit ? htmlspecialchars($task_to_edit['deskripsi']) : ''; ?></textarea>

                <select name="status" required
                        class="px-4 py-2 rounded-lg bg-[#1f0a22] border border-pink-700 focus:ring-2 focus:ring-pink-400 col-span-2 md:col-span-1">
                    <?php 
                    $current_status = $task_to_edit ? $task_to_edit['status'] : 'belum';
                    foreach (['belum', 'proses', 'selesai'] as $s):
                        $selected = ($s == $current_status) ? 'selected' : '';
                        echo "<option value='$s' $selected>" . ucfirst($s) . "</option>";
                    endforeach;
                    ?>
                </select>

                <button type="submit" name="<?= $task_to_edit ? 'update_tugas' : 'tambah_tugas'; ?>"
                        class="col-span-2 md:col-span-1 bg-pink-500 hover:bg-pink-400 py-2 rounded-lg font-semibold transition">
                    <?= $task_to_edit ? 'Simpan Perubahan Tugas' : 'Tambah Tugas'; ?>
                </button>

                <?php if ($task_to_edit): ?>
                    <a href="edit_proyek.php?id=<?= $project_id; ?>" 
                       class="col-span-2 text-center text-sm text-pink-300 hover:text-pink-100 mt-2">
                        Batal Edit Tugas
                    </a>
                <?php endif; ?>
            </form>
        </section>

        <!-- ==================== DAFTAR TUGAS ==================== -->
        <section class="bg-[#2a0e30] p-6 rounded-xl shadow-lg">
            <h2 class="text-xl font-semibold text-pink-400 mb-4">Daftar Tugas dalam Proyek ini</h2>
            <div class="overflow-x-auto">
                <table class="w-full border border-pink-700 text-sm">
                    <thead class="bg-[#1f0a22] text-pink-300">
                        <tr>
                            <th class="py-2 px-2 border-b border-pink-700 text-left">Nama Tugas</th>
                            <th class="py-2 border-b border-pink-700">Dikerjakan Oleh</th>
                            <th class="py-2 border-b border-pink-700">Status</th>
                            <th class="py-2 border-b border-pink-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($tasks_q->num_rows == 0): ?> 
                            <tr>
                                <td colspan="4" class="py-4 text-center text-pink-300">
                                    Proyek ini belum memiliki tugas.
                                </td>
                            </tr>
                        <?php else: while ($t = $tasks_q->fetch_assoc()): ?>
                            <tr class="text-center hover:bg-[#3a1243]/60 transition">
                                <td class="py-3 px-2 border-b border-pink-700 text-left">
                                    <span class="font-semibold"><?= htmlspecialchars($t['nama_tugas']); ?></span>
                                    <p class="text-xs text-pink-300/70"><?= htmlspecialchars($t['deskripsi']); ?></p>
                                </td>
                                <td class="py-3 border-b border-pink-700">
                                    <?= $t['member_name'] ? htmlspecialchars($t['member_name']) : '-'; ?>
                                </td>
                                <td class="py-3 border-b border-pink-700">
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold text-white status-<?= $t['status']; ?> capitalize">
                                        <?= $t['status']; ?>
                                    </span>
                                </td>
                                <td class="py-3 border-b border-pink-700 flex justify-center space-x-2">
                                    <a href="?id=<?= $project_id; ?>&task_id=<?= $t['id']; ?>" 
                                       class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-md text-sm">Edit</a>
                                    <a href="?id=<?= $project_id; ?>&hapus_tugas=<?= $t['id']; ?>" 
                                       onclick="return confirm('Hapus tugas ini?')" 
                                       class="bg-pink-600 hover:bg-pink-500 text-white px-3 py-1 rounded-md text-sm">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>

<?php $conn->close(); ?>
