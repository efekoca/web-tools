<?php
    if((basename($_SERVER['PHP_SELF']) == basename(__FILE__)) or (basename($_SERVER['PHP_SELF']) == substr(basename(__FILE__), 0, (strlen(basename(__FILE__)) - 4)))){
        header("Location: ./");
        die();
    }
    try{
        $connect = new PDO("mysql:host=localhost;dbname=DBNAME;charset=UTF8", "DBUSERNAME", "DBPASSWORD");
    }catch(PDOException $err){
        echo("<center> Check your database settings from core/dbConnect.php</center>");
        exit();
    }
?>
