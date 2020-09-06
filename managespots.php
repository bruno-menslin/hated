<?php
    include "connection.php";

    session_start();

    $sql = "SELECT * FROM spots WHERE users_id = :user_id";
    $stm_sql = $db_connection -> prepare($sql);
    $stm_sql -> bindParam(':user_id', $_SESSION['userid']);
    $stm_sql -> execute();
    $spots = $stm_sql -> fetchAll(PDO::FETCH_ASSOC);
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
                    <div class="card">
                        <img src="<?php echo $spot['image']; ?>" alt="spot image" width="300px" height="300px">
                        <h3><?php echo $features; ?></h3>
                        <p>
                            <?php echo $spot['country'] . ", " . $spot['state']; ?> <br>
                            <?php echo $spot['city'] . ", " . $spot['neighborhood']; ?> <br>
                            <?php echo $spot['street'] . ", " . $spot['number']; ?>
                        </p>
                        <a href="updspot.php?code=<?php echo $spot['code']; ?>">Update spot</a>
                        <a href="delspot.php?code=<?php echo $spot['code']; ?>">Delete spot</a>
                    </div>
        <?php
                }
            } else {
                echo "No spots found.";
            }            
        ?>
    </body>
</html>