<?php
include "../functions.php";
include "../filterchar.php";
include '../phpconnect.php';

$Food_id = fliterRequest("FoodId");
$type = fliterRequest("FoodType");
$name = fliterRequest("FoodName");
$description = fliterRequest("FoodDescription");
$price = fliterRequest("FoodPrice");
$UserEmail = fliterRequest("UserEmail");
$imageUploaded = fliterRequest("imageUploaded");

$imagename = ''; // Initialize image name variable

// Check if FoodId is missing
if (empty($Food_id)) {
    echo json_encode([
        "status" => "fail",
        "message" => "Food ID is missing."
    ]);
    exit;
}

// Handle file upload if imageUploaded flag is true
if ($imageUploaded === "true") {
    $imagename = UploadFileFood("FoodImage", "FoodImage");
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
        try {
            $sql = "UPDATE `food` SET
            FoodType = :Type,
                    FoodName = :name,
                    FoodDescription = :description,
                    FoodPrice = :price,
                    FoodImage = :image
                WHERE FoodId = :Food_id AND UserEmail = :useremail";
            $stmt = $con->prepare($sql);
            // Bind parameters with types
            $stmt->bindParam(':Type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':image', $imagename, PDO::PARAM_STR);
            $stmt->bindParam(':Food_id', $Food_id, PDO::PARAM_INT);
            $stmt->bindParam(':useremail', $UserEmail, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "PDO Error: " . $e->getMessage();
        }
    } else {
        // Update without changing image
        $sql = "UPDATE `food` SET
                      FoodType = :Type,
                    FoodName = :name,
                    FoodDescription = :description,
                    FoodPrice = :price
                WHERE FoodId = :Food_id AND UserEmail = :useremail";

        $stmt = $con->prepare($sql);

        // Bind parameters with types
        $stmt->bindParam(':Type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':Food_id', $Food_id, PDO::PARAM_INT);
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
            "message" => "No changes made or Food not found."
        ]);
    }
} catch (PDOException $e) {
    // Handle SQL errors gracefully
    echo json_encode([
        "status" => "fail",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
