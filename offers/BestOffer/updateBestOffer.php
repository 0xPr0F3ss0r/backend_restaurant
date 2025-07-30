<?php
include "../../functions.php";
include "../../filterchar.php";
include '../../phpconnect.php';

$offer_id = fliterRequest("OfferId");
$title = fliterRequest("offerTitle");
$description = fliterRequest("OfferDescription");
$price = fliterRequest("OfferPrice");
$UserEmail = fliterRequest("UserEmail");
$imageUploaded = fliterRequest("imageUploaded");

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
    $imagename = UploadFileBest("BestOfferImage", "BestOfferImage");
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
        // echo "id" . $offer_id;
        // echo "title" . $title;
        // echo "desc " . $description;
        // echo "price" . $price;
        // echo "email" . $UserEmail;
        // echo "image" . $imagename;
        try {
            $sql = "UPDATE `bestoffer` SET
                    offerTitle = :title,
                    OfferDescription = :description,
                    OfferPrice = :price,
                    OfferImage = :image
                WHERE OfferId = :offer_id AND UserEmail = :useremail";
            $stmt = $con->prepare($sql);
            // Bind parameters with types
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':image', $imagename, PDO::PARAM_STR);
            $stmt->bindParam(':offer_id', $offer_id, PDO::PARAM_INT);
            $stmt->bindParam(':useremail', $UserEmail, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "PDO Error: " . $e->getMessage();
        }
        // Update including new image path

    } else {
        // Update without changing image
        $sql = "UPDATE `bestoffer` SET
                    offerTitle = :title,
                    OfferDescription = :description,
                    OfferPrice = :price
                WHERE OfferId = :offer_id AND UserEmail = :useremail";

        $stmt = $con->prepare($sql);

        // Bind parameters with types
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':offer_id', $offer_id, PDO::PARAM_INT);
        $stmt->bindParam(':useremail', $UserEmail, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Execute the update


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
