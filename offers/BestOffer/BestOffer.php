<?php
include "../../functions.php";
include "../../filterchar.php";
include '../../phpconnect.php';

$offerTitle = fliterRequest("BestOfferTitle");
$description = fliterRequest("BestOfferDescription");
$offerPrice = fliterRequest("BestOfferPrice");
$UserEmail = fliterRequest("UserEmail");
// $OfferMonth = fliterRequest("BestOfferMounth");

$imagename = UploadFileBest("BestOfferImage", "BestOfferImage");

if ($imagename != "FAIL") {
    try {
        $stmt = $con->prepare("INSERT INTO `bestoffer` (`offerTitle`, `OfferImage`, `OfferDescription`, `OfferPrice`,`UserEmail`) VALUES (?, ?, ?, ?,?)");
        $stmt->execute(array($offerTitle, $imagename, $description, $offerPrice, $UserEmail)); 

        $count = $stmt->rowCount();

        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "fail", "message" => "Database error: No rows affected")); 
        }
    } catch (PDOException $e) {
        // Echo the specific error message, not the whole object
        echo json_encode(array("status" => "fail", "message" => "Database error: " . $e->getMessage()));
    }
} else {
    echo json_encode(array("status" => "fail", "message" => "file upload failed"));
}
