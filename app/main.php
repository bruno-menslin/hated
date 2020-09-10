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
                if (@!include $_GET['page']) {
                    include "404.php";
                }
            ?>
        </main>
        <?php
            if (isset($_GET['message']) && $_GET['message'] != "") {
                $msg = $_GET['message'];
                echo "<script type='text/javascript'> alert('$msg') </script>";
            }
        ?>
        <script src="../assets/js/main.js"></script>
    </body>
</html>