<?php
    include "/opt/lampp/htdocs/hated/security/authentication/validation.php";

    $msg = "";
    $link = "main.php?page=users/upduser.php";

    $id = $_SESSION['userid'];
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
                    $link = "main.php?page=users/account.php";
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
    header("Location: " . $link . "&message=" . $msg);
?>