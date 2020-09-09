<?php
    if (isset($_POST['submit'])) {
        include "../database/connection.php";

        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($email == '') {
            $msg = "Fill the email field.";
        } else if ($password == '') {
            $msg = "Fill the password field.";
        } else {
            $sql = "SELECT id, permission FROM users WHERE email = :email AND password = :password";
            $stm_sql = $db_connection -> prepare($sql);

            $password = md5($password);

            $stm_sql -> bindParam(':email', $email);
            $stm_sql -> bindParam(':password', $password);
            $stm_sql -> execute();

            if ($stm_sql -> rowCount() == 1) {
                $user = $stm_sql -> fetch(PDO::FETCH_ASSOC);
                
                session_start();
                $_SESSION['userid'] = $user['id'];
                $_SESSION['userpermission'] = $user['permission'];
                $_SESSION['sessionid'] = session_id();

                if ($_GET['redirect'] == "") {
                    $link = "../../app/main.php?page=users/account.php";
                } else {
                    $link = "../../app/main.php?page=" . $_GET['redirect'];
                }
                header("Location: " . $link);
            } else {
                $msg = "Incorrect email or password.";
            }
        }
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HATED</title>
        <link rel="stylesheet" href="../../assets/css/main.css">
    </head>
    <body>
        <header>
            <a href="../../index.php" class="logo">Hated</a>
            <a href="../../app/main.php?page=users/account.php">Account</a>
        </header>
        <main>
            <div id="page-login" class="page">
                <nav>
                    <a href="../../index.php">
                        <img src="../../assets/images/back.svg" alt="back">
                    </a>
                    <h3>Login</h3>
                </nav>
                <form action="#" name="login" method="POST">
                    <h1>Login</h1>
                    <fieldset>
                        <div class="field">
                            <label for="idemail">E-mail</label>
                            <input type="text" name="email" id="idemail">
                        </div>
                        <div class="field">
                            <label for="idpassword">Password</label>
                            <input type="password" name="password" id="idpassword">
                        </div>                              
                    </fieldset>
                    <div class="form-buttons">
                        <button type="submit" name="submit">Login</button>
                        <a href="../../app/main.php?page=users/reguser.php">Sign up</a>
                    </div> 
                </form>
            </div>          
        </main>   
    </body>
</html>