<?php
include 'connection.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
$response = array();

$result = mysqli_query($conn, "SELECT * FROM tbl_category");
$response['totalCategories'] = $result->num_rows;

$result = mysqli_query($conn, "SELECT * FROM tbl_products");
// echo $result->num_rows;
$response['totalProducts'] = $result->num_rows;


$result = mysqli_query($conn, "SELECT * FROM tbl_orders");
$response['totalOrders'] = $result->num_rows;

$result = mysqli_query($conn, "SELECT * FROM tbl_order_items");
$response['totalOrderItems'] = $result->num_rows;
$result = mysqli_query($conn, "SELECT * FROM tbl_offers");
$response['totalOffers'] = $result->num_rows;

$result = mysqli_query($conn, "SELECT * FROM tbl_users");
$response['totalUsers'] = $result->num_rows;

$result = mysqli_query($conn, "SELECT * FROM tbl_feedback");
$response['totalFeedback'] = $result->num_rows;


echo json_encode($response);
$conn->close();
