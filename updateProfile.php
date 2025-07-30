<?php
include 'phpconnect.php';
include 'ffilterchar.php';
include 'phpconnect.php';
$user_id = fliterRequest("user_id");
$name = fliterRequest("user_name");
$phone = fliterRequest("user_phone");
$email = fliterRequest("user_email");

$image = UploadFileUpdateInfo("userImage", "userImage");

// If image upload succeeded, update the image column as well
if ($image !== "FAIL" && !empty($image)) {
    $stmt = $con->prepare("UPDATE users SET user_name = ?, user_phone = ?, user_email = ?, user_image = ? WHERE user_id = ?");
    $stmt->execute(array($name, $phone, $email, $image, $user_id));
} else {
    // No image update, just update other fields
    $stmt = $con->prepare("UPDATE users SET user_name = ?, user_phone = ?, user_email = ? WHERE user_id = ?");
    $stmt->execute(array($name, $phone, $email, $user_id));
}

$count = $stmt->rowCount();

if ($count > 0) {
    echo json_encode(array("status" => "success", "message" => "Profile updated successfully"));
} else {
    echo json_encode(array("status" => "error", "message" => "No user found or no changes made"));
}
