<?php
    if (isset($_POST['submit'])) {
        include "connection.php";

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($username == '') {
            $msg = "Fill the username field.";
        } else if ($email == '') {
            $msg = "Fill the email field.";
        } else if ($password == '') {
            $msg = "Fill the password field.";
        } else {
            $sql = "SELECT username FROM users WHERE username = :username";
            $stm_sql = $db_connection -> prepare($sql);
            $stm_sql -> bindParam(':username', $username);
            $stm_sql -> execute();

            if ($stm_sql -> rowCount() == 0) {
                $sql = "SELECT email FROM users WHERE email = :email";
                $stm_sql = $db_connection -> prepare($sql);
                $stm_sql -> bindParam(':email', $email);
                $stm_sql -> execute();

                if ($stm_sql -> rowCount() == 0) {
                    $sql = "INSERT INTO users VALUES (:id, :username, :email, :password, :permission)";

                    $stm_sql = $db_connection -> prepare($sql);

                    $id = NULL;
                    $password = md5($password);
                    $permission = 1;

                    $stm_sql -> bindParam(':id', $id);
                    $stm_sql -> bindParam(':username', $username);
                    $stm_sql -> bindParam(':email', $email);
                    $stm_sql -> bindParam(':password', $password);
                    $stm_sql -> bindParam(':permission', $permission);

                    $result = $stm_sql -> execute();

                    if ($result) {
                        $msg = "User successfully registered.";
                        header("Location: login.php");
                    } else {
                        $msg = "Failed to register user.";
                    }
                } else {
                    $msg = "E-mail already registered.";
                }
            } else {
                $msg = "Username already registered.";
            }
        }
        echo $msg;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HATED</title>
    </head>
    <body>
        <?php include "header.php"; ?>
        <div class="container">
            <form action="#" name="reguser" method="POST">
                <h1>User registration</h1>
                <label for="idusername">Username</label>
                <input type="text" name="username" id="idusername">
                <label for="idemail">E-mail</label>
                <input type="email" name="email" id="idemail">
                <label for="idpassword">Password</label>
                <input type="password" name="password" id="idpassword">
                <button type="submit" name="submit">Register</button>
            </form>
        </div>
    </body>
</html>