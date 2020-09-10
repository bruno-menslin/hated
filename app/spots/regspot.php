<?php
    $redirect = "spots/regspot.php";
    include "../security/authentication/validation.php";

    $sql = "SELECT * FROM features";
    $stm_sql = $db_connection -> prepare($sql);
    $stm_sql -> execute();
    $features = $stm_sql -> fetchAll(PDO::FETCH_ASSOC);
?>
<div id="page-register-spot" class="page">
    <nav>
        <a href="../index.php">
            <img src="../assets/images/back.svg" alt="back">
        </a>
        <h3>Register spot</h3>
    </nav>
    <form action="main.php?page=spots/ins.php" name="register-spot" method="POST">
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
            <button type="submit">Register</button>
        </div>
    </form>
</div>