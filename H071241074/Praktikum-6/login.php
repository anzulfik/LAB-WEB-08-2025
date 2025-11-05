<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body 
  class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat relative" style="background-image: url('asset/bg-hiasan-tuprak5.png');">

  <div class="absolute bg-gradient-to-b from-[#d1299e] to-[#2c1077] w-[1010px] h-[523px] -mt-36 shadow-md" style="z-index: 1;">
  </div>

  <img src="asset/pixel-kecil.png" alt="hiasan" class="absolute top-0 left-0 w-full h-full object-cover pointer-events-none select-none" style="z-index: 20;">

  <div class="relative z-10 border-retro-window bg-[#C3C3C3] shadow-[4px_4px_0_0_#000000] -mt-44 p-6 w-full max-w-md text-black pixel-font">  
    <div class="bg-blue-900 text-white p-1 mb-6 flex justify-between items-center">
        <span class="text-sm">LOGIN.EXE</span>
        <div class="flex space-x-1">
            <button class="w-4 h-4 text-black bg-[#C3C3C3] border-retro-window text-xs leading-none border-black">_</button>
            <button class="w-4 h-4 text-black bg-[#C3C3C3] border-retro-window text-xs leading-none border-black">X</button>
        </div>
    </div>

    <h2 class="text-xl font-bold text-center mb-4 pixel-font">
        Masukkan Informasi Anda
    </h2>
    
    <?php if ($error): ?>
      <div class="bg-red-600 text-white p-2 mb-4 text-center border-2 border-black">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form action="proses_login.php" method="POST" class="space-y-4">
      <label class="block text-sm">Username:</label>
      <input type="text" name="username" placeholder="Username" class="w-full bg-white text-black placeholder-gray-500 border-retro-input p-2 pixel-font" required>
             
      <label class="block text-sm">Password:</label>
      <input type="password" name="password" placeholder="Password" class="w-full bg-white text-black placeholder-gray-500 border-retro-input p-2 pixel-font" required>
             
      <div class="pt-4 flex justify-center space-x-4">
          <button type="submit" class="retro-button font-bold w-2/3 py-2 px-4 text-sm pixel-font bg-[#C3C3C3] text-black transition-all duration-100 ease-in-out">
            Login
          </button>
      </div>
    </form>
  </div>
</body>
