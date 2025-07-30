<?php
include "phpconnect.php";
include "filterchar.php";
include "functions.php";
$email  = fliterRequest("email");
$name = fliterRequest("name");

$VerifyCode = rand(10000, 99999);

$stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute(array($email));
$count = $stmt->rowCount();
//result($count ,$msg = '',$error = 'email not found');

if ($count > 0) {
    sendEmail($email, $name, "Verification code", "This is your verification code\n$VerifyCode", $VerifyCode, "code send successfully", "failed to send code");
    // $stmt = $con->prepare("UPDATE users SET user_verifycode='$VerifyCode' Where user_email = ?");
    //  $stmt->execute(array($email));
    // $count = $stmt->rowCount();
    // echo json_encode(array("status" => "success", "message" => "Email  found"));
    // result($count ,$msg='send mail to verify' ,$error = 'email not found');
    //sendMail($email,'verify code Ecommerce',"Verify Code $VerifyCode");

} else {
    echo json_encode(array("status" => "fail", "message" => "Email not found"));
}
