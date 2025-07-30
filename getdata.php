<?php

include "phpconnect.php";

$user_id = fliterRequest('user_id');

$stmt =  $con ->prepare("SELECT * FROM users WHERE user_id=?");
$stmt->execute(array($user_id));
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$count  = $stmt->rowCount();
if($count > 0) {
    echo json_encode(array("status" => "success", "data" => $data));
}else{
    echo json_encode(array("status" => "fail"));
}