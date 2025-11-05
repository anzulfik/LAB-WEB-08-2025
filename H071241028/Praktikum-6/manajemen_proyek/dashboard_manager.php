<?php
require 'koneksi.php';
session_start();

/* ===========================================================
   FUNGSI PESAN FLASH (Session)
   =========================================================== */
function setFlashMessage($type, $message) {
    $_SESSION[$type] = $message;
}

function displayFlashMessage() {
    if (isset($_SESSION['success'])) {
        echo '<div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">'
            . htmlspecialchars($_SESSION['success']) . '</div>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">'
            . htmlspecialchars($_SESSION['error']) . '</div>';
        unset($_SESSION['error']);
    }
}

/* ===========================================================
   CEK ROLE & AUTENTIKASI MANAGER
   =========================================================== */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager' || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$manager_id = (int)$_SESSION['user_id'];

/* ===========================================================
    TAMBAH PROYEK (CREATE)
   =========================================================== */
if (isset($_POST['tambah_proyek'])) {
    $nama_proyek     = $_POST['nama_proyek'];
    $deskripsi       = $_POST['deskripsi'];
    $tanggal_mulai   = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    $stmt = $conn->prepare("
        INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $manager_id);

    if ($stmt->execute()) {
        setFlashMessage('success', "Proyek **" . htmlspecialchars($nama_proyek) . "** berhasil dibuat!");
    } else {
        setFlashMessage('error', "Gagal membuat proyek! Error: " . $stmt->error);
    }

    $stmt->close();
    header("Location: dashboard_manager.php");
    exit;
}

/* ===========================================================
   EDIT PROYEK (UPDATE)
   =========================================================== */
