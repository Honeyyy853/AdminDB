<?php

include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();

$name        = $_POST["name"];
$price       = $_POST["price"];
$unit        = $_POST["unit"];
$cat_id      = $_POST["cat_id"];
$description = $_POST["description"];

$sql = "INSERT INTO tbl_products (name, price, unit, cat_id, description)
        VALUES ('$name', '$price', '$unit', '$cat_id', '$description')";

$result = mysqli_query($conn, $sql);

$response['status'] = "true";

echo json_encode($response);

$conn->close();
