<?php
include 'phpconnect.php';
include 'filterchar.php';
include 'functions.php';
$password = $_POST['password'];
$email = fliterRequest("email");
$email = fliterRequest("email");
$password = sha1($_POST["password"]);

$stmt = $con->prepare("UPDATE users SET password = ? WHERE email = ? ");
$stmt->execute(array($password, $email));
$count = $stmt->rowCount();
if ($count > 0) {
    echo json_encode(array("status" => "success", "message" => "Password updated successfully"));
} else {
    echo json_encode(array("status" => "fail", "message" => "Failed to update password"));
}
//result($count, $msg = 'password updated', $error = 'password not updated');
