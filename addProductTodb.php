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
    $stmt = $con->prepare("INSERT INTO `orders` (`orderName`,`orderPrice`,`orderAdrress` , `orderState`,`UserEmail`) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(array($name, $price, $address, $state, $UserEmail));

    $count = $stmt->rowCount();

    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "fail"));
    }
} catch (PDOException $e) {
    echo json_encode(array("status" => "fail"));
    //"message" => "Database error: " . $e->getMessage())
}
