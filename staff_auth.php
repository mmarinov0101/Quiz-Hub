<?php
    require_once 'db.php';
    if(session_status() == PHP_SESSION_NONE)
        session_start();
    if(empty($_SESSION["username"])) {
        header("Location: ../login.php");
        exit();
    } else{
        $stmt = db_query("SELECT is_staff FROM user WHERE username = '{$_SESSION["username"]}'");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();
        if(!$row['is_staff']){
            header("Location: ../dashboard.php");
            exit();
        }
    }
?>