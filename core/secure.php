<?php session_start();

    function getRandCaptcha($length){
        $str = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPUQRSTUVWXYZ";
        return substr(str_shuffle($str), 0, $length);
    }
    $password = getRandCaptcha(6);
    $_SESSION["secure"] = $password;
    $width = 100;
    $height = 30;
    $img = ImageCreate($width, $height);
    $white = ImageColorAllocate($img, 255, 255, 255);
    $black = ImageColorAllocate($img, 0, 0, 0);
    $rand = ImageColorAllocate($img, rand(0, 255), rand(0, 255), rand(0, 255));
    ImageFill($img, 0, 0, $rand);
    ImageString($img, 5, 24, 7, $_SESSION["secure"], $black);
    ImageLine($img, 100, 19, 0, 15, $white);
    ImageLine($img, rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100), $white);
    ImageLine($img, rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100), $white);
    ImageLine($img, rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100), $white);
    ImageLine($img, rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100), $white);
    ImageLine($img, rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100), $white);
    header("Content-Type: image/png");
    ImagePng($img);
    ImageDestroy($img);
?>