<?php
    include "connection.php";

    $sql = "SELECT * FROM spots";
    $stm_sql = $db_connection -> prepare($sql);
    $stm_sql -> execute();
    $spots = $stm_sql -> fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['submit'])) {
        $search = $_POST['search'];
        $column = $_POST['column'];

        if ($search == "") {
            $sql = "SELECT * FROM spots";
            $stm_sql = $db_connection -> prepare($sql);
            $stm_sql -> execute();
            $spots = $stm_sql -> fetchAll(PDO::FETCH_ASSOC);
        } else {
            if ($column == "") {
                $sql = "SELECT * FROM spots WHERE country = :search OR state = :search OR city = :search OR neighborhood = :search OR street = :search";
                $stm_sql = $db_connection -> prepare($sql);
                $stm_sql -> bindParam(':search', $search);
            } else {
                $sql = "SELECT * FROM spots WHERE $column = :search";
                $stm_sql = $db_connection -> prepare($sql);
                // $stm_sql -> bindParam(':column', $column);
                $stm_sql -> bindParam(':search', $search);
            }
            $stm_sql -> execute();
            $spots = $stm_sql -> fetchAll(PDO::FETCH_ASSOC);            
        }
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
        <form action="#" method="POST">
            <select name="column" id="idcolumn">
                <option value=""></option>
                <option value="country">Country</option>
                <option value="state">State</option>
                <option value="city">City</option>
                <option value="neighborhood">Neighborhood</option>
                <option value="street">Street</option>
            </select>
            <input type="text" name="search" placeholder="Search">
            <button type="submit" name="submit">Search</button>
        </form>
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
                    </div>
        <?php
                }
            } else {
                echo "No spots found.";
            }
        ?>
    </body>
</html>