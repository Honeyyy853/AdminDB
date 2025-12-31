<?php
include 'connection.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
$response = array();
$id        = $_POST["id"];
$cat_name        = $_POST["cat_name"];
$cat_description        = $_POST["cat_description"];


$sql = "update tbl_category set name = '$cat_name',Description='$cat_description' where id='$id'";
$result = mysqli_query($conn, query: $sql);

if ($result) {
    $response["status"] = "true";
    $response["message"] = "Category Updated Successfully";
} else {
    $response["status"] = "false";
    $response["message"] = "Error";
}
echo json_encode($response);
$conn->close();
