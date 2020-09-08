<?php
    session_start();
    if (!isset($_SESSION['sessionid']) || ($_SESSION['sessionid']) != session_id()) {
        header("Location: ../security/authentication/login.php?redirect=" . $redirect);
        exit;
    }
?>