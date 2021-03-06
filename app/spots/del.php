<?php
    $spot_code = $_GET['code'];
    include "/opt/lampp/htdocs/hated/security/authentication/validation.php";

    $msg = "";
    $link = "?page=spots/managespots.php";

    $sql = "DELETE FROM spots_has_features WHERE spots_code = :spot_code; DELETE FROM spots WHERE code = :spot_code";
    $stm_sql = $db_connection -> prepare($sql);
    $stm_sql -> bindParam(':spot_code', $spot_code);
    $stm_sql -> bindParam(':user_id', $_SESSION['userid']);
    $result = $stm_sql -> execute();

    if ($result) {
        $msg = "Spot successfully deleted.";
    } else {
        $msg = "Failed to delete spot.";
    }
    header("Location: " . $link . "&message=" . $msg);
?>