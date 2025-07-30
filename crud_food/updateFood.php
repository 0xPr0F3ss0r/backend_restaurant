<?php
include '../phpconnect.php';

$product_id = fliterRequest("product_id");
$name = fliterRequest("name");
$description = fliterRequest("description");
$price = fliterRequest("price");
$category_id = fliterRequest("category_id");
$old_picture = fliterRequest("old_picture");

$imagename = UploadFile($old_picture, "Food");

if ($imagename != "FAIL") {
    // Delete old picture if a new one is uploaded
    DeleteFile("../upload/", $old_picture);
    $stmt = $con->prepare("UPDATE `products` SET `name`=?, `description`=?, `price`=?, `image`=?, `category_id`=? WHERE `product_id`=?");
    $stmt->execute(array($name, $description, $price, $imagename, $category_id, $product_id));
} else {
    // Keep the old picture if no new one is uploaded
    $stmt = $con->prepare("UPDATE `products` SET `name`=?, `description`=?, `price`=?, `category_id`=? WHERE `product_id`=?");
    $stmt->execute(array($name, $description, $price, $category_id, $product_id));
}

$count = $stmt->rowCount();

if ($count > 0) {
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "fail"));
}
