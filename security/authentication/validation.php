<?php
    session_start();
    $link = "";

    if (!isset($db_connection)) { //entrou direto
        $link = "../../index.php";
    } else { //entrou pela main

        if (!isset($_SESSION['sessionid']) || ($_SESSION['sessionid']) != session_id()) { //nao autenticado
            $link = "../security/authentication/login.php?redirect=" . $redirect;

        } else { //autenticado

            if (isset($spot_code)) { //validation em uma pagina que manipula spots

                $sql = "SELECT users_id FROM spots WHERE code = :spot_code";
                $stm_sql = $db_connection -> prepare($sql);
                $stm_sql -> bindParam(':spot_code', $spot_code);
                $stm_sql -> execute();
                $spot_user = $stm_sql -> fetch(PDO::FETCH_ASSOC);

                if ($spot_user['users_id'] != $_SESSION['userid'] && $_SESSION['userpermission'] != 0) { //o spot nao pertence ao usuario e ele nao é adm
                    
                    $link = "?page=spots/managespots.php";
                }
            }
        }
    }

    if ($link != "") {
        header("Location: " . $link);
        exit;
    }
?>