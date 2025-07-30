<?php
include "../functions.php";
include "../filterchar.php";
include '../phpconnect.php';

$baseImageUrl = 'http://localhost/Restaurant_backend/upload/BestOfferImage/';

try {
    $stmt = $con->prepare("SELECT offerTitle, OfferImage, OfferDescription, OfferPrice,
    OfferId,UserEmail  
                           FROM bestoffer");
    $stmt->execute();

    // Fetch all matching rows
    $BestOffer = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $count = $stmt->rowCount();

    if ($count > 0) {
        foreach ($BestOffer as &$offer) {
            if (!empty($offer['OfferImage'])) {
                if (!str_contains($offer['OfferImage'], $baseImageUrl)) {
                    $offer['OfferImage'] = $baseImageUrl . $offer['OfferImage'];
                }
            } else {
                $offer['OfferImage'] = '';
            }
        }
        unset($offer);
        echo json_encode([
            "status" => "success",
            "data" => $BestOffer
        ]);
    } else {
        echo json_encode([
            "status" => "fails",
            "data" => $BestOffer
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "status" => "fail",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
