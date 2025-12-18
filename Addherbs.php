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



$exe = pathinfo($_FILES['HerbImg']['name'], PATHINFO_EXTENSION);

$filename = time() . random_int(1000, 9999) . '.' . $exe;


$sql = "INSERT INTO tbl_products (name, price, unit, cat_id, description,image)
        VALUES ('$name', '$price', '$unit', '$cat_id', '$description','$filename')";

$result = mysqli_query($conn, $sql);

$response['status'] = "true";

echo json_encode($response);

$conn->close();
