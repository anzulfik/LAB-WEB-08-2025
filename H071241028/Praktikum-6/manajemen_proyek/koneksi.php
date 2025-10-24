<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_manajemen_proyek";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("<h3 style='color:red;'>Koneksi gagal: " . $conn->connect_error . "</h3>");
}
?>
