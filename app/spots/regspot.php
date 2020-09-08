<?php
    include "/opt/lampp/htdocs/hated/security/authentication/validation.php";

    $sql = "SELECT * FROM features";
    $stm_sql = $db_connection -> prepare($sql);
    $stm_sql -> execute();
    $features = $stm_sql -> fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['submit'])) { // to run on submit

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
        } else {
            $sql = "INSERT INTO spots VALUES (:code, :image, :country, :state, :city, :neighborhood, :street, :number, :user_id)";

            $stm_sql = $db_connection -> prepare($sql);

            // session_start();
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

            if ($result) {
                $spot_code = $db_connection -> lastInsertId();

                foreach ($spot_features as $feature_id) {
                    $sql = "INSERT INTO spots_has_features VALUES (:spot_code, :feature_id)";

                    $stm_sql = $db_connection -> prepare($sql);
                    $stm_sql -> bindParam(':spot_code', $spot_code);
                    $stm_sql -> bindParam(':feature_id', $feature_id);

                    $result = $stm_sql -> execute();
                }
            }

            if ($result) {
                $msg = "Spot successfully registered.";
                // header("Location: main.php?page=spots/findspots.php");
            } else {
                $msg = "Failed to register spot.";
            }
        }
        echo $msg;
    }
?>

<div id="page-register-spot" class="page">
    <form action="#" name="register-spot" method="POST">
        <h1>Register spot</h1>
        <fieldset>
            <legend>
                <h2>Spot photo</h2>
            </legend>
            <div class="field">
                <label for="idimage">Image URL</label>
                <input type="text" name="image" id="idimage">
            </div>
        </fieldset>
        <fieldset>
            <legend>
                <h2>Spot features</h2>
            </legend>
            <div class="features-grid">
                <?php
                    foreach ($features as $feature) {
                ?>
                        <div class="feature-grid">
                            <input type="checkbox" name="features[]" id="id<?php echo $feature['name']; ?>" value="<?php echo $feature['id']; ?>" class="feature-checkbox">
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
                <input type="text" name="country" id="idcountry">
            </div>
            <div class="field">
                <label for="idstate">State</label>
                <input type="text" name="state" id="idstate">
            </div>
            <div class="field">
                <label for="idcity">City</label>
                <input type="text" name="city" id="idcity">
            </div>
            <div class="field">
                <label for="idneighborhood">Neighborhood</label>
                <input type="text" name="neighborhood" id="idneighborhood">
            </div>
            <div class="field">
                <label for="idstreet">Street</label>
                <input type="text" name="street" id="idstreet">
            </div>
            <div class="field">
                <label for="idnumber">Number</label>
                <input type="number" name="number" id="idnumber" max="99999">
            </div>            
        </fieldset>
        <div class="form-buttons">
            <button type="submit" name="submit">Register spot</button>
        </div>
    </form>
</div>