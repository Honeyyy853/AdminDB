<?php
include '../connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = [];

$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

$response['status'] = true;




$productResult = mysqli_query($conn, "
    SELECT p.id,
           p.name,
           p.description,
           p.price,
           p.unit,
           p.image,
           c.name AS category_name
    FROM tbl_products p
    LEFT JOIN tbl_category c ON p.cat_id = c.id
    WHERE p.cat_id = 1
");

$response['herb'] = [];

if ($productResult) {

    while ($row = mysqli_fetch_assoc($productResult)) {

        $row['cartStatus'] = 0;

        if ($user_id > 0) {

            $productId = (int)$row['id'];

            $cartResult = mysqli_query($conn, "
                SELECT cart_id
                FROM tbl_cart
                WHERE product_id = $productId
                  AND user_id = $user_id
                LIMIT 1
            ");

            if ($cartResult && mysqli_num_rows($cartResult) > 0) {
                $row['cartStatus'] = 1;
            }
        }

        $response['herb'][] = $row;
    }
}



$productResult = mysqli_query($conn, "
    SELECT p.id,
           p.name,
           p.description,
           p.price,
           p.unit,
           p.image,
           c.name AS category_name
    FROM tbl_products p
    LEFT JOIN tbl_category c ON p.cat_id = c.id
    WHERE p.cat_id = 2
");

$response['df'] = [];

if ($productResult) {

    while ($row = mysqli_fetch_assoc($productResult)) {

        $row['cartStatus'] = 0;

        if ($user_id > 0) {

            $productId = (int)$row['id'];

            $cartResult = mysqli_query($conn, "
                SELECT cart_id
                FROM tbl_cart
                WHERE product_id = $productId
                  AND user_id = $user_id
                LIMIT 1
            ");

            if ($cartResult && mysqli_num_rows($cartResult) > 0) {
                $row['cartStatus'] = 1;
            }
        }

        $response['df'][] = $row;
    }
}




$productResult = mysqli_query($conn, "
    SELECT p.id,
           p.name,
           p.description,
           p.price,
           p.unit,
           p.image,
           c.name AS category_name
    FROM tbl_products p
    LEFT JOIN tbl_category c ON p.cat_id = c.id
    WHERE p.cat_id = 3
");

$response['dv'] = [];

if ($productResult) {

    while ($row = mysqli_fetch_assoc($productResult)) {

        $row['cartStatus'] = 0;

        if ($user_id > 0) {

            $productId = (int)$row['id'];

            $cartResult = mysqli_query($conn, "
                SELECT cart_id
                FROM tbl_cart
                WHERE product_id = $productId
                  AND user_id = $user_id
                LIMIT 1
            ");

            if ($cartResult && mysqli_num_rows($cartResult) > 0) {
                $row['cartStatus'] = 1;
            }
        }

        $response['dv'][] = $row;
    }
}

echo json_encode($response);
exit;
