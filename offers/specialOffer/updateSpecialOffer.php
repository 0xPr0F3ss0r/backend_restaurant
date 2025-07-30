<?php
include "../../functions.php";
include "../../filterchar.php";
include '../../phpconnect.php';

// Fetch input parameters using your filter function
$offer_id = fliterRequest("OfferId");            // Offer ID for update
$title = fliterRequest("offerTitle");            // Title of the offer
$description = fliterRequest("OfferDescription"); // Description of the offer
$price = fliterRequest("OfferPrice");            // Price of the offer
$month = fliterRequest("OfferMonth");            // Month of the offer
$UserEmail = fliterRequest("UserEmail");         // User email to verify ownership
$imageUploaded = fliterRequest("imageUploaded"); // Flag if image is uploaded

$imagename = ''; // Initialize image name variable

// Check if OfferId is missing
if (empty($offer_id)) {
    echo json_encode([
        "status" => "fail",
        "message" => "Offer ID is missing."
    ]);
    exit;
}

// Handle file upload if imageUploaded flag is true
if ($imageUploaded === "true") {
    $imagename = UploadFileSpecial("SpecialOfferImage", "SpecialOfferImage");
    if ($imagename === "FAIL") {
        // File upload failed
        echo json_encode([
            "status" => "fail",
            "message" => "File upload failed."
        ]);
        exit;
    }
}

try {
    if ($imageUploaded === "true") {
        // Update including new image path
        $sql = "UPDATE `specialoffer` SET
                    offerTitle = :title,
                    OfferDescription = :description,
                    OfferPrice = :price,
                    OfferMonth = :month,
                    OfferImage = :image
                WHERE OfferId = :offer_id AND UserEmail = :useremail";

        $stmt = $con->prepare($sql);

        // Bind parameters with types
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':month', $month, PDO::PARAM_STR);
        $stmt->bindParam(':image', $imagename, PDO::PARAM_STR);
        $stmt->bindParam(':offer_id', $offer_id, PDO::PARAM_INT);
        $stmt->bindParam(':useremail', $UserEmail, PDO::PARAM_STR);
    } else {
        // Update without changing image
        $sql = "UPDATE `specialoffer` SET
                    offerTitle = :title,
                    OfferDescription = :description,
                    OfferPrice = :price,
                    OfferMonth = :month
                WHERE OfferId = :offer_id AND UserEmail = :useremail";

        $stmt = $con->prepare($sql);

        // Bind parameters with types
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':month', $month, PDO::PARAM_STR);
        $stmt->bindParam(':offer_id', $offer_id, PDO::PARAM_INT);
        $stmt->bindParam(':useremail', $UserEmail, PDO::PARAM_STR);
    }

    // Execute the update
    $stmt->execute();

    $count = $stmt->rowCount();

    if ($count > 0) {
        // Successfully updated
        echo json_encode([
            "status" => "success"
        ]);
    } else {
        // No rows updated — possibly no matching record or no data change
        echo json_encode([
            "status" => "fail",
            "message" => "No changes made or offer not found."
        ]);
    }
} catch (PDOException $e) {
    // Handle SQL errors gracefully
    echo json_encode([
        "status" => "fail",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
