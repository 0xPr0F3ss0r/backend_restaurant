<?php
include "../functions.php";
include "../filterchar.php";
include '../phpconnect.php';

// Retrieve and sanitize inputs
$id = fliterRequest("id");  // Primary key or unique id of the record
// $orderName = fliterRequest("orderName");
// $orderType = fliterRequest("orderType");
// $orderPrice = fliterRequest("orderPrice");
$orderCount = fliterRequest("orderCount");

// Try to upload new image if provided
// $uploadedFileName = UploadFile("orderImage", "orderImage");

// If upload failed or no new image uploaded, keep old image (optional approach)
// if ($uploadedFileName === "FAIL" || empty($uploadedFileName)) {
//     // Get current image from DB to retain it
//     $stmt = $con->prepare("SELECT orderImage FROM carduser WHERE id = ?");
//     $stmt->execute([$id]);
//     $result = $stmt->fetch(PDO::FETCH_ASSOC);
//     $uploadedFileName = $result ? $result['orderImage'] : null;
// }

// if (!$id) {
//     echo json_encode(["status" => "fail", "message" => "Missing record ID"]);
//     exit;
// }

try {
    $stmt = $con->prepare("UPDATE `carduser` 
                           SET  orderCount = ?
                           WHERE id = ?");
    $stmt->execute([$orderName, $orderType, $orderPrice, $uploadedFileName, $orderCount, $id]);

    $count = $stmt->rowCount();

    if ($count > 0) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "fail", "message" => "No rows updated or data unchanged."]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "fail", "message" => "Database error: " . $e->getMessage()]);
}
