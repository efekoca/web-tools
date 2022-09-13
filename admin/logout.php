<?php session_start();
    if(empty($_COOKIE["id"])){
        header("Location: login.php");
        die();
    }
    setcookie("id", null, 0, "/");
    if(!empty($_COOKIE["id"])){
        unset($_COOKIE["id"]);
    }
    header("Location: login.php");
?>