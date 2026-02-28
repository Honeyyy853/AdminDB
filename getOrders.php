<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

$response = [];

$sql = "SELECT * FROM tbl_orders ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

$response['status']  = true;
$response['message'] = 'All orders fetched';
$response['data']    = $data;

echo json_encode($response);
$conn->close();