<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$productName  = trim($_POST['productName']);
$productDesc  = trim($_POST['productDesc']);
$productPrice = $_POST['productPrice'];
$productUnit  = trim($_POST['productUnit']);
$cat_id       = $_POST['cat_id'];

$imageName = NULL;   // ✅ DEFAULT NULL
$offerId  = NULL;    // ✅ KEEP NULL

// ✅ IMAGE OPTIONAL
if (!empty($_FILES['image']['name'])) {
    $imageName = time() . "_" . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $imageName);
}

// REQUIRED FIELD CHECK
if ($productName == "" || $productPrice == "" || $productUnit == "" || $cat_id == "") {
    echo json_encode(["status" => false, "message" => "Missing required fields"]);
    exit;
}

$sql = "INSERT INTO tbl_products 
(name, description, price, unit, image, cat_id, offerId)
VALUES 
('$productName', '$productDesc', '$productPrice', '$productUnit', NULLIF('$imageName',''), '$cat_id', NULL)";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => true]);
} else {
    echo json_encode(["status" => false, "error" => mysqli_error($conn)]);
}

$conn->close();
