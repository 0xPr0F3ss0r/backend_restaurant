<?php
include "../functions.php";
include "../filterchar.php";
include '../phpconnect.php';
$FoodId = fliterRequest("FoodId");
$UserEmail = fliterRequest("UserEmail");
try {
    $stmt = $con->prepare("DELETE FROM `food` WHERE FoodId = :FoodId AND UserEmail = :UserEmail");
    $stmt->bindParam(':FoodId', $FoodId, PDO::PARAM_INT);
    $stmt->bindParam(':UserEmail', $UserEmail, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->rowCount();

    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "fail", "message" => " Food not found or no changes were made"));
    }
} catch (PDOException $e) {
    echo json_encode(array("status" => "fail", "message" => $e));
    //"message" => "Database error: " . $e->getMessage())
}
