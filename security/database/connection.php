<?php
    try {
        $db_connection = new PDO("mysql:host=127.0.0.1;dbname=db_hatedspotshare;charset=utf8", "root", "");
    } catch (PDOexception $error) {
        die("Failed to connect to the database: " . $error -> getCode());
    }
?>