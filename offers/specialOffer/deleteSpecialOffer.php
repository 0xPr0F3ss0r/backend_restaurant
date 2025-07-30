<?php
include "../../functions.php";
include "../../filterchar.php";
include '../../phpconnect.php';
$OfferId = fliterRequest("OfferId");
$UserEmail = fliterRequest("UserEmail");
try {
    $stmt = $con->prepare("DELETE FROM `specialoffer` WHERE OfferId = :OfferId AND UserEmail = :UserEmail");
    $stmt->bindParam(':OfferId', $OfferId, PDO::PARAM_INT);
    $stmt->bindParam(':UserEmail', $UserEmail, PDO::PARAM_STR);
    $stmt->execute();

    $count = $stmt->rowCount();

    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "fail", "message" => "Special offer not found or no changes were made"));
    }
} catch (PDOException $e) {
    echo json_encode(array("status" => "fail", "message" => $e));
    //"message" => "Database error: " . $e->getMessage())
}
