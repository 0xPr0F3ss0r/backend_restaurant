<?php
include "functions.php";
include "filterchar.php";
include 'phpconnect.php';
$name = fliterRequest("orderName");
$price = fliterRequest("orderPrice");
//$resto_id = fliterRequest("resto_id");
$address = fliterRequest("orderAdrress");
$state = fliterRequest("orderState");
$UserEmail = fliterRequest(
    "UserEmail"
);

try {
    $stmt = $con->prepare("UPDATE `orders` 
                           SET orderName = :name, 
                               orderPrice = :price, 
                               orderAdrress = :address, 
                               orderState = :state, 
                               UserEmail = :email 
                           WHERE orderId = :id");

    $stmt->execute([
        ':name' => $name,
        ':price' => $price,
        ':address' => $address,
        ':state' => $state,
        ':email' => $UserEmail,
        ':id' => $orderId
    ]);

    $count = $stmt->rowCount();

    if ($count > 0) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "fail", "message" => "No rows updated"]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "fail", "message" => "Database error: " . $e->getMessage()]);
}
