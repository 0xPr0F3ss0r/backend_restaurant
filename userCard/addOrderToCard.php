<?php
include "../functions.php";
include "../filterchar.php";
include '../phpconnect.php';

// Retrieve and sanitize inputs
$orderName = fliterRequest("orderName");
$orderType = fliterRequest("orderType");
$orderPrice = fliterRequest("orderPrice");
$orderCount = fliterRequest("orderCount");  // Assuming this is some count number like quantity
$UserEmail = fliterRequest("UserEmail");

// Upload file, returning filename or "FAIL"
$uploadedFileName = UploadFile("orderImage", "orderImage");

if ($uploadedFileName != "FAIL") {
    try {
        $stmt = $con->prepare("INSERT INTO `carduser` (`orderName`, `orderType`, `orderPrice`, `orderImage`, `orderCount`,`UserEmail`) VALUES (?, ?, ?, ?, ?)");

        $stmt->execute([$orderName, $orderType, $orderPrice, $uploadedFileName, $orderCount, $UserEmail]);

        $count = $stmt->rowCount();

        if ($count > 0) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "fail", "message" => "No rows inserted"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "fail", "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "fail", "message" => "File upload failed"]);
}
