    <?php
    $password_plain = 'admin123';
    $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);
    
    echo "Password Plain: " . $password_plain . "<br>";
    echo "Password Hash (Salin ini): " . $password_hash . "<br>";
    ?>

    <?php
    $password_plain = 'manager123';
    $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);
    
    echo "Password Plain: " . $password_plain . "<br>";
    echo "Password Hash (Salin ini): " . $password_hash . "<br>";
    ?>

    <?php
    $password_plain = 'member123';
    $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);
    
    echo "Password Plain: " . $password_plain . "<br>";
    echo "Password Hash (Salin ini): " . $password_hash . "<br>";
    ?>

