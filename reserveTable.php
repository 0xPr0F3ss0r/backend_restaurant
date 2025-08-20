<?php
include "functions.php";
include "filterchar.php";
include 'phpconnect.php';

$resto_id = fliterRequest("resto_id"); 
$tabelsReserved = fliterRequest("tabelsReserved");


if ($imagename !== "FAIL" && !empty($resto_id)) {
    try {
        // Prepare SQL with named placeholders
        $sql = "UPDATE `restaurantinfo` 
                SET tabelsReserved = :tabelsReserved
                WHERE RestaurantId = :resto_id";

        $stmt = $con->prepare($sql);

        // Bind parameters with types
        $stmt->bindParam(':tabelsReserved', $tabelsReserved, PDO::PARAM_STR);

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
