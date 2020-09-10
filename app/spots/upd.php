<?php
    $spot_code = $_POST['code'];
    include "/opt/lampp/htdocs/hated/security/authentication/validation.php";    

    $msg = "";
    $link = "main.php?page=spots/updspot.php&code=" . $spot_code;

    $image = $_POST['image'];
    $upd_spot_features = (empty($_POST['features'])) ? NULL : $_POST['features'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $neighborhood = $_POST['neighborhood'];
    $street = $_POST['street'];
    $number = ($_POST['number'] == '') ? NULL : $_POST['number'];

    if ($image == '') {
        $msg = "Fill the image field.";
    } else if ($upd_spot_features == NULL) {
        $msg = "Select atleast one spot feature.";
    } else if ($country == '') {
        $msg = "Fill the country field.";
    } else if ($state == '') {
        $msg = "Fill the state field.";
    } else if ($city == '') {
        $msg = "Fill the city field.";
    } else if ($neighborhood == '') {
        $msg = "Fill the neighborhood field.";
    } else if ($street == '') {
        $msg = "Fill the street field.";
    } else { //update spot

        $sql = "UPDATE spots SET image = :image, country = :country, state = :state, city = :city, neighborhood = :neighborhood, street = :street, number = :number WHERE code = :spot_code";
        $stm_sql = $db_connection -> prepare($sql);

        $user_id = $_SESSION['userid'];

        $stm_sql -> bindParam(':image', $image);
        $stm_sql -> bindParam(':country', $country);
        $stm_sql -> bindParam(':state', $state);
        $stm_sql -> bindParam(':city', $city);
        $stm_sql -> bindParam(':neighborhood', $neighborhood);
        $stm_sql -> bindParam(':street', $street);
        $stm_sql -> bindParam(':number', $number);
        $stm_sql -> bindParam(':spot_code', $spot_code);
        
        $result = $stm_sql -> execute();

        if ($result) { //delete all features from spot
            
            $sql = "DELETE FROM spots_has_features WHERE spots_code = :spot_code";
            $stm_sql = $db_connection -> prepare($sql);
            $stm_sql -> bindParam(':spot_code', $spot_code);
            $stm_sql -> execute();

            foreach ($upd_spot_features as $feature_id) { //register new spot features

                $sql = "INSERT INTO spots_has_features VALUES (:spot_code, :feature_id)";
                $stm_sql = $db_connection -> prepare($sql);
                $stm_sql -> bindParam(':spot_code', $spot_code);
                $stm_sql -> bindParam(':feature_id', $feature_id);
                $result = $stm_sql -> execute();
            }
        }

        if ($result) {
            $msg = "Spot successfully updated.";
            $link = "main.php?page=spots/managespots.php";
        } else {
            $msg = "Failed to update spot.";
        }
    }
    header("Location: " . $link . "&message=" . $msg);
?>