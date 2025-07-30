<?php
include 'phpconnect.php';
$email = fliterRequest("user_email");
$verify  = fliterRequest("user_verifycode");


$stmt = $con->prepare("SELECT * FROM users WHERE user_email = ? AND user_verifycode = ? ");
$stmt->execute(array($email, $verify));
$count  =  $stmt->rowCount();


result($count ,$msg = 'email verified',$error = 'email not verified');

?>