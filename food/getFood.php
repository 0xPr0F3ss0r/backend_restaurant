<?php
include "../functions.php";
include "../filterchar.php";
include '../phpconnect.php';

$UserEmail = fliterRequest("UserEmail");
$baseImageUrl = 'http://localhost/Restaurant_backend/upload/FoodImage/';

try {
    $stmt = $con->prepare("SELECT FoodType, FoodName, FoodImage, FoodDescription,
    FoodPrice,FoodId   
                           FROM food 
                           WHERE UserEmail = :userEmail");
    $stmt->bindParam(':userEmail', $UserEmail);
    $stmt->execute();

    // Fetch all matching rows
    $Food = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $count = $stmt->rowCount();

    if ($count > 0) {
        foreach ($Food as &$food) {
            if (!empty($food['FoodImage'])) {
                if (!str_contains($food['FoodImage'], $baseImageUrl)) {
                    $food['FoodImage'] = $baseImageUrl . $food['FoodImage'];
                }
            } else {
                $food['FoodImage'] = '';
            }
        }
        unset($food);
        echo json_encode([
            "status" => "success",
            "data" => $Food
        ]);
    } else {
        echo json_encode([
            "status" => "fails",
            "data" => $Food
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "status" => "fail",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
