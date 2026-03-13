<?php
include 'connection.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$order_id   = $_POST['order_id'] ?? '';
$product_id = $_POST['product_id'] ?? '';
$status     = $_POST['order_status'] ?? '';

if (!$order_id || !$product_id || !$status) {
    echo json_encode([
        "success" => false,
        "message" => "Missing data"
    ]);
    exit;
}

/* UPDATE ITEM STATUS */
$sql = "UPDATE tbl_order_items 
        SET item_status='$status'
        WHERE order_id='$order_id'
        AND product_id='$product_id'";

$res = mysqli_query($conn, $sql);

if (!$res) {
    echo json_encode([
        "success" => false,
        "error" => mysqli_error($conn)
    ]);
    exit;
}


$check = mysqli_query($conn, "
SELECT COUNT(*) total,
SUM(item_status='Delivered') Delivered
FROM tbl_order_items
WHERE order_id='$order_id'
");


// echo "
// SELECT COUNT(*) total,
// SUM(item_status='Delivered') delivered
// FROM tbl_order_items
// WHERE order_id='$order_id'
// ";die;

$row = mysqli_fetch_assoc($check);

if ($row['total'] == $row['Delivered']) {


    //echo "all deleivered";die;
    mysqli_query($conn, "
        UPDATE tbl_orders
        SET order_status='Completed'
        WHERE order_id='$order_id'
    ");
} else {
    if ($row['Delivered'] < $row['total']) {
        mysqli_query($conn, "
        UPDATE tbl_orders
        SET order_status='Pending'
        WHERE order_id='$order_id'
    ");
    } elseif ($row['Delivered'] > 0) {
        mysqli_query($conn, "
        UPDATE tbl_orders
        SET order_status='Partially Delivered'
        WHERE order_id='$order_id'  ");
    }
}

echo json_encode([
    "success" => true,
    "message" => "Item status updated"
]);
