<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__.'/../script/vendor/autoload.php';

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

$app = require_once __DIR__ . '/../script/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();


use Illuminate\Support\Facades\Config;

$host = Config::get('database.connections.mysql.host');
$databaseName = Config::get('database.connections.mysql.database');
$username = Config::get('database.connections.mysql.username');
$password = Config::get('database.connections.mysql.password');

$dsn = "mysql:host=$host;dbname=$databaseName";

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$query = "
    SELECT o.*, u.email, u.first_name
    FROM orders o
    INNER JOIN users u ON u.id = o.vendor_id
    WHERE o.status = '2' AND o.created_at <= NOW() - INTERVAL 24 HOUR 
    -- AND o.created_at >= NOW() - INTERVAL 48 HOUR
    ";
$statement = $db->query($query);
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);
$currentDate = date('Y-m-d H:s');
foreach ($orders as $order) {
    $orderId = $order['id'];
    $vendorEmail = $order['email'];
    $vendorName = $order['first_name'];
    $orderDate = $order['created_at'];
    // Set up your recipient email and mail data
    $recipientEmail = $vendorEmail;
    $subject = "#$orderId New Order Remainder Notification - ".$currentDate;
    $body = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <title>New Order Reminder Notification</title>
</head>
<body>
    <h1>New Order Reminder Notification</h1>
    <p>Dear Cater,
    <p>This is a reminder for the new order placed on $orderDate.</p>
    <p>Please take necessary action and respond accordingly.</p>
    <p>Thank you.</p>
</body>
</html>
EOT;

    
    try {
        Mail::send([], [], function (Message $message) use ($recipientEmail, $subject, $body) {
            $message->to($recipientEmail)
                ->subject($subject)
                ->setBody($body, 'text/html');
        });

        // Email sent successfully
        // Add your success response or further actions here
        echo "Email sent successfully to vendor: $vendorEmail\n";
    } catch (\Exception $e) {
        // Error occurred while sending email
        $errorMessage = $e->getMessage();
        // Handle the error, log it, or return an error response
        // You can use $errorMessage to get the specific error message

        // Example of printing the error response
        echo "Failed to send email: " . $errorMessage;
    }
    
}

// Close the database connection
$db = null;