if (isset($_POST['edit_proyek'])) {
    $id              = (int)$_POST['project_id_edit'];
    $nama_proyek     = $_POST['nama_proyek_edit'];
    $deskripsi       = $_POST['deskripsi_edit'];
    $tanggal_mulai   = $_POST['tanggal_mulai_edit'];
    $tanggal_selesai = $_POST['tanggal_selesai_edit'];

    $stmt = $conn->prepare("
        UPDATE projects
        SET nama_proyek=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=?
        WHERE id=? AND manager_id=?
    ");
    $stmt->bind_param("ssssii", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $id, $manager_id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        setFlashMessage('success', "Proyek " . htmlspecialchars($nama_proyek) . " berhasil diperbarui!");
    } else {
         if ($stmt->affected_rows === 0) {
            setFlashMessage('error', 'Gagal memperbarui proyek. Pastikan Anda melakukan perubahan atau proyek tersebut milik Anda.');
        } else {
            setFlashMessage('error', "Gagal memperbarui proyek! Error: " . $stmt->error);
        }
    }

    $stmt->close();
    header("Location: dashboard_manager.php");
    exit;
}

/* ===========================================================
   HAPUS PROYEK (DELETE)
   =========================================================== */
if (isset($_GET['hapus_proyek'])) {
    $id = (int)$_GET['hapus_proyek'];

    $conn->query("DELETE FROM tasks WHERE project_id IN (SELECT id FROM projects WHERE id={$id} AND manager_id={$manager_id})");

    $stmt = $conn->prepare("DELETE FROM projects WHERE id=? AND manager_id=?");
    $stmt->bind_param("ii", $id, $manager_id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        setFlashMessage('success', 'Proyek berhasil dihapus beserta semua tugasnya!');
    } else {
        setFlashMessage('error', 'Gagal menghapus proyek atau proyek bukan milik Anda!');
    }

    $stmt->close();
    header("Location: dashboard_manager.php");
    exit;
}

/* ===========================================================
   TAMBAH TUGAS (CREATE)
   =========================================================== */
if (isset($_POST['tambah_tugas'])) {
    $project_id  = $_POST['project_id'];
    $nama_tugas  = trim($_POST['nama_tugas'] ?? '');
    $deskripsi   = trim($_POST['deskripsi'] ?? '');
    $status      = 'belum'; 
    $assigned_to = !empty($_POST['assigned_to']) ? (int)$_POST['assigned_to'] : null;

    if ($project_id === '' || $nama_tugas === '' || $deskripsi === '') {
        setFlashMessage('error', 'Gagal menambah tugas! Semua field wajib diisi.');
        header("Location: dashboard_manager.php");
        exit;
    }

    if ($assigned_to === null) {
        setFlashMessage('error', 'Gagal menambah tugas! Anda harus memilih Team Member yang akan mengerjakan tugas.');
        header("Location: dashboard_manager.php");
        exit;
    }

    // Pastikan proyek milik manager
    $check_stmt = $conn->prepare("SELECT manager_id FROM projects WHERE id = ?");
    if (!$check_stmt) {
        setFlashMessage('error', 'Gagal menambah tugas! Kesalahan database (prepare project check).');
        header("Location: dashboard_manager.php");
        exit;
    }
    $check_stmt->bind_param("i", $project_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $project_manager_check = $result->fetch_assoc();
    $check_stmt->close();

    if ($project_manager_check && $project_manager_check['manager_id'] == $manager_id) {
        // Jika validasi lulus, lanjut insert
        $stmt = $conn->prepare("
            INSERT INTO tasks (project_id, nama_tugas, deskripsi, assigned_to, status)
            VALUES (?, ?, ?, ?, ?)
        ");
        if (!$stmt) {
            setFlashMessage('error', 'Gagal menambah tugas! Kesalahan database (prepare insert).');
            header("Location: dashboard_manager.php");
            exit;
        }

        $stmt->bind_param("issis", $project_id, $nama_tugas, $deskripsi, $assigned_to, $status);

        if ($stmt->execute()) {
            setFlashMessage('success', "Tugas '" . htmlspecialchars($nama_tugas) . "' berhasil ditambahkan untuk member ID: " . htmlspecialchars($assigned_to) . "!");
        } else {
            setFlashMessage('error', "Gagal menambah tugas! Error: " . $stmt->error);
        }

        $stmt->close();
    } else {
        setFlashMessage('error', 'Proyek tidak ditemukan atau bukan milik Anda.');
    }

    header("Location: dashboard_manager.php");
    exit;
}


/* ===========================================================
   EDIT TUGAS (UPDATE)
   =========================================================== */
if (isset($_POST['edit_tugas'])) {
    $task_id    = (int)$_POST['task_id_edit'];
    $nama_tugas = $_POST['nama_tugas_edit'];
    $deskripsi  = $_POST['deskripsi_edit'];
    $status     = $_POST['status_edit'];
    $assigned_to = !empty($_POST['assigned_to_edit']) ? (int)$_POST['assigned_to_edit'] : NULL;

    // 1. Cek kepemilikan proyek atas tugas ini
    $check_stmt = $conn->prepare("
        SELECT p.manager_id FROM tasks t
        INNER JOIN projects p ON t.project_id = p.id
        WHERE t.id = ?
    ");
    $check_stmt->bind_param("i", $task_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $task_project_check = $result->fetch_assoc();
    $check_stmt->close();

    if ($task_project_check && $task_project_check['manager_id'] == $manager_id) {
        // 2. Lakukan Update
        if ($assigned_to === NULL) {
            $stmt = $conn->prepare("
                UPDATE tasks
                SET nama_tugas=?, deskripsi=?, assigned_to=NULL, status=?
                WHERE id=?
            ");
            $stmt->bind_param("sssi", $nama_tugas, $deskripsi, $status, $task_id);
        } else {
            $stmt = $conn->prepare("
                UPDATE tasks
                SET nama_tugas=?, deskripsi=?, assigned_to=?, status=?
                WHERE id=?
            ");
            $stmt->bind_param("ssisi", $nama_tugas, $deskripsi, $assigned_to, $status, $task_id);
        }

        if ($stmt->execute() && ($stmt->affected_rows > 0 || $stmt->errno === 0)) {
            setFlashMessage('success', "Tugas " . htmlspecialchars($nama_tugas) . " berhasil diperbarui!");
        } else {
             if ($stmt->affected_rows === 0) {
                 setFlashMessage('error', 'Gagal memperbarui tugas. Pastikan Anda melakukan perubahan pada tugas ini.');
            } else {
                setFlashMessage('error', "Gagal memperbarui tugas! Error: " . $stmt->error);
            }
        }
        $stmt->close();

    } else {
        setFlashMessage('error', 'Tugas tidak ditemukan atau bukan milik proyek Anda.');
    }

    header("Location: dashboard_manager.php");
    exit;
}


/* ===========================================================
   HAPUS TUGAS (DELETE)
   =========================================================== */
if (isset($_GET['hapus_tugas'])) {
    $task_id = (int)$_GET['hapus_tugas'];

    $stmt = $conn->prepare("
        DELETE t FROM tasks t
        INNER JOIN projects p ON t.project_id = p.id
        WHERE t.id = ? AND p.manager_id = ?
    ");
    $stmt->bind_param("ii", $task_id, $manager_id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        setFlashMessage('success', 'Tugas berhasil dihapus!');
    } else {
        setFlashMessage('error', 'Gagal menghapus tugas atau tugas tidak ditemukan!');
    }

    $stmt->close();
    header("Location: dashboard_manager.php");
    exit;
}

/* ===========================================================
   AMBIL DATA UNTUK TAMPILAN
   =========================================================== */
    $total_my_projects = $conn->query("
        SELECT COUNT(*) AS total FROM projects WHERE manager_id={$manager_id}
    ")->fetch_assoc()['total'];

    $total_my_tasks = $conn->query("
        SELECT COUNT(*) AS total FROM tasks t
        INNER JOIN projects p ON t.project_id = p.id
        WHERE p.manager_id={$manager_id}
    ")->fetch_assoc()['total'];

    $my_projects_result = $conn->query("
        SELECT * FROM projects WHERE manager_id={$manager_id}
        ORDER BY tanggal_mulai DESC
    ");

    $my_team_members_result = $conn->query("
        SELECT id, username FROM users
        WHERE role='member' AND project_manager_id={$manager_id}
        ORDER BY username ASC
    ");
    // Ambil semua team members ke dalam array untuk digunakan di modal
    $team_members = [];
    if ($my_team_members_result) {
        while ($m = $my_team_members_result->fetch_assoc()) {
            $team_members[] = $m;
        }
        // Reset pointer for the task creation select
        $my_team_members_result->data_seek(0);
    }


    $my_tasks_result = $conn->query("
        SELECT t.*, p.nama_proyek, u.username AS assigned_member_name
        FROM tasks t
        INNER JOIN projects p ON t.project_id = p.id
        LEFT JOIN users u ON t.assigned_to = u.id
        WHERE p.manager_id = {$manager_id}
        ORDER BY FIELD(t.status, 'belum', 'proses', 'selesai'), p.nama_proyek, t.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manager | VS manajemen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { 
            background-color: #1a061e; 
            font-family: 'Inter', sans-serif;
        }
        .text-pink-50 { color: #fdf2f8; }
        .card { background-color: #2a0e30; }
        .input-field {
            background-color: #1f0a22;
            border-color: #be185d;
            color: #fdf2f8;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
        }
        .input-field:focus { --tw-ring-color: #f472b6; outline: none; box-shadow: 0 0 0 2px #f472b6; }
        .btn-submit { background-color: #ec4899; color: white; }
        .btn-submit:hover { background-color: #f472b6; }
        .btn-delete { background-color: #db2777; }
        .btn-delete:hover { background-color: #ec4899; }
        .btn-edit { background-color: #3b82f6; }
        .btn-edit:hover { background-color: #60a5fa; }
        .status-badge-belum { background-color: #facc15; color: #1f2937; } /* Kuning */
        .status-badge-proses { background-color: #3b82f6; color: white; } /* Biru */
        .status-badge-selesai { background-color: #10b981; color: white; } /* Hijau */
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(5px);
        }
        /* Style for date inputs to make them dark */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1); /* Invert color for visibility on dark background */
        }
    </style>
    <script>
        // JS untuk menampilkan form tambah tugas setelah proyek dipilih
        document.addEventListener('DOMContentLoaded', function() {
            const formTambahTugasContainer = document.getElementById('form-tambah-tugas-container');
            const selectProject = document.querySelector('#form-pilih-proyek select[name="project_id"]');
            const taskProjectId = document.getElementById('task-project-id');
            const formTambahTugas = document.getElementById('form-tambah-tugas');
            
            // Mengatur elemen-elemen di form Tambah Tugas
            const assignedToSelect = document.getElementById('assigned-to-add');
            
            function toggleTambahTugasForm() {
                if (selectProject.value) {
                    formTambahTugasContainer.classList.remove('hidden');
                    taskProjectId.value = selectProject.value;
                } else {
                    formTambahTugasContainer.classList.add('hidden');
                    taskProjectId.value = '';
                }
            }

            selectProject.addEventListener('change', toggleTambahTugasForm);
            toggleTambahTugasForm();
            
            // =====================================================
            // MODAL PROJECT EDIT
            // =====================================================
            const modalProject = document.getElementById('modal-edit-proyek');
            const openProjectBtns = document.querySelectorAll('.btn-open-edit-proyek');
            const closeProjectBtn = document.getElementById('close-modal-project');
            
            openProjectBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    const deskripsi = this.getAttribute('data-deskripsi');
                    const mulai = this.getAttribute('data-mulai');
                    const selesai = this.getAttribute('data-selesai');

                    document.getElementById('project-id-edit').value = id;
                    document.getElementById('nama-proyek-edit').value = nama;
                    document.getElementById('deskripsi-edit').value = deskripsi;
                    document.getElementById('tanggal-mulai-edit').value = mulai;
                    document.getElementById('tanggal-selesai-edit').value = selesai;

                    modalProject.classList.remove('hidden');
                });
            });

            closeProjectBtn.addEventListener('click', () => modalProject.classList.add('hidden'));

            // =====================================================
            // MODAL TASK EDIT
            // =====================================================
            const modalTask = document.getElementById('modal-edit-tugas');
            const openTaskBtns = document.querySelectorAll('.btn-open-edit-tugas');
            const closeTaskBtn = document.getElementById('close-modal-task');
            
            openTaskBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    const deskripsi = this.getAttribute('data-deskripsi');
                    const assignedTo = this.getAttribute('data-assigned-to');
                    const status = this.getAttribute('data-status');

                    document.getElementById('task-id-edit').value = id;
                    document.getElementById('nama-tugas-edit').value = nama;
                    document.getElementById('deskripsi-tugas-edit').value = deskripsi;
                    
                    const selectAssignedTo = document.getElementById('assigned-to-edit');
                    // Set value for assigned_to (handle null/empty)
                    selectAssignedTo.value = assignedTo && assignedTo !== '0' ? assignedTo : '';
                    
                    const selectStatus = document.getElementById('status-edit');
                    selectStatus.value = status;

                    modalTask.classList.remove('hidden');
                });
            });

            closeTaskBtn.addEventListener('click', () => modalTask.classList.add('hidden'));
        });

    </script>
</head>
<body class="text-pink-50 min-h-screen">

    <!-- HEADER -->
    <header class="bg-[#2a0e30] p-4 flex justify-between items-center shadow-md sticky top-0 z-10">
        <h1 class="text-2xl font-bold text-pink-400">ZR Project Manager</h1>
        <div class="flex items-center gap-4">
            <span class="text-pink-200 font-medium">
                🛠️ <?= htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?> (Manager)
            </span>
            <a href="logout.php" class="bg-pink-500 hover:bg-pink-400 px-3 py-1.5 rounded-full text-white font-semibold text-sm shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-sign-out-alt"></i> <span class="hidden md:inline-block ml-1">Logout</span>
            </a>
        </div>
    </header>

    <main class="p-6 md:p-10 space-y-10">
        <?php displayFlashMessage(); ?>

        <!-- STATISTIK -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="card p-6 rounded-xl shadow-lg text-center border-t-4 border-pink-500">
                <p class="text-pink-300 text-sm">Total Proyek Saya</p>
                <h2 class="text-4xl font-extrabold text-pink-400 mt-1"><?= $total_my_projects; ?></h2>
            </div>
            <div class="card p-6 rounded-xl shadow-lg text-center border-t-4 border-pink-500">
                <p class="text-pink-300 text-sm">Total Tugas Dalam Proyek</p>
                <h2 class="text-4xl font-extrabold text-pink-400 mt-1"><?= $total_my_tasks; ?></h2>
            </div>
        </section>

        <!-- CRUD FORMS (PROYEK & TUGAS) -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- FORM TAMBAH PROYEK -->
            <div class="card p-6 rounded-xl shadow-2xl">
                <h2 class="text-xl font-semibold text-pink-400 mb-4 border-b pb-2 border-pink-700">Buat Proyek Baru</h2>
                <form method="POST" class="grid grid-cols-1 gap-4">
                    <input type="text" name="nama_proyek" placeholder="Nama Proyek" required
                        class="input-field w-full">
                    <textarea name="deskripsi" placeholder="Deskripsi Proyek Singkat" required
                        class="input-field w-full h-24 resize-none"></textarea>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <label class="text-pink-300 text-sm mb-1">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" required class="input-field">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-pink-300 text-sm mb-1">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" required class="input-field">
                        </div>
                    </div>
                    <button type="submit" name="tambah_proyek"
                        class="btn-submit py-3 rounded-lg font-bold mt-2 transition transform hover:scale-[1.01]">
                        ➕ Buat Proyek
                    </button>
                </form>
            </div>

            <!-- FORM TAMBAH TUGAS -->
            <div class="card p-6 rounded-xl shadow-2xl">
                <h2 class="text-xl font-semibold text-pink-400 mb-4 border-b pb-2 border-pink-700">Tambahkan Tugas Baru</h2>
                
                <!-- PILIH PROYEK -->
                <form id="form-pilih-proyek" class="mb-4">
                    <select name="project_id" required class="input-field w-full">
                        <option value="">-- Pilih Proyek Anda --</option>
                        <?php
                        // Reset pointer and display projects again
                        $my_projects_result->data_seek(0);
                        while ($p = $my_projects_result->fetch_assoc()) {
                            echo "<option value='{$p['id']}'>".htmlspecialchars($p['nama_proyek'])."</option>";
                        }
                        ?>
                    </select>
                </form>

                <!-- FORM DETAIL TUGAS -->
                <div id="form-tambah-tugas-container" class="hidden">
                    <form method="POST" id="form-tambah-tugas" class="grid grid-cols-1 gap-4">
                        <input type="hidden" name="project_id" id="task-project-id">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="nama_tugas" placeholder="Nama Tugas" required
                                class="input-field w-full">
                            <select name="assigned_to" id="assigned-to-add"
                                    class="input-field w-full">
                                <option value="">-- Pilih Team Member --</option>
                                <?php
                                foreach ($team_members as $m) {
                                    echo "<option value='{$m['id']}'>".htmlspecialchars($m['username'])."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <textarea name="deskripsi" placeholder="Deskripsi Tugas" required
                            class="input-field w-full h-20 resize-none"></textarea>
                        
                        <!-- Status default 'belum' - tidak perlu input form, diatur di PHP -->
                        <div class="flex items-center justify-between text-pink-300 text-sm">
                             <span class="font-medium">Status Awal:</span>
                             <span class="px-3 py-1 bg-yellow-400 text-gray-800 rounded-full text-xs font-semibold">BELUM</span>
                        </div>
                        
                        <button type="submit" name="tambah_tugas"
                            class="btn-submit py-3 rounded-lg font-bold transition transform hover:scale-[1.01]">
                            ➕ Tambah Tugas
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- DAFTAR PROYEK (READ) -->
        <section class="space-y-6">
            <h2 class="text-2xl font-bold text-pink-400 border-b pb-3 border-pink-700">Daftar Proyek Saya (<?= $total_my_projects; ?>)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php
                $my_projects_result->data_seek(0);
                if ($my_projects_result->num_rows > 0):
                    while ($p = $my_projects_result->fetch_assoc()):
                ?>
                <div class="card p-5 rounded-xl shadow-lg border-l-4 border-pink-500 space-y-2">
                    <div class="flex justify-between items-start">
                        <h3 class="text-lg font-semibold text-pink-100"><?= htmlspecialchars($p['nama_proyek']); ?></h3>
                        <div class="flex space-x-2">
                            <!-- Tombol Edit Proyek -->
                            <button
                                class="btn-edit text-xs font-semibold px-3 py-1 rounded-full transition hover:bg-blue-600 btn-open-edit-proyek"
                                data-id="<?= $p['id']; ?>"
                                data-nama="<?= htmlspecialchars($p['nama_proyek']); ?>"
                                data-deskripsi="<?= htmlspecialchars($p['deskripsi']); ?>"
                                data-mulai="<?= $p['tanggal_mulai']; ?>"
                                data-selesai="<?= $p['tanggal_selesai']; ?>"
                            >
                                ✏️ Edit
                            </button>
                            <!-- Tombol Hapus Proyek -->
                            <a href="?hapus_proyek=<?= $p['id']; ?>" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus proyek ini beserta SEMUA tugas di dalamnya?')"
                                class="btn-delete text-xs font-semibold px-3 py-1 rounded-full transition hover:bg-red-700">
                                🗑️ Hapus
                            </a>
                        </div>
                    </div>
                    <p class="text-sm text-pink-200"><?= htmlspecialchars($p['deskripsi']); ?></p>
                    <p class="text-xs text-pink-400 pt-1">
                        Mulai: <?= $p['tanggal_mulai']; ?> | Selesai: <?= $p['tanggal_selesai']; ?>
                    </p>
                </div>
                <?php
                    endwhile;
                else:
                ?>
                <p class="col-span-2 text-center text-pink-300 p-4 bg-[#2a0e30] rounded-xl">Belum ada proyek yang Anda buat.</p>
                <?php
                endif;
                ?>
            </div>
        </section>
        
        <!-- DAFTAR TUGAS (READ) -->
        <section class="space-y-6">
            <h2 class="text-2xl font-bold text-pink-400 border-b pb-3 border-pink-700">Daftar Tugas Proyek Anda (<?= $total_my_tasks; ?>)</h2>
            <div class="overflow-x-auto bg-[#2a0e30] rounded-xl shadow-2xl">
                <table class="min-w-full divide-y divide-pink-700">
                    <thead class="bg-[#1f0a22]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-pink-300 uppercase tracking-wider">Nama Tugas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-pink-300 uppercase tracking-wider">Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-pink-300 uppercase tracking-wider">Ditugaskan Kepada</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-pink-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-pink-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-700">
                        <?php
                        if ($my_tasks_result->num_rows > 0):
                            while ($t = $my_tasks_result->fetch_assoc()):
                                $status_class = "status-badge-" . strtolower($t['status']);
                        ?>
                        <tr class="hover:bg-[#3d1544]">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-pink-50"><?= htmlspecialchars($t['nama_tugas']); ?></p>
                                <p class="text-xs text-pink-300 truncate w-48"><?= htmlspecialchars($t['deskripsi']); ?></p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-pink-200"><?= htmlspecialchars($t['nama_proyek']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-pink-200">
                                <!-- Mengubah "assigned_member_name" menjadi "Dikerjakan Oleh" -->
                                <?= $t['assigned_member_name'] ? htmlspecialchars($t['assigned_member_name']) : '-'; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $status_class; ?> capitalize">
                                    <?= htmlspecialchars($t['status']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex gap-2 justify-center">
                                    <!-- Tombol Edit Tugas -->
                                    <button
                                        class="btn-edit text-xs font-semibold px-3 py-1 rounded-full transition hover:bg-blue-600 btn-open-edit-tugas"
                                        data-id="<?= $t['id']; ?>"
                                        data-nama="<?= htmlspecialchars($t['nama_tugas']); ?>"
                                        data-deskripsi="<?= htmlspecialchars($t['deskripsi']); ?>"
                                        data-assigned-to="<?= $t['assigned_to']; ?>"
                                        data-status="<?= $t['status']; ?>"
                                    >
                                        ✏️ Edit
                                    </button>
                                    <!-- Tombol Hapus Tugas -->
                                    <a href="?hapus_tugas=<?= $t['id']; ?>" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')"
                                        class="btn-delete text-xs font-semibold px-3 py-1 rounded-full transition hover:bg-red-700">
                                        🗑️ Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                            endwhile;
                        else:
                        ?>
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-pink-300">Anda belum memiliki tugas dalam proyek yang Anda kelola.</td>
                        </tr>
                        <?php
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- ===================================================== -->
    <!-- MODAL EDIT PROYEK -->
    <!-- ===================================================== -->
    <div id="modal-edit-proyek" class="modal-overlay fixed inset-0 hidden z-50 flex items-center justify-center p-4">
        <div class="card w-full max-w-lg p-6 rounded-xl shadow-2xl">
            <div class="flex justify-between items-center border-b pb-3 border-pink-700">
                <h3 class="text-xl font-bold text-pink-400">Edit Proyek</h3>
                <button id="close-modal-project" class="text-pink-300 hover:text-pink-100 text-2xl leading-none">
                    &times;
                </button>
            </div>
            <form method="POST" class="mt-4 space-y-4">
                <input type="hidden" name="project_id_edit" id="project-id-edit">
                
                <input type="text" name="nama_proyek_edit" id="nama-proyek-edit" placeholder="Nama Proyek" required
                    class="input-field w-full">
                
                <textarea name="deskripsi_edit" id="deskripsi-edit" placeholder="Deskripsi Proyek" required
                    class="input-field w-full h-24 resize-none"></textarea>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-pink-300 text-sm mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai_edit" id="tanggal-mulai-edit" required class="input-field">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-pink-300 text-sm mb-1">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai_edit" id="tanggal-selesai-edit" required class="input-field">
                    </div>
                </div>
                
                <button type="submit" name="edit_proyek"
                    class="btn-submit w-full py-3 rounded-lg font-bold transition transform hover:scale-[1.01]">
                    Simpan Perubahan Proyek
                </button>
            </form>
        </div>
    </div>
    
    <!-- ===================================================== -->
    <!-- MODAL EDIT TUGAS -->
    <!-- ===================================================== -->
    <div id="modal-edit-tugas" class="modal-overlay fixed inset-0 hidden z-50 flex items-center justify-center p-4">
        <div class="card w-full max-w-lg p-6 rounded-xl shadow-2xl">
            <div class="flex justify-between items-center border-b pb-3 border-pink-700">
                <h3 class="text-xl font-bold text-pink-400">Edit Tugas</h3>
                <button id="close-modal-task" class="text-pink-300 hover:text-pink-100 text-2xl leading-none">
                    &times;
                </button>
            </div>
            <form method="POST" class="mt-4 space-y-4">
                <input type="hidden" name="task_id_edit" id="task-id-edit">
                
                <input type="text" name="nama_tugas_edit" id="nama-tugas-edit" placeholder="Nama Tugas" required
                    class="input-field w-full">
                
                <textarea name="deskripsi_edit" id="deskripsi-tugas-edit" placeholder="Deskripsi Tugas" required
                    class="input-field w-full h-24 resize-none"></textarea>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-pink-300 text-sm mb-1">Team Member</label>
                        <select name="assigned_to_edit" id="assigned-to-edit" class="input-field">
                            <option value="">-- Tidak Ditugaskan --</option>
                            <?php
                            foreach ($team_members as $m) {
                                echo "<option value='{$m['id']}'>".htmlspecialchars($m['username'])."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="flex flex-col">
                        <label class="text-pink-300 text-sm mb-1">Status Tugas</label>
                        <!-- Manager bisa mengubah status di sini -->
                        <select name="status_edit" id="status-edit" required class="input-field">
                            <option value="belum">Belum</option>
                            <option value="proses">Proses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" name="edit_tugas"
                    class="btn-submit w-full py-3 rounded-lg font-bold transition transform hover:scale-[1.01]">
                    Simpan Perubahan Tugas
                </button>
            </form>
        </div>
    </div>

</body>
</html>
