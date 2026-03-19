<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

include 'connection.php'; // your database connection

require './PHPMailer/PHPMailer/src/PHPMailer.php';
require './PHPMailer/PHPMailer/src/SMTP.php';
require './PHPMailer/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

$data = json_decode(file_get_contents("php://input"), true);

$name = htmlspecialchars($data['name'] ?? '');
$email = htmlspecialchars($data['email'] ?? '');
$phone = htmlspecialchars($data['phone'] ?? '');
$inquiry = htmlspecialchars($data['inquiry_type'] ?? '');
$product = htmlspecialchars($data['product'] ?? '');
$quantity = htmlspecialchars($data['quantity'] ?? '');
$message = htmlspecialchars($data['message'] ?? '');

if(!$name || !$email || !$message){
    echo json_encode([
        "status"=>false,
        "message"=>"Required fields missing"
    ]);
    exit;
}

try {

    /* ==========================
       SAVE INQUIRY IN DATABASE
       ========================== */

    $stmt = $conn->prepare("INSERT INTO tbl_inquiries 
    (name,email,phone,inquiry_type,product,quantity,message) 
    VALUES (?,?,?,?,?,?,?)");

    $stmt->bind_param(
        "sssssss",
        $name,
        $email,
        $phone,
        $inquiry,
        $product,
        $quantity,
        $message
    );

    $stmt->execute();


    /* ==========================
       SEND EMAIL
       ========================== */

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'rathodhoney852003@gmail.com';
    $mail->Password   = 'chbrvsbscagvgath';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('rathodhoney852003@gmail.com', 'Website Inquiry');
    $mail->addAddress('rathodhoney852003@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = "New Business Inquiry - Shree Hari Agritech";

    $mail->Body = "
    <h2>New Inquiry from Website</h2>

    <table border='1' cellpadding='8' cellspacing='0' style='border-collapse:collapse'>
    <tr><td><b>Name</b></td><td>$name</td></tr>
    <tr><td><b>Email</b></td><td>$email</td></tr>
    <tr><td><b>Phone</b></td><td>$phone</td></tr>
    <tr><td><b>Inquiry Type</b></td><td>$inquiry</td></tr>
    <tr><td><b>Product</b></td><td>$product</td></tr>
    <tr><td><b>Quantity</b></td><td>$quantity</td></tr>
    <tr><td><b>Message</b></td><td>$message</td></tr>
    </table>

    <br><b>This message was sent from your website contact form.</b>
    ";

    $mail->send();

    echo json_encode([
        "status"=>true,
        "message"=>"Your inquiry has been sent successfully"
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status"=>false,
        "message"=>"Something went wrong"
    ]);

}

?>