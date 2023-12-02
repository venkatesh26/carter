<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__.'/../script/vendor/autoload.php';

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

$app = require_once __DIR__ . '/../script/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();


// Set up your recipient email and mail data
$recipientEmail = 'ragu.mscit@gmail.com';
$mailData = [
    'order_id' => 12345,
    'order_total' => 100.00
];
$recipientEmail = 'ragu.mscit@gmail.com';
$subject = 'Test Email';
$body = 'This is a test email from Laravel Mail';


Mail::send([], [], function (Message $message) use ($recipientEmail, $subject, $body) {
    $message->to($recipientEmail)
        ->subject($subject)
        ->setBody($body);
});

die;