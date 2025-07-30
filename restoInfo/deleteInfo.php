<?php
include "../functions.php";
include "../filterchar.php";
include '../phpconnect.php';
$resto_id = fliterRequest("resto_id");

try {
    $stmt = $con->prepare("DELETE FROM `restaurantinfo` WHERE RestaurantId = :resto_id");
    $stmt->bindParam(':resto_id', $resto_id);
    $stmt->execute();

    $count = $stmt->rowCount();

    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "fail", "message" => $resto_id));
    }
} catch (PDOException $e) {
    echo json_encode(array("status" => "fail", "message" => $e));
    //"message" => "Database error: " . $e->getMessage())
}
