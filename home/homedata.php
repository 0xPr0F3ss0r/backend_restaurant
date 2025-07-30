<?php
include '../phpconnect.php';

$alldata = array();
$alldata['status'] = "success";
$stmtcategories = $con->prepare("SELECT * FROM categories");
$stmtcategories->execute();
$data = $stmtcategories->fetchAll(PDO::FETCH_ASSOC);
$alldata['categories'] = $data;
$count = $stmtcategories->rowCount();
// echo $count;
if($count > 0){
    echo json_encode($alldata);
}else{
    echo json_encode(array("status"=>"fail"));
}


?>