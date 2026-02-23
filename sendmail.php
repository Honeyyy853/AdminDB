    <?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');



    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require './PHPMailer/PHPMailer/src/PHPMailer.php';

    require './PHPMailer/PHPMailer/src/SMTP.php';
    require './PHPMailer/PHPMailer/src/Exception.php';

    $response = array();

    $email = $_POST["email"];


    try {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Correct Gmail SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'rathodhoney852003@gmail.com'; // Replace with your email
        $mail->Password   = 'chbrvsbscagvgath';   // Use your app password securely
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('rathodhoney852003@gmail.com', 'Honey');
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Our Platform!';
        $mail->Body = " <div style='font-family: Arial, sans-serif; background:#f4f4f4; padding:20px;'> <div style='max-width:600px; margin:auto; background:white; padding:20px; border-radius:8px;'> <h1 style='color:#2e7d32;'>🌿 Welcome to Organic Store!</h1>

```
        <p>Hi <strong>!</strong>,</p>

        <p>Thank you for joining our organic products family! We are committed to providing you with 100% natural, fresh, and eco-friendly products straight from nature.</p>

        <h3>What you can expect from us:</h3>
        <ul>
            <li>✔ Fresh & chemical-free products</li>
            <li>✔ Eco-friendly packaging</li>
            <li>✔ Fast and safe delivery</li>
            <li>✔ Best prices for organic goods</li>
        </ul>

        <p>Start exploring our store and enjoy a healthier lifestyle with organic goodness! 🌱</p>

        <p style='margin-top:20px;'>Best Regards,<br>
        <strong>Organic Store Team</strong></p>
    </div>
</div>
```

";

        $mail->send();

        $response["Status"] = "Success";

        $response["MailStatus"] = "Welcome email sent successfully.";
    } catch (Exception $e) {
        $response["Status"] = "Fail";

        $response["MailStatus"] = "Failed to send welcome email. Error: {$mail->ErrorInfo}";
    }


    // Encode and send JSON response
    $responseJson = json_encode($response);


    echo $responseJson;
