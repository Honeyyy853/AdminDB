<?php
include 'connection.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$user_id = $_GET['user_id'] ?? '';

if (empty($user_id)) {
    echo json_encode([
        "status" => false,
        "message" => "user_id required"
    ]);
    exit;
}

$query = "
SELECT 
    o.order_id,
    o.order_date,
    o.order_status,
    o.total_amount,

    p.id as product_id,
    p.name as product_name,
    p.description,
    p.price,
    p.image,
    p.cat_id

FROM tbl_orders o
LEFT JOIN tbl_products p ON p.id = o.product_id
WHERE o.user_id = '$user_id'
ORDER BY o.order_id DESC
";

$result = mysqli_query($conn, $query);

$orders = [];

while ($row = mysqli_fetch_assoc($result)) {

    $folder = "";

    if ($row['cat_id'] == 1) $folder = "Herbs";
    if ($row['cat_id'] == 2) $folder = "DehydratedFruits";
    if ($row['cat_id'] == 3) $folder = "DehydratedVegetables";

    $imagePath = $folder . "/" . $row['image'];

    $oid = $row['order_id'];

    if (!isset($orders[$oid])) {
        $orders[$oid] = [
            "order_id" => $row['order_id'],
            "order_date" => $row['order_date'],
            "order_status" => $row['order_status'],
            "total_amount" => $row['total_amount'],
            "items" => []
        ];
    }

    $orders[$oid]['items'][] = [
        "product_id"   => $row['product_id'],
        "product_name" => $row['product_name'],
        "description"  => $row['description'],
        "price"        => $row['price'],
        "image"        => $imagePath
    ];
}

echo json_encode([
    "status" => true,
    "data" => array_values($orders)
]);