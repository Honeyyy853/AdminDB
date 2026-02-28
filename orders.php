<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$user_id = $_POST['user_id'] ?? '';
$shipping_address = $_POST['shipping_address'] ?? '';
$payment_method   = $_POST['payment_method'] ?? '';
$itemsRaw         = $_POST['items'] ?? '';

$items = json_decode($itemsRaw, true);

if (!$user_id || !is_array($items)) {
    echo json_encode([
        "status" => false,
        "message" => "Invalid data"
        
    ]);
    exit;
}

$order_date     = date('Y-m-d H:i:s');
$order_status   = 'placed';
$payment_status = ($payment_method === 'cod') ? 'pending' : 'paid';

$orderId = time() . rand(1000, 9999);


foreach ($items as $item) {

    $product_id   = $item['product_id'];
    $price        = $item['price'];
    $qty          = $item['quantity'] ?? 1;

    $total_amount = $price * $qty;
    $payment_id = $_POST['payment_id'] ?? '';


    $sql = "INSERT INTO tbl_orders
(user_id, product_id, order_date, order_status, payment_status, total_amount, shipping_address, payment_method, order_id, payment_id)
        VALUES
        ('$user_id', '$product_id', '$order_date', '$order_status', '$payment_status', '$total_amount', '$shipping_address', '$payment_method', '$orderId', '$payment_id')";

    $res = mysqli_query($conn, $sql);

    if (!$res) {
        echo json_encode([
            "status" => false,
            "error" => mysqli_error($conn)
        ]);
        exit;
    }
}

echo json_encode([
    "status" => true
]);

$conn->close();
