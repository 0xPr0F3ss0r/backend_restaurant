<?php
include "../functions.php";
include "../filterchar.php";
include '../phpconnect.php';
$name = fliterRequest("RestaurantName");
$description = fliterRequest("RestaurantDescription");
//$resto_id = fliterRequest("resto_id");
$restoFacilities = fliterRequest("RestaurantFacilities");
$positionLat = fliterRequest("PositionLat");
$positionLon = fliterRequest("PositionLon");
$restoAddress = fliterRequest("RestaurantAddress");
$UserEmail = fliterRequest(
    "UserEmail"
);
// $name = fliterRequest("RestaurantImage");
// $imagename = UploadFile($name, "RestaurantImage");
$imagename = UploadFile("RestaurantImage", "RestaurantImage");

if ($imagename != "FAIL") {
    try {
        $stmt = $con->prepare("INSERT INTO `restaurantinfo` (`RestaurantName`, `RestaurantImage`, `RestaurantDescription`,`RestaurantAddress` , `RestaurantFacilities`,`PositionLat`,`PositionLon`,`UserEmail`) VALUES (?, ?, ?, ?, ?, ?,?,?)");
        $stmt->execute(array($name, $imagename, $description, $restoAddress, $restoFacilities, $positionLat, $positionLon, $UserEmail));

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
} else {
    echo json_encode(array("status" => "fail", "message" => "file upload failed"));
}
