<?php
include "phpconnect.php";
include "filterchar.php";
include "functions.php";
$password = $_POST['password'];
$email = fliterRequest("email");

$stmt = $con->prepare("SELECT * FROM users WHERE email = ? AND user_approve=1");
$stmt->execute(array($email));
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();
if ($count > 0) {
    if (sha1($password) === $data['password']) {
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "fail"));
    }
} else {
    echo json_encode(array("status" => "fail"));
}
