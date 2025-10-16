<?php
session_start();

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Praktikum 5</title>
    <style>
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #3b0a45, #a83279);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .login-box {
            background: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(0,0,0,0.4);
            width: 340px;
            text-align: center;
        }

        h2 {
            color: #ffb6e6;
            margin-bottom: 20px;
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            outline: none;
            font-size: 15px;
        }

        input[type="text"], input[type="password"] {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        input::placeholder {
            color: #f8cbe5;
        }

        button {
            background: #ff66b2;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 15px;
            width: 95%;
            border-radius: 8px;
            margin-top: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #d44d99;
        }

        .error {
            color: #ffb6b6;
            background: rgba(255, 0, 0, 0.2);
            padding: 8px;
            border-radius: 6px;
            font-size: 14px;
        }

        footer {
            margin-top: 20px;
            font-size: 13px;
            color: #ffe6f7;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='error'>{$_SESSION['error']}</p>";
            unset($_SESSION['error']);
        }
        ?>

        <form action="proses_login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>

        <footer>
            &copy; 2025 Sistem Login 
        </footer>
    </div>
</body>
</html>
