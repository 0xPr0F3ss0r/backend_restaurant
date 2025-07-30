<?php
include "../../functions.php";
include "../../filterchar.php";
include '../../phpconnect.php';

$offerTitle = fliterRequest("SpecialOfferTitle");
$description = fliterRequest("SpecialOfferDescription");
$offerPrice = fliterRequest("SpecialOfferPrice");
$OfferMonth = fliterRequest("SpecialOfferMounth");
$UserEmail = fliterRequest(
    "UserEmail"
);
$imagename = UploadFileSpecial("SpecialOfferImage", "SpecialOfferImage");
if ($imagename != "FAIL") {
    try {
        $stmt = $con->prepare("INSERT INTO `specialoffer` (`offerTitle`, `OfferImage`, `OfferDescription`, `OfferPrice`, `OfferMonth`, `UserEmail`) VALUES (?, ?, ?, ?, ?,?)");
        $stmt->execute(array($offerTitle, $imagename, $description, $offerPrice, $OfferMonth, $UserEmail)); // Removed trailing comma here

        $count = $stmt->rowCount();

        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "fail", "message" => "Database error: No rows affected")); // Added more specific message
        }
    } catch (PDOException $e) {
        // Echo the specific error message, not the whole object
        echo json_encode(array("status" => "fail", "message" => "Database error: " . $e->getMessage()));
    }
} else {
    echo json_encode(array("status" => "fail", "message" => "file upload failed"));
}
