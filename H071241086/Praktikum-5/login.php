<?php
session_start():

if {(isset($_SESSION['user']);) 
    header("Location: dashboard.php");
    exit;

}

if {(isset($_SESSION['error']));
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white p-6 rounded-md shadow-md w-80">
        <h2 class="text-center text-xl font-semibold mb-4 text-gray-700">Halaman Login</h2>

        <?php if ($error != ""): ?>
            <p class="text-red-500 text-center mb-3 text-sm"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="proses_login.php" method="POST" class="flex flex-col">
            <label class="text-sm mb-1 text-gray-600">Username</label>
            <input type="text" name="username" required
                class="border border-gray-300 rounded p-2 mb-3 focus:outline-none focus:border-green-400"
                placeholder="Masukkan username">

            <label class="text-sm mb-1 text-gray-600">Password</label>
            <input type="password" name="password" required
                class="border border-gray-300 rounded p-2 mb-4 focus:outline-none focus:border-green-400"
                placeholder="Masukkan password">

            <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white rounded p-2 font-medium">
                Login
            </button>
        </form>
    </div>

</body>
</html>
