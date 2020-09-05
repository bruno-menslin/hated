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
                <div class="spot-item" style="background:#2E323C; width: 400px; display: inline-block; color:#fff;">
                    <img src="<?php echo $spot['image']; ?>" alt="spot image" width="380px" height="300px">

                    <h2 style="color:#ff0000"><?php echo $features; ?></h2>

                    <h3><?php echo $spot['country'] . ", " . $spot['state']; ?></h3>
                    <h3><?php echo $spot['city'] . ", " . $spot['neighborhood']; ?></h3>
                    <h3><?php echo $spot['street'] . ", " . $spot['number']; ?></h3>
                </div>
        <?php
            }
        ?>
    </body>
</html>