<?php
include "phpconnect.php";
include "filterchar.php";
$email = fliterRequest("email");
$verifycode = fliterRequest("verifyCode");


$stmt = $con->prepare("SELECT * FROM users WHERE email = ? ");
$stmt->execute(array($email, $verifycode));
$count = $stmt->rowCount();

if ($count > 0) {
    $stmt = $con->prepare("UPDATE users SET user_approve = 1 WHERE email = ?");
    $stmt->execute(array($email));
    $count = $stmt->rowCount();
    result($count, "success", "fail update user_approve");
} else {
    echo json_encode(array("status" => "fail"));
}
