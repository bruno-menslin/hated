<?php
    include "connection.php";

    $sql = "SELECT image, country, state, city, neighborhood, street, number FROM spots";
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
        ?>
                <div class="spot-item" style="background:#0000fc; width: 400px; display: inline-block;">
                    <img src="<?php echo $spot['image']; ?>" alt="spot image" width="380px" height="300px">
                    <h3><?php echo $spot['country'] . ", " . $spot['state']; ?></h3>
                    <h3><?php echo $spot['city'] . ", " . $spot['neighborhood']; ?></h3>
                    <h3><?php echo $spot['street'] . ", " . $spot['number']; ?></h3>
                </div>
        <?php
            }
        ?>
    </body>
</html>