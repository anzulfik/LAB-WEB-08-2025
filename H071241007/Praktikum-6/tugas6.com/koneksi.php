<?php
    $DB_HOST = "localhost";
    $DB_USER = "root";
    $DB_PASS = "";
    $DB_NAME = "db_manajemen_proyek";


    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    if (!$conn) {
        die("Koneksi Gagal: " . mysqli_connect_error());
    }
?>