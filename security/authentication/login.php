<?php
    include "../database/connection.php";

    $msg = "";
    $link = "../../app/main.php?page=users/frmlogin.php&redirect=" . $_POST['redirect'];

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

            if ($_POST['redirect'] == "") {
                $link = "../../app/main.php?page=users/account.php";
            } else {
                $link = "../../app/main.php?page=" . $_POST['redirect'];
            }
        } else {
            $msg = "Incorrect email or password.";
        }
    }
    header("Location: " . $link . "&message=" . $msg);
?>