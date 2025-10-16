<?php
session_start();
require 'data.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @font-face {
        font-family: 'Dogicapixel'; 
        src: url('asset/dogicapixel.ttf') format('truetype');
    }
    .pixel-font {
        font-family: 'Dogicapixel', monospace;
    }
    .border-retro-window {
        border-style: solid;
        border-width: 2px;
        border-top-color: #FFFFFF; 
        border-left-color: #FFFFFF;
        border-right-color: #000000;
        border-bottom-color: #000000;
    }
    .retro-button {
        border-style: solid;
        border-width: 2px;
        border-top-color: #FFFFFF;
        border-left-color: #FFFFFF;
        border-right-color: #000000;
        border-bottom-color: #000000;
        box-shadow: 1px 1px 0 0 #000000;
    }
    .retro-button:active {
        border-top-color: #000000;
        border-left-color: #000000;
        border-right-color: #FFFFFF;
        border-bottom-color: #FFFFFF;
        transform: translate(1px, 1px);
        box-shadow: none;
    }
  </style>
</head>
<body 
  class="min-h-screen flex flex-col items-center bg-cover bg-center bg-no-repeat relative pixel-font" style="background-image: url('asset/bg-hiasan-tuprak5.png');">

  <div class="absolute bg-gradient-to-b from-[#d1299e] to-[#2c1077] w-[1010px] h-[523px] mt-7 shadow-md" style="z-index: 1;">
  </div>

  <img src="asset/pixel-kecil.png" alt="hiasan" class="absolute top-0 left-0 w-full h-full object-cover pointer-events-none select-none" style="z-index: 50;">

  <div class="relative z-30 max-w-5xl w-full py-10 px-4">
    <div class="border-retro-window bg-[#C3C3C3] p-4 mb-8 flex justify-between items-center shadow-[4px_4px_0_0_#000000]">
      <h1 class="text-xl font-normal text-black">
        <?= $user['username'] === 'adminxxx' 
            ? 'Selamat Datang, Admin!' : 'Selamat Datang, ' . htmlspecialchars($user['name']) . '!' ?>
      </h1>
      <a href="logout.php" class="retro-button font-bold px-4 py-1 text-sm bg-[#C3C3C3] text-black transition-all duration-100 ease-in-out">
        Logout
      </a>
    </div>

    <?php if ($user['username'] === 'adminxxx'): ?>
      <div class="overflow-x-auto border-retro-window bg-white shadow-[4px_4px_0_0_#000000]">
        <table class="min-w-full border-collapse border-spacing-0">
          <thead class="bg-[#C3C3C3]">
            <tr>
              <th class="py-3 px-4 border border-gray-400 text-sm">Email</th>
              <th class="py-3 px-4 border border-gray-400 text-sm">Username</th>
              <th class="py-3 px-4 border border-gray-400 text-sm">Nama</th>
              <th class="py-3 px-4 border border-gray-400 text-sm">Gender</th>
              <th class="py-3 px-4 border border-gray-400 text-sm">Fakultas</th>
              <th class="py-3 px-4 border border-gray-400 text-sm">Angkatan</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $u): ?>
              <tr class="text-center text-sm text-black border-b border-gray-300 hover:bg-gray-100">
                <td class="py-2 px-4"><?= htmlspecialchars($u['email']) ?></td>
                <td class="py-2 px-4"><?= htmlspecialchars($u['username']) ?></td>
                <td class="py-2 px-4"><?= htmlspecialchars($u['name']) ?></td>
                <td class="py-2 px-4"><?= htmlspecialchars($u['gender'] ?? '-') ?></td>
                <td class="py-2 px-4"><?= htmlspecialchars($u['faculty'] ?? '-') ?></td>
                <td class="py-2 px-4"><?= htmlspecialchars($u['batch'] ?? '-') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    
    <?php else: ?>
      <div class="border-retro-window bg-[#C3C3C3] p-6 shadow-[4px_4px_0_0_#000000] max-w-md mx-auto">
        <h2 class="text-xl font-bold mb-4 text-blue-900">Profil Anda</h2>
        <ul class="space-y-2 text-black text-sm">
          <li><b>Email:</b> <?= htmlspecialchars($user['email']) ?></li>
          <li><b>Username:</b> <?= htmlspecialchars($user['username']) ?></li>
          <li><b>Gender:</b> <?= htmlspecialchars($user['gender'] ?? '-') ?></li>
          <li><b>Fakultas:</b> <?= htmlspecialchars($user['faculty'] ?? '-') ?></li>
          <li><b>Angkatan:</b> <?= htmlspecialchars($user['batch'] ?? '-') ?></li>
        </ul>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
