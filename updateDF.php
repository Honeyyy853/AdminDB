<?php
include 'connection.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
$response = array();
$id          = $_POST["id"];
$name        = $_POST["name"];
$price       = $_POST["price"];
$unit        = $_POST["unit"];
$description = $_POST["description"];
$cat_id      = $_POST["cat_id"];
$sql = mysqli_query($conn, "SELECT * FROM tbl_products where id='$id'");
$row = mysqli_fetch_assoc($sql);
$filename = $oldimage = $row["image"];
if (!empty($_FILES["DehydratedFruitImg"]["name"])) {
    unlink("./uploads/DehydratedFruits/" . $oldimage);
    $exe = pathinfo($_FILES['DehydratedFruitImg']['name'], PATHINFO_EXTENSION);
    $filename = time() . random_int(1000, 9999) . '.' . $exe;
    move_uploaded_file($_FILES['DehydratedFruitImg']['tmp_name'], './uploads/DehydratedFruits/' . $filename);
}
$sql = "update tbl_products set
        name = '$name',
        price = '$price',
        unit = '$unit',
        description = '$description',
        cat_id = '$cat_id',
        image = '$filename'
        where id = '$id'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $response["status"] = "true";
    $response["message"] = "Dehydrated Fruit Updated Successfully";
} else {
    $response["status"] = "false";
    $response["message"] = "Error";
}
echo json_encode($response);
$conn->close();
