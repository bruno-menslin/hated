<?php
    include "connection.php";

    $sql = "SELECT id, name FROM features";
    $stm_sql = $db_connection -> prepare($sql);
    $stm_sql -> execute();
    $features = $stm_sql -> fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['submit'])) { // to run on submit

        $image = $_POST['image'];
        $spot_features = $_POST['features'];
        $country = $_POST['country'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $neighborhood = $_POST['neighborhood'];
        $street = $_POST['street'];
        $number = ($_POST['number'] == '') ? NULL : $_POST['number'];

        if ($image == '') {
            $msg = "Fill the image field.";
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
            $sql = "INSERT INTO spots VALUES (:code, :image, :country, :state, :city, :neighborhood, :street, :number, :users_id)";

            $stm_sql = $db_connection -> prepare($sql);

            $code = NULL;
            $users_id = 1;

            $stm_sql -> bindParam(':code', $code);
            $stm_sql -> bindParam(':image', $image);
            $stm_sql -> bindParam(':country', $country);
            $stm_sql -> bindParam(':state', $state);
            $stm_sql -> bindParam(':city', $city);
            $stm_sql -> bindParam(':neighborhood', $neighborhood);
            $stm_sql -> bindParam(':street', $street);
            $stm_sql -> bindParam(':number', $number);
            $stm_sql -> bindParam(':users_id', $users_id);
            
            $result = $stm_sql -> execute();

            $spot_code = $db_connection -> lastInsertId();

            foreach ($spot_features as $feature_id) {
                $sql = "INSERT INTO spots_has_features VALUES (:spot_code, :feature_id)";

                $stm_sql = $db_connection -> prepare($sql);
                $stm_sql -> bindParam(':spot_code', $spot_code);
                $stm_sql -> bindParam(':feature_id', $feature_id);

                $result = $stm_sql -> execute();
            }

            if ($result) {
                $msg = "Spot successfully registered.";
                header("Location: findspots.php");
            } else {
                $msg = "Failed to register spot.";
            }
        }
        echo $msg;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HATED</title>
    </head>
    <body>
        <?php include "header.php"; ?>
        <div class="container">
            <form action="#" name="regspot" method="POST">
                <h1>Register spot</h1>
                <fieldset>
                    <legend>
                        <h2>Spot photo</h2>
                    </legend>
                    <label for="idimage">Image (URL)</label>
                    <input type="text" name="image" id="idimage">
                </fieldset>
                <fieldset>
                    <legend>
                        <h2>Spot features</h2>
                    </legend>
                    <?php
                        foreach ($features as $feature) {
                    ?>
                            <input type="checkbox" name="features[]" id="id<?php echo $feature['name']; ?>" value="<?php echo $feature['id']; ?>">
                            <label for="id<?php echo $feature['name']; ?>"><?php echo $feature['name']; ?></label>
                    <?php
                        }
                    ?>
                </fieldset>
                <fieldset>
                    <legend>
                        <h2>Spot location</h2>
                    </legend>
                    <label for="idcountry">Country</label>
                    <input type="text" name="country" id="idcountry">
                    <label for="idstate">State</label>
                    <input type="text" name="state" id="idstate">
                    <label for="idcity">City</label>
                    <input type="text" name="city" id="idcity">
                    <label for="idneighborhood">Neighborhood</label>
                    <input type="text" name="neighborhood" id="idneighborhood">
                    <label for="idstreet">Street</label>
                    <input type="text" name="street" id="idstreet">
                    <label for="idnumber">Number</label>
                    <input type="number" name="number" id="idnumber" max="99999">
                </fieldset>
                <button type="submit" name="submit">Register spot</button>
            </form>
        </div>
    </body>
</html>