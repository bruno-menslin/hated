<?php
    include "../security/authentication/validation.php";

    $msg = "";
    $link = "main.php?page=spots/regspot.php";

    $image = $_POST['image'];
    $spot_features = (empty($_POST['features'])) ? NULL : $_POST['features'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $neighborhood = $_POST['neighborhood'];
    $street = $_POST['street'];
    $number = ($_POST['number'] == '') ? NULL : $_POST['number'];

    if ($image == '') {
        $msg = "Fill the image field.";
    } else if ($spot_features == NULL) {
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
    } else { //register spot

        $sql = "INSERT INTO spots VALUES (:code, :image, :country, :state, :city, :neighborhood, :street, :number, :user_id)";
        $stm_sql = $db_connection -> prepare($sql);

        $code = NULL;
        $user_id = $_SESSION['userid'];

        $stm_sql -> bindParam(':code', $code);
        $stm_sql -> bindParam(':image', $image);
        $stm_sql -> bindParam(':country', $country);
        $stm_sql -> bindParam(':state', $state);
        $stm_sql -> bindParam(':city', $city);
        $stm_sql -> bindParam(':neighborhood', $neighborhood);
        $stm_sql -> bindParam(':street', $street);
        $stm_sql -> bindParam(':number', $number);
        $stm_sql -> bindParam(':user_id', $user_id);
        
        $result = $stm_sql -> execute();

        if ($result) { //register spot features
            $spot_code = $db_connection -> lastInsertId();

            foreach ($spot_features as $feature_id) {

                $sql = "INSERT INTO spots_has_features VALUES (:spot_code, :feature_id)";
                $stm_sql = $db_connection -> prepare($sql);
                $stm_sql -> bindParam(':spot_code', $spot_code);
                $stm_sql -> bindParam(':feature_id', $feature_id);
                $result = $stm_sql -> execute();

                if (!$result) { //delete spot and its features

                    $sql = "DELETE FROM spots_has_features WHERE spots_code = :spot_code; DELETE FROM spots WHERE code = :spot_code";
                    $stm_sql = $db_connection -> prepare($sql);
                    $stm_sql -> bindParam(':spot_code', $spot_code);
                    $stm_sql -> bindParam(':feature_id', $feature_id);
                    $stm_sql -> execute();
                    
                    break;
                }
            }
        }
        if ($result) {
            $msg = "Spot successfully registered.";
            $link = "main.php?page=spots/findspots.php";
        } else {
            $msg = "Failed to register spot.";
        }
    }
    header("Location: " . $link . "&message=" . $msg);
?>