<?php
session_start();

//atasi kalau sudah login
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Manajemen Proyek</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

    <div class="container">
        <h2>System Login</h2>

        <?php
        //error handling
        if (isset($_GET['error'])) {
            echo '<p class="error">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>

        <form action="proses_login.php" method="POST">us
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    
    </div>

</body>
</html>