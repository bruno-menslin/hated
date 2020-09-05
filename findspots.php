<?php
    include "connection.php";

    $sql = "SELECT * FROM spots";
    $stm_sql = $db_connection -> prepare($sql);
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
                </div>
        <?php
            }
        ?>
    </body>
</html>