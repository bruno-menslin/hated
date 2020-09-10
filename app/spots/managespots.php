<?php
    include "/opt/lampp/htdocs/hated/security/authentication/validation.php";

    if ($_SESSION['userpermission'] == 0) {
        $sql = "SELECT * FROM spots";
        $stm_sql = $db_connection -> prepare($sql);
    } else {
        $sql = "SELECT * FROM spots WHERE users_id = :user_id";
        $stm_sql = $db_connection -> prepare($sql);
        $stm_sql -> bindParam(':user_id', $_SESSION['userid']);
    }
    $stm_sql -> execute();
    $spots = $stm_sql -> fetchAll(PDO::FETCH_ASSOC);
?>

<div id="page-manage-spots" class="page">
    <nav>
        <a href="?page=users/account.php">
            <img src="../assets/images/back.svg" alt="back">
        </a>
        <h3>Manage spots</h3>
    </nav>
    <div class="spots">
        <?php
            if (!empty($spots)) {
                foreach ($spots as $spot) {  
                    $features = ""; 

                    $sql = "SELECT features.name FROM spots_has_features INNER JOIN features ON spots_has_features.features_id = features.id WHERE spots_code = :spot_code";
                    $stm_sql = $db_connection -> prepare($sql);
                    $stm_sql -> bindParam(':spot_code', $spot['code']);
                    $stm_sql -> execute();
                    $spot_features = $stm_sql -> fetchAll(PDO::FETCH_ASSOC);

                    foreach ($spot_features as $spot_feature) {
                        if ($features != '') {
                            $features = $features . ", " . $spot_feature['name'];
                        } else {
                            $features = $spot_feature['name'];
                        }
                    }
        ?>
                    <div class="spot">
                        <img src="<?php echo $spot['image']; ?>" alt="Spot image">
                        <div class="spots-buttons">
                            <a href="main.php?page=spots/updspot.php&code=<?php echo $spot['code']; ?>">Update spot</a>
                            <a href="main.php?page=spots/delspot.php&code=<?php echo $spot['code']; ?>">Delete spot</a>
                        </div>
                        <h3><?php echo $features; ?></h3>
                        <p>
                            <?php echo $spot['country'] . ", " . $spot['state']; ?> <br>
                            <?php echo $spot['city'] . ", " . $spot['neighborhood']; ?> <br>
                            <?php
                                if ($spot['number'] == '') {
                                    echo $spot['street'];
                                } else {
                                    echo $spot['street'] . ", " . $spot['number'];
                                }
                            ?>
                        </p>
                    </div>
        <?php
                }
            } else {
                echo "<h2>No spots found.</h2>";
            }            
        ?>
    </div>
</div>