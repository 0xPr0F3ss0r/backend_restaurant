<?php
include "../functions.php";
include "../filterchar.php";
include '../phpconnect.php';

$baseImageUrl = 'http://localhost/Restaurant_backend/upload/RestaurantImage/'; // Adjust as needed

try {
    $stmt = $con->prepare("SELECT RestaurantName, RestaurantImage, PositionLat, PositionLon, RestaurantDescription, RestaurantFacilities, RestaurantAddress ,
    RestaurantId, UserEmail  
                           FROM restaurantinfo");
    $stmt->execute();

    // Fetch all matching rows
    $restoInfos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();

    if ($count > 0) {
        foreach ($restoInfos as &$restoInfo) {
            if (!empty($restoInfo['RestaurantImage'])) {
                if (!str_contains($restoInfo['RestaurantImage'], $baseImageUrl)) {
                    $restoInfo['RestaurantImage'] = $baseImageUrl . $restoInfo['RestaurantImage'];
                }
            } else {
                $restoInfo['RestaurantImage'] = '';
            }
        }
        unset($restoInfo);
        //  echo "from backend" . $restoInfos;
        echo json_encode([
            "status" => "success",
            "data" => $restoInfos
        ]);
    } else {
        echo json_encode([
            "status" => "fails",
            "data" => $restoInfos
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "status" => "fail",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
