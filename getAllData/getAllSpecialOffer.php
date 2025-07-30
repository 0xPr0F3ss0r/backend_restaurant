<?php
include "../functions.php";
include "../filterchar.php";
include '../phpconnect.php';

$baseImageUrl = 'http://localhost/Restaurant_backend/upload/SpecialOfferImage/'; // Adjust as needed

try {
    $stmt = $con->prepare("SELECT offerTitle, OfferImage, OfferDescription, OfferPrice, OfferMonth,UserEmail,
    OfferId  
                           FROM specialoffer");
    $stmt->execute();

    // Fetch all matching rows
    $SpecialOffer = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $count = $stmt->rowCount();

    if ($count > 0) {
        foreach ($SpecialOffer as &$offer) {
            if (!empty($offer['OfferImage'])) {
                if (!str_contains($offer['OfferImage'], $baseImageUrl)) {
                    $offer['OfferImage'] = $baseImageUrl . $offer['OfferImage'];
                }
            } else {
                $offer['OfferImage'] = ''; // or a default image
            }
        }
        unset($offer);

        // echo "now all data is" . ${$SpecialOffer};
        //  echo "from backend" . $restoInfos;
        echo json_encode([
            "status" => "success",
            "data" => $SpecialOffer
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
