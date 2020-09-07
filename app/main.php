<?php
    include "../security/database/connection.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HATED</title>
    </head>
    <body>
        <div class="content">
            <header>
                <div>
                    <a href="../index.php" class="logo">Hated</a>
                    <a href="main.php?page=users/account.php">Account</a>
                </div>
            </header>
            <main>
                <div class="container">
                    <?php
                        include $_GET['page'];
                    ?>
                </div>
            </main>
        </div>
    </body>
</html>