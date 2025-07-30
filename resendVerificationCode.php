<?php
include "functions.php";
include "filterchar.php";
include "phpconnect.php";
$verifyCode = rand(10000, 99999);
$name = fliterRequest("name");
$email = fliterRequest("email");
sendEmail($email, $name, "Verification code", "This is your verification code\n$verifyCode", $verifyCode);
