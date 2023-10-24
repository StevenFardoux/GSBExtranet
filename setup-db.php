<?php
    try
    {
        $db = new PDO('mysql:host=localhost', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $db->exec("DROP DATABASE IF EXISTS gsbextranet");
        $db->exec("CREATE DATABASE gsbextranet");
        $db->exec("USE gsbextranet");

        $db->exec(file_get_contents('gsbextranet.sql'));

        echo "Database créée avec succès !";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }