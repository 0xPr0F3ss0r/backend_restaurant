<?php
// include "connect.php";
include "phpconnect.php";
$stmt = $con->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


$count = $stmt->rowCount();

echo $count;
