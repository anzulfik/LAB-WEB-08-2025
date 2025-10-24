<?php
require 'functions.php';
require_login();
$user = current_user();
$role = $user['role'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard - Manajemen Proyek</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        background-color: #f8f9fa;
        font-family: "Inter", sans-serif;
    }
    .navbar {
        background-color: #ffffff;
        border-bottom: 1px solid #e5e5e5;
    }
    .navbar-brand {
        font-weight: 600;
        color: #007bff !important;
    }
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        background-color: #fff;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    .card i {
        font-size: 1.8rem;
        color: #007bff;
    }
    .card h5 {
        font-weight: 600;
        margin-top: 0.8rem;
    }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <a class="navbar-brand" href="#">Manajemen Proyek</a>
    <div>
        <span class="me-3 text-muted"><?=$user['username']?> (<?=$role?>)</span>
        <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container py-5">
    <h4 class="mb-4 fw-semibold">Dashboard</h4>
    <div class="row g-4">
        <div class="col-md-4">
            <a href="projects.php" class="text-decoration-none text-dark">
                <div class="card text-center p-4">
                    <i class="bi bi-kanban"></i>
                    <h5>Kelola Proyek</h5>
                    <p class="text-muted small mb-0">Tambah dan atur proyek</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="tasks.php" class="text-decoration-none text-dark">
                <div class="card text-center p-4">
                    <i class="bi bi-check2-square"></i>
                    <h5>Kelola Tugas</h5>
                    <p class="text-muted small mb-0">Pantau tugas tim</p>
                </div>
            </a>
        </div>
        <?php if($role === 'superadmin'): ?>
        <div class="col-md-4">
            <a href="users.php" class="text-decoration-none text-dark">
                <div class="card text-center p-4">
                    <i class="bi bi-people"></i>
                    <h5>Manajemen User</h5>
                    <p class="text-muted small mb-0">Atur Project Manager & Member</p>
                </div>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
