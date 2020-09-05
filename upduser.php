<?php
    include "connection.php";

    session_start();
    $id = $_SESSION['userid'];

    $sql = "SELECT username, email FROM users WHERE id = :id";
    $stm_sql = $db_connection -> prepare($sql);
    $stm_sql -> bindParam(':id', $id);
    $stm_sql -> execute();
    $user = $stm_sql -> fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['submit'])) {
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
            $sql = "SELECT username FROM users WHERE username = :username AND id <> :id";
            $stm_sql = $db_connection -> prepare($sql);
            $stm_sql -> bindParam(':username', $username);
            $stm_sql -> bindParam(':id', $id);
            $stm_sql -> execute();

            if ($stm_sql -> rowCount() == 0) {
                $sql = "SELECT email FROM users WHERE email = :email AND id <> :id";
                $stm_sql = $db_connection -> prepare($sql);
                $stm_sql -> bindParam(':email', $email);
                $stm_sql -> bindParam(':id', $id);
                $stm_sql -> execute();

                if ($stm_sql -> rowCount() == 0) {
                    $sql = "UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id";
                    $stm_sql = $db_connection -> prepare($sql);

                    $password = md5($password);

                    $stm_sql -> bindParam(':username', $username);
                    $stm_sql -> bindParam(':email', $email);
                    $stm_sql -> bindParam(':password', $password);
                    $stm_sql -> bindParam(':id', $id);

                    $result = $stm_sql -> execute();

                    if ($result) {
                        $msg = "User successfully updated.";
                        header("Location: account.php");
                    } else {
                        $msg = "Failed to update user.";
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
                <h1>Update user registration</h1>
                <label for="idusername">Username</label>
                <input type="text" name="username" id="idusername" value="<?php echo $user['username']; ?>">
                <label for="idemail">E-mail</label>
                <input type="email" name="email" id="idemail" value="<?php echo $user['email']; ?>">
                <label for="idpassword">Password</label>
                <input type="password" name="password" id="idpassword">
                <button type="submit" name="submit">Register</button>
            </form>
        </div>
    </body>
</html>