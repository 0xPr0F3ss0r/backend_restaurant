<?php
include "phpconnect.php";
$email  = fliterRequest("user_email");


$VerifyCode = rand(10000,99999);

$stmt = $con->prepare("SELECT * FROM users WHERE user_email = ?");
$stmt->execute(array($email));
$count = $stmt->rowCount();
//result($count ,$msg = '',$error = 'email not found');

if($count > 0 )  {
    $stmt = $con->prepare("UPDATE users SET user_verifycode='$VerifyCode' Where user_email = ?");
    $stmt->execute(array($email));
    $count = $stmt->rowCount();
    result($count ,$msg='send mail to verify' ,$error = 'email not found');
    //sendMail($email,'verify code Ecommerce',"Verify Code $VerifyCode");

}