<?php
include "functions.php";
include "filterchar.php";
include 'phpconnect.php';

$query = fliterRequest("query");
$baseImageUrl = 'http://localhost/Restaurant_backend/upload/RestaurantImage/';

try {
    // Add % wildcard at the end for "starts with"
    $queryParam = $query . '%';

    $stmt = $con->prepare("
        SELECT RestaurantName, RestaurantImage, PositionLat, PositionLon, RestaurantDescription, RestaurantFacilities, RestaurantAddress,
               RestaurantId, UserEmail
        FROM restaurantinfo
        WHERE RestaurantName LIKE :query
    ");
    $stmt->bindParam(':query', $queryParam, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch all matching rows
    $restoInfos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($restoInfos);

    if ($count > 0) {
        // Prefix image URL for each row if needed
        foreach ($restoInfos as &$resto) {
            if (!empty($resto['RestaurantImage']) && !str_contains($resto['RestaurantImage'], $baseImageUrl)) {
                $resto['RestaurantImage'] = $baseImageUrl . $resto['RestaurantImage'];
            } elseif (empty($resto['RestaurantImage'])) {
                $resto['RestaurantImage'] = '';
            }
        }
        // Return data as JSON
        echo json_encode([
            "status" => "success",
            "data" => $restoInfos
        ]);
    } else {
        echo json_encode([
            "status" => "fails",
            "data" => []
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "status" => "fail",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
