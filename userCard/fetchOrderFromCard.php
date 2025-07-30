<?php
include '../phpconnect.php';
include '../functions.php';
include '../filterchar.php';

$UserEmail = fliterRequest("UserEmail");

try {
    if ($UserEmail) {
        // Fetch records for the specific UserEmail
        $stmt = $con->prepare("SELECT * FROM carduser WHERE UserEmail = ?");
        $stmt->execute([$UserEmail]);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($records) {
            echo json_encode(["status" => "success", "data" => $records]);
        } else {
            echo json_encode(["status" => "fail", "message" => "No records found for this UserEmail"]);
        }
    } else {
        echo json_encode(["status" => "fail", "message" => "Missing UserEmail parameter"]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "fail", "message" => "Database error: " . $e->getMessage()]);
}
