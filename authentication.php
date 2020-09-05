<?php
    session_start();
    if (!isset($_SESSION['sessionid']) || ($_SESSION['sessionid']) != session_id()) {
        $link = "login.php?page=" . $_GET['page'];
    } else {
        $link = $_GET['page'];
    }
    header("Location: " . $link);
    exit;
?>