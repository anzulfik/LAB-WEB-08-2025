<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Logout...</title>
    <meta http-equiv="refresh" content="2;url=login.php">
    <style>
        body {
            background: linear-gradient(135deg, #3b0a45, #a83279);
            color: #ffe6f7;
            font-family: "Poppins", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }
        .msg-box {
            background: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(0,0,0,0.3);
        }
        h2 {
            color: #ffb6e6;
        }
        p {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="msg-box">
        <h2>Anda telah logout</h2>
        <p>Mengarahkan kembali ke halaman login...</p>
    </div>
</body>
</html>
