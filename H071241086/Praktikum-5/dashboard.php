<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user_login = $_SESSION['user'];

include 'data.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-8 font-sans">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-md shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">
                <?php
                if ($user_login['username'] === 'adminxxx') {
                    echo "Selamat Datang, Admin!";
                } else {
                    echo "Selamat Datang, " . htmlspecialchars($user_login['name']) . "!";
                }
                ?>
            </h2>
            <a href="logout.php" class="text-sm text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded">Logout</a>
        </div>

        <?php
        // Jika yang login adalah admin
        if ($user_login['username'] === 'adminxxx') {
            echo "<p class='text-gray-600 mb-4'>Berikut data seluruh pengguna:</p>";
            echo "<div class='overflow-x-auto'>";
            echo "<table class='w-full border border-gray-300 rounded-md'>";
            echo "<thead class='bg-green-200'>
                    <tr>
                        <th class='border px-3 py-2 text-left text-sm'>Email</th>
                        <th class='border px-3 py-2 text-left text-sm'>Username</th>
                        <th class='border px-3 py-2 text-left text-sm'>Nama</th>
                        <th class='border px-3 py-2 text-left text-sm'>Gender</th>
                        <th class='border px-3 py-2 text-left text-sm'>Fakultas</th>
                        <th class='border px-3 py-2 text-left text-sm'>Angkatan</th>
                    </tr>
                  </thead><tbody>";

            foreach ($users as $u) {
                echo "<tr class='hover:bg-green-50'>";
                echo "<td class='border px-3 py-2 text-sm'>" . htmlspecialchars($u['email'] ?? '-') . "</td>";
                echo "<td class='border px-3 py-2 text-sm'>" . htmlspecialchars($u['username'] ?? '-') . "</td>";
                echo "<td class='border px-3 py-2 text-sm'>" . htmlspecialchars($u['name'] ?? '-') . "</td>";
                echo "<td class='border px-3 py-2 text-sm'>" . htmlspecialchars($u['gender'] ?? '-') . "</td>";
                echo "<td class='border px-3 py-2 text-sm'>" . htmlspecialchars($u['faculty'] ?? '-') . "</td>";
                echo "<td class='border px-3 py-2 text-sm'>" . htmlspecialchars($u['batch'] ?? '-') . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table></div>";
        }
        // Jika yang login adalah user biasa
        else {
            echo "<p class='text-gray-600 mb-4'>Berikut data Anda:</p>";
            echo "<table class='w-full border border-gray-300 rounded-md'>";
            echo "<tbody>";
            echo "<tr><th class='border bg-green-100 px-3 py-2 text-left w-1/3'>Email</th><td class='border px-3 py-2'>" . htmlspecialchars($user_login['email']) . "</td></tr>";
            echo "<tr><th class='border bg-green-100 px-3 py-2 text-left'>Username</th><td class='border px-3 py-2'>" . htmlspecialchars($user_login['username']) . "</td></tr>";
            echo "<tr><th class='border bg-green-100 px-3 py-2 text-left'>Gender</th><td class='border px-3 py-2'>" . htmlspecialchars($user_login['gender'] ?? '-') . "</td></tr>";
            echo "<tr><th class='border bg-green-100 px-3 py-2 text-left'>Fakultas</th><td class='border px-3 py-2'>" . htmlspecialchars($user_login['faculty'] ?? '-') . "</td></tr>";
            echo "<tr><th class='border bg-green-100 px-3 py-2 text-left'>Angkatan</th><td class='border px-3 py-2'>" . htmlspecialchars($user_login['batch'] ?? '-') . "</td></tr>";
            echo "</tbody></table>";
        }
        ?>
    </div>

</body>
</html>
