<?php

    function db_query($query)
    {
        try{
            $pdo = new pdo('mysql:host = localhost; dbname=quiz_system', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
        return $stmt;
    }
?>