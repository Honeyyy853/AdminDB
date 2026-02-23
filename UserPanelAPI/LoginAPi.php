<?php
include '../connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();

$email_value = isset($_POST["email"]) ? $_POST["email"] : '';
$password_value = isset($_POST["password"]) ? $_POST["password"] : '';


$sql = "SELECT * FROM tbl_users 
        WHERE email='$email_value' 
        AND password='$password_value'";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);

    $response['status']  = "true";
    $response['user_id'] = $row['user_id'];
    $response['email']   = $row['email'];

} else {

    $response['status'] = "false";

}

echo json_encode($response);
$conn->close();
