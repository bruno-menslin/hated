<?php
    include "connection.php";
    session_start();
    
    $spot_code = $_GET['code'];

    $sql = "DELETE FROM spots_has_features WHERE spots_code = :spot_code; DELETE FROM spots WHERE code = :spot_code AND users_id = :user_id";
    $stm_sql = $db_connection -> prepare($sql);
    $stm_sql -> bindParam(':spot_code', $spot_code);
    $stm_sql -> bindParam(':user_id', $_SESSION['userid']);
    $result = $stm_sql -> execute();

    header("Location: managespots.php");
?>