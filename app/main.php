<?php
    include "../security/database/connection.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HATED</title>
        <link rel="stylesheet" href="../assets/css/main.css">
        <link rel="stylesheet" href="../assets/css/find-spots.css">
        <link rel="stylesheet" href="../assets/css/register-spots.css">
        <link rel="stylesheet" href="../assets/css/account.css">
    </head>
    <body>
        <header>
            <a href="../index.php" class="logo">Hated</a>
            <a href="main.php?page=users/account.php">Account</a>
        </header>
        <main>
            <?php
                include $_GET['page'];
            ?>
        </main>
        <script src="../assets/js/main.js"></script>
    </body>
</html>