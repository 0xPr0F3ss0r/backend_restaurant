<?php
include '../phpconnect.php';
$foodType = fliterRequest("foodType");
$name = fliterRequest("name");
$description = fliterRequest("description");
$price = fliterRequest("price");
$category_id = fliterRequest("category_id");
$imagename = fliterRequest("imagename");
$imagename = UploadFile($imagename, "Food");

if ($imagename != "FAIL") {
    $stmt = $con->prepare("INSERT INTO `products` (`foodType`,`name`, `description`, `price`, `image`, `category_id`) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute(array($foodType, $name, $description, $price, $imagename, $category_id));

    $count = $stmt->rowCount();

    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "fail"));
    }
} else {
    echo json_encode(array("status" => "fail", "message" => "file upload failed"));
}
