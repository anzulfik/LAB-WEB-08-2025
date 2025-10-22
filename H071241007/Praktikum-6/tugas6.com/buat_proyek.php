<?php
session_start();
require 'koneksi.php';

//cek anomali url
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: login.php?error=Akses ditolak");
    exit();
}

//khusus manajer
if ($_SESSION['role'] != 'Project Manager') {
    header("Location: login.php?error=Jangan Main Main diks");
    die();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Proyek Baru :: Mission Control</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <a href="dashboard.php">&larr; Kembali ke Dashboard</a>
        <h2>Buat Proyek Baru</h2>

        <form action="proses_tambah_proyek.php" method="POST">
            <div>
                <label for="nama_proyek">Nama Proyek:</label>
                <input type="text" id="nama_proyek" name="nama_proyek" required>
            </div>
            <div>
                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi"></textarea>
            </div>
            <div>
                <label for="tanggal_mulai">Tanggal Mulai:</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" required>
            </div>
            <div>
                <label for="tanggal_selesai">Tanggal Selesai (Target):</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai">
            </div>
            
            <button type="submit">Simpan Proyek</button>
        </form>
    </div>

    <script>
        //js tipis-tipis
        const tanggalMulaiInput = document.getElementById('tanggal_mulai');
        const tanggalSelesaiInput = document.getElementById('tanggal_selesai');

        //untuk logika kalender 
        tanggalMulaiInput.addEventListener('change', function() {
            tanggalSelesaiInput.min = tanggalMulaiInput.value;

            if (tanggalSelesaiInput.value < tanggalMulaiInput.value) {
                tanggalSelesaiInput.value = '';
            }
        });
    </script>
    </body>
</html>