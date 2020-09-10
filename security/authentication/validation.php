<?php
    session_start();
    $link = "";

    if (!isset($db_connection)) {
        $link = "../../index.php";

    } else {
        if (!isset($_SESSION['sessionid']) || ($_SESSION['sessionid']) != session_id()) {
            $link = "main.php?page=users/frmlogin.php&redirect=" . $redirect;

        } else {
            if (isset($spot_code)) {

                $sql = "SELECT users_id FROM spots WHERE code = :spot_code";
                $stm_sql = $db_connection -> prepare($sql);
                $stm_sql -> bindParam(':spot_code', $spot_code);
                $stm_sql -> execute();
                $spot_user = $stm_sql -> fetch(PDO::FETCH_ASSOC);

                if ($spot_user['users_id'] != $_SESSION['userid'] && $_SESSION['userpermission'] != 0) {
                    $link = "?page=spots/managespots.php";
                }
            }
        }
    }
    if ($link != "") {
        header("Location: " . $link);
        exit;
    }
?>