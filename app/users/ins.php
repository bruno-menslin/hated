<?php
    $msg = "";
    $link = "main.php?page=users/reguser.php&redirect=" . $_GET['redirect'];

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
                    $link = "main.php?page=users/frmlogin.php&redirect=" . $_GET['redirect'];
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
    header("Location: " . $link . "&message=" . $msg);
?>