<?php
include "../functions.php";
include "../filterchar.php";
include '../phpconnect.php';

$resto_id = fliterRequest("resto_id");  // You must pass this to identify which record to update
$name = fliterRequest("RestaurantName");
$description = fliterRequest("RestaurantDescription");
$restoFacilities = fliterRequest("RestaurantFacilities");
$positionLat = fliterRequest("PositionLat");
$positionLon = fliterRequest("PositionLon");
$restoAddress = fliterRequest("RestaurantAddress");
$UserEmail = fliterRequest("UserEmail");
$imagename = UploadFile("RestaurantImage", "RestaurantImage");

if ($imagename !== "FAIL" && !empty($resto_id)) {
    try {
        // Prepare SQL with named placeholders
        $sql = "UPDATE `restaurantinfo` 
                SET RestaurantName = :name,
                    RestaurantImage = :image,
                    RestaurantDescription = :description,
                    RestaurantAddress = :address,
                    RestaurantFacilities = :facilities,
                    PositionLat = :lat,
                    PositionLon = :lon,
                    UserEmail = :useremail
                WHERE RestaurantId = :resto_id";

        $stmt = $con->prepare($sql);

        // Bind parameters with types
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':image', $imagename, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':address', $restoAddress, PDO::PARAM_STR);
        $stmt->bindParam(':facilities', $restoFacilities, PDO::PARAM_STR);
        $stmt->bindParam(':lat', $positionLat);
        $stmt->bindParam(':lon', $positionLon);
        $stmt->bindParam(':useremail', $UserEmail, PDO::PARAM_STR);
        $stmt->bindParam(':resto_id', $resto_id, PDO::PARAM_INT);

        $stmt->execute();

        $count = $stmt->rowCount();

        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            // Either no row matched or no change was made
            echo json_encode(array("status" => "fail", "message" => "No changes made or restaurant not found."));
        }
    } catch (PDOException $e) {
        echo json_encode(array("status" => "fail", "message" => "Database error: " . $e->getMessage()));
    }
} else {
    echo json_encode(array("status" => "fail", "message" => "File upload failed or missing restaurant ID"));
}
