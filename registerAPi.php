<?php
include 'connection.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
$response = array();


$name_value = $_POST["name"];

$email_value = $_POST["email"];

$phone_value = $_POST["phone"];


$password_value = $_POST["password"];


$role_value = $_POST["role"];
$address_value = $_POST["address"];
$sql = "INSERT INTO tbl_users (name, email , phone,password,role,address) VALUES ('$name_value', '$email_value'   , $phone_value, '$password_value', '$role_value','$address_value')";


// echo $sql;die;
$result = mysqli_query($conn, $sql);
if ($result) {
    $response['status'] = "true";
}
echo json_encode($response);
$conn->close();
