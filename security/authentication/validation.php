<?php
    session_start();
    if (!isset($_SESSION['sessionid']) || ($_SESSION['sessionid']) != session_id()) {
        header("Location: /hated/security/authentication/login.php");
        exit;
    }
?>