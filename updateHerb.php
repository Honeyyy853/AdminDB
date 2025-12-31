<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();

$id          = $_POST["id"];
$name        = $_POST["name"];
$price       = $_POST["price"];
$unit        = $_POST["unit"];
$description = $_POST["description"];
$cat_id      = $_POST["cat_id"];

$sql = "UPDATE tbl_products SET
        name = '$name',
        price = '$price',
        unit = '$unit',
        description = '$description',
        cat_id = '$cat_id'
        WHERE id = '$id'";

$result = mysqli_query($conn, $sql);

if ($result) {
    $response["status"] = "true";
    $response["message"] = "Herb Updated Successfully";
} else {
    $response["status"] = "false";
    $response["message"] = "Error";
}

echo json_encode($response);
$conn->close();
