<?php
    include "/opt/lampp/htdocs/hated/security/authentication/validation.php";

    $spot_code = $_GET['code'];

    $sql = "SELECT * FROM features";
    $stm_sql = $db_connection -> prepare($sql);
    $stm_sql -> execute();
    $features = $stm_sql -> fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM spots WHERE code = :spot_code";
    $stm_sql = $db_connection -> prepare($sql);
    $stm_sql -> bindParam(':spot_code', $spot_code);
    $stm_sql -> execute();
    $spot = $stm_sql -> fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT features_id FROM spots_has_features WHERE spots_code = :spot_code";
    $stm_sql = $db_connection -> prepare($sql);
    $stm_sql -> bindParam(':spot_code', $spot_code);
    $stm_sql -> execute();
    $spot_features = $stm_sql -> fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['submit'])) {

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
        } else {
            // update table 'spots'
            $sql = "UPDATE spots SET image = :image, country = :country, state = :state, city = :city, neighborhood = :neighborhood, street = :street, number = :number WHERE code = :spot_code AND users_id = :user_id";

            $stm_sql = $db_connection -> prepare($sql);

            // session_start();
            $user_id = $_SESSION['userid'];

            $stm_sql -> bindParam(':image', $image);
            $stm_sql -> bindParam(':country', $country);
            $stm_sql -> bindParam(':state', $state);
            $stm_sql -> bindParam(':city', $city);
            $stm_sql -> bindParam(':neighborhood', $neighborhood);
            $stm_sql -> bindParam(':street', $street);
            $stm_sql -> bindParam(':number', $number);
            $stm_sql -> bindParam(':spot_code', $spot_code);
            $stm_sql -> bindParam(':user_id', $user_id);
            
            $result = $stm_sql -> execute();

            if ($result) {
                // delete all features from spot
                $sql = "DELETE FROM spots_has_features WHERE spots_code = :spot_code";
                $stm_sql = $db_connection -> prepare($sql);
                $stm_sql -> bindParam(':spot_code', $spot_code);
                $result = $stm_sql -> execute();

                // insert new features of the spot
                foreach ($upd_spot_features as $feature_id) {
                    $sql = "INSERT INTO spots_has_features VALUES (:spot_code, :feature_id)";
    
                    $stm_sql = $db_connection -> prepare($sql);
                    $stm_sql -> bindParam(':spot_code', $spot_code);
                    $stm_sql -> bindParam(':feature_id', $feature_id);
    
                    $result = $stm_sql -> execute();
                }
            }

            if ($result) {
                $msg = "Spot successfully updated.";
            } else {
                $msg = "Failed to update spot.";
            }
        }
        echo "
            <script type='text/javascript'>
                alert('$msg');
                if ('$msg' == 'Spot successfully updated.') {
                    window.location = '?page=spots/managespots.php';
                }
            </script>
        ";
    }
?>

<div id="page-update-spot" class="page">
    <nav>
        <a href="?page=users/account.php">
            <img src="../assets/images/back.svg" alt="back">
        </a>
        <h3>Update spot</h3>
    </nav>
    <form action="#" name="update-spot" method="POST">
        <h1>Update spot</h1>
        <fieldset>
            <legend>
                <h2>Spot photo</h2>
            </legend>
            <div class="field">
                <label for="idimage">Image (URL)</label>
                <input type="text" name="image" id="idimage" value="<?php echo $spot['image']; ?>">
            </div>
        </fieldset>
        <fieldset>
            <legend>
                <h2>Spot features</h2>
            </legend>
            <div class="features-grid">
                <?php
                    foreach ($features as $feature) {
                        $checked = '';
                        foreach ($spot_features as $spot_feature) {
                            if ($spot_feature['features_id'] == $feature['id']) {
                                $checked = "checked";
                            }
                        }
                ?>
                        <div class="feature-grid">
                            <input type="checkbox" name="features[]" id="id<?php echo $feature['name']; ?>" value="<?php echo $feature['id']; ?>" <?php echo $checked; ?> class="feature-checkbox">
                            <label for="id<?php echo $feature['name']; ?>" class="feature-label"><?php echo $feature['name']; ?></label>
                        </div>
                <?php
                    }
                ?>
            </div>
        </fieldset>
        <fieldset>
            <legend>
                <h2>Spot location</h2>
            </legend>
            <div class="field">
                <label for="idcountry">Country</label>
                <input type="text" name="country" id="idcountry" value="<?php echo $spot['country']; ?>">
            </div>
            <div class="field">
                <label for="idstate">State</label>
                <input type="text" name="state" id="idstate" value="<?php echo $spot['state']; ?>">
            </div>
            <div class="field">
                <label for="idcity">City</label>
                <input type="text" name="city" id="idcity" value="<?php echo $spot['city']; ?>">
            </div>
            <div class="field">
                <label for="idneighborhood">Neighborhood</label>
                <input type="text" name="neighborhood" id="idneighborhood" value="<?php echo $spot['neighborhood']; ?>">
            </div>
            <div class="field">
                <label for="idstreet">Street</label>
                <input type="text" name="street" id="idstreet" value="<?php echo $spot['street']; ?>">
            </div>    
            <div class="field">
                <label for="idnumber">Number</label>
                <input type="number" name="number" id="idnumber" max="99999" value="<?php echo $spot['number']; ?>">
            </div>            
        </fieldset>
        <div class="form-buttons">
            <button type="submit" name="submit">Update</button>
        </div>
    </form>
</div>