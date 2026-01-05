<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$response = [];

$id          = $_POST['id'] ?? '';
$name        = $_POST['name'] ?? '';
$price       = $_POST['price'] ?? '';
$unit        = $_POST['unit'] ?? '';
$description = $_POST['description'] ?? '';

if ($id === '' || $name === '' || $price === '' || $unit === '') {
    echo json_encode([
        "status" => "false",
        "message" => "Required fields missing"
    ]);
    exit;
}
$exe = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
$filename = time() . random_int(1000, 9999) . '.' . $exe;
//echo $filename;die;
move_uploaded_file($_FILES['image']['tmp_name'], './uploads/DehydratedVegetables/' . $filename);
$sql = "
    UPDATE tbl_products SET
        name = '$name',
        price = '$price',
        unit = '$unit',
        description = '$description',
        image = '$filename'
    WHERE id = '$id'
";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        "status" => "true",
        "message" => "DV Updated Successfully"
    ]);
} else {
    echo json_encode([
        "status" => "false",
        "message" => mysqli_error($conn)
    ]);
}

$conn->close();
