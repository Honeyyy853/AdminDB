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


/* CHECK ORDER ITEMS STATUS */

$check = mysqli_query($conn, "
SELECT 
COUNT(*) total,
SUM(item_status='Delivered') delivered,
SUM(item_status='Cancelled') cancelled,
SUM(item_status='Processing') processing,
SUM(item_status='Shipped') shipped
FROM tbl_order_items
WHERE order_id='$order_id'
");

$row = mysqli_fetch_assoc($check);

$total      = $row['total'];
$delivered  = $row['delivered'];
$cancelled  = $row['cancelled'];
$processing = $row['processing'];
$shipped    = $row['shipped'];

/* ORDER STATUS LOGIC */

/* ORDER STATUS LOGIC */

if ($total == $cancelled) {

    mysqli_query($conn, "
        UPDATE tbl_orders
        SET order_status='Cancelled'
        WHERE order_id='$order_id'
    ");

}
elseif ($total == ($delivered + $cancelled)) {

    mysqli_query($conn, "
        UPDATE tbl_orders
        SET order_status='Completed'
        WHERE order_id='$order_id'
    ");

}
elseif ($processing > 0 || $shipped > 0) {

    mysqli_query($conn, "
        UPDATE tbl_orders
        SET order_status='Processing'
        WHERE order_id='$order_id'
    ");

}
elseif ($delivered > 0) {

    mysqli_query($conn, "
        UPDATE tbl_orders
        SET order_status='Partially Completed'
        WHERE order_id='$order_id'
    ");

}
else {

    mysqli_query($conn, "
        UPDATE tbl_orders
        SET order_status='Pending'
        WHERE order_id='$order_id'
    ");

}

echo json_encode([
    "success" => true,
    "message" => "Item status updated"
]);
?>