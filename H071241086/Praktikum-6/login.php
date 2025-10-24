<?php
session_start();

$message = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem Manajemen Proyek</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body {
            background-image: url('assets/bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen font-sans">

    <div class="flex flex-col lg:flex-row items-center justify-center gap-8 lg:gap-16 w-full max-w-6xl px-4">
        
        <!-- Bagian Kiri - Welcome Text -->
        <div class="text-white space-y-6 max-w-xl lg:w-1/2">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold drop-shadow-2xl leading-tight">
                Selamat Datang di<br>Manajemen Proyek
            </h1>
            <div class="h-1 w-24 bg-white/50 rounded"></div>
            <p class="text-lg sm:text-xl text-white/90 drop-shadow-lg">
                Sistem manajemen proyek yang membantu tim Anda bekerja.
            </p>
        </div>

        <!-- Bagian Kanan - Login Form -->
        <div class="backdrop-blur-md bg-white/10 border border-white/20 p-8 sm:p-10 rounded-2xl shadow-2xl w-full max-w-md lg:w-1/2">
            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-6 text-center drop-shadow-lg">
                Masuk ke Sistem
            </h2>

            <?php if (!empty($message)) : ?>
                <div class="bg-red-500/80 backdrop-blur-sm text-white px-4 py-3 rounded-lg mb-4 text-center font-medium">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="proses_login.php" class="space-y-6">
                <input
                    type="text"
                    name="username"
                    placeholder="Username"
                    required
                    class="w-full px-4 py-3 border border-white/30 rounded-lg focus:outline-none
                           focus:ring-2 focus:ring-white/50 text-white placeholder-white/70 text-base sm:text-lg
                           bg-white/20 backdrop-blur-sm"
                >

                <div class="relative">
                    <input
                        id="passwordInput"
                        type="password"
                        name="password"
                        placeholder="Password"
                        required
                        class="w-full px-4 py-3 border border-white/30 rounded-lg focus:outline-none
                               focus:ring-2 focus:ring-white/50 text-white placeholder-white/70 text-base sm:text-lg pr-12
                               bg-white/20 backdrop-blur-sm"
                    >
                    <button
                        id="togglePassword"
                        type="button"
                        aria-pressed="false"
                        class="absolute inset-y-0 right-2 flex items-center px-2 text-white hover:text-white/80 focus:outline-none"
                    >
                        <span id="toggleEmoji">👁️</span>
                    </button>
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-orange-600 to-pink-400 hover:from-orange-600 hover:to-pink-700 text-white font-semibold px-4 py-3
                           rounded-lg text-base sm:text-lg transition transform hover:scale-105 shadow-lg"
                >
                    Masuk
                </button>
            </form>
        </div>

    </div>

    <script>
        (function(){
            const pwdInput = document.getElementById('passwordInput');
            const toggleBtn = document.getElementById('togglePassword');
            const toggleEmoji = document.getElementById('toggleEmoji');

            toggleBtn.addEventListener('click', () => {
                const isPassword = pwdInput.type === 'password';
                pwdInput.type = isPassword ? 'text' : 'password';
                toggleEmoji.textContent = isPassword ? '🙈' : '👁️';
                toggleBtn.setAttribute('aria-pressed', isPassword ? 'true' : 'false'); //pasword tertutup atau tidak 
            });
        })();
    </script>

</body>
</html>