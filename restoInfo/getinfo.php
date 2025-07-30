<?php
include "../functions.php";
include "../filterchar.php";
include '../phpconnect.php';

$UserEmail = fliterRequest("UserEmail");
$baseImageUrl = 'http://localhost/Restaurant_backend/upload/RestaurantImage/'; // Adjust as needed

try {
    $stmt = $con->prepare("SELECT RestaurantName, RestaurantImage, PositionLat, PositionLon, RestaurantDescription, RestaurantFacilities, RestaurantAddress ,
    RestaurantId 
                           FROM restaurantinfo 
                           WHERE UserEmail = :userEmail");
    $stmt->bindParam(':userEmail', $UserEmail);
    $stmt->execute();

    // Fetch all matching rows
    $restoInfos = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();

    if ($count > 0) {
        $restoInfos['RestaurantImage'] = $baseImageUrl . $restoInfos['RestaurantImage'];
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
    // Debug print: optional, comment out on production
    /*
    foreach ($restoInfos as $key => $value) {
        echo "key: " . $key . "<br>";
        echo "value: " . print_r($value, true) . "<br>";
    }
    */

    // Prepend base URL to 'RestaurantImage' in each row
    // foreach ($restoInfos as &$resto) {
    //     if (isset($resto['RestaurantImage'])) {
    //         $resto['RestaurantImage'] = $baseImageUrl . $resto['RestaurantImage'];
    //     }
    // }
    // unset($resto); // break the reference, good practice

    // Return JSON with all data including fixed image URLs
    // echo json_encode([
    //     "status" => "success",
    //     "data" => $restoInfos
    // ]);
} catch (PDOException $e) {
    echo json_encode([
        "status" => "fail",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
