<?php
    $spot_code = $_GET['code'];
    include "/opt/lampp/htdocs/hated/security/authentication/validation.php";

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
?>
<div id="page-update-spot" class="page">
    <nav>
        <a href="?page=spots/managespots.php">
            <img src="../assets/images/back.svg" alt="back">
        </a>
        <h3>Update spot</h3>
    </nav>
    <form action="main.php?page=spots/upd.php" name="update-spot" method="POST">
        <input type="hidden" name="code" value="<?php echo $spot_code; ?>">
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
            <button type="submit">Update</button>
        </div>
    </form>
</div>