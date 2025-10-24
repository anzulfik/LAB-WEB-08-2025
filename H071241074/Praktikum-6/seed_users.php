<?php
include "db.php";

$PASSWORD_PLAIN = "password123";
$password_hashed = password_hash($PASSWORD_PLAIN, PASSWORD_DEFAULT);

$users_data = [
    ['superadmin', $password_hashed, 'super admin', null],
    ['pm_pro', $password_hashed, 'project manager', null],
    ['anggota_tim', $password_hashed, 'team member', 2]
];

echo "Memulai proses Data User...\n";

mysqli_begin_transaction($conn);

try {
    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)");

    foreach ($users_data as $user) {
        mysqli_stmt_bind_param($stmt, "sssi", $user[0], $user[1], $user[2], $user[3]);
        mysqli_stmt_execute($stmt);
        echo "Berhasil menambahkan user: " . $user[0] . "\n";
    }

    mysqli_commit($conn);
    echo "\nProses Selesai";

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "\nGagal: " . $e->getMessage() . "\n";
}
?>
