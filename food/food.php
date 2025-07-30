<?php
include "../functions.php";
include "../filterchar.php";
include '../phpconnect.php';
$FoodType = fliterRequest("FoodType");
$FoodName = fliterRequest("FoodName");
$description = fliterRequest("FoodDescription");
$FoodPrice = fliterRequest("FoodPrice");
$UserEmail  = fliterRequest("UserEmail");
$imagename = UploadFileFood("FoodImage", "FoodImage");

if ($imagename != "FAIL") {
    try {
        $stmt = $con->prepare("INSERT INTO `food` (`FoodName`, 
        `FoodType`,`FoodImage`, `FoodDescription`,`FoodPrice`,`UserEmail`) VALUES (?, ?, ?, ?, ?,?)");
        $stmt->execute(array(
            $FoodName,
            $FoodType,
            $imagename,
            $description,
            $FoodPrice,
            $UserEmail
        ));

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
