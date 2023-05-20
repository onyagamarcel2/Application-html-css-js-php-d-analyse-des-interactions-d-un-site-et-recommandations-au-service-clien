<?php

$phone = $_POST['phone'];
$message = $_POST['message'];


$token = 'YOUR_TOKEN';
$instanceId = 'YOUR_INSTANCE_ID';
$clientId = 'YOUR_CLIENT_ID';

$url = "https://api.chat-api.com/instance$instanceId/sendMessage?token=$token";
$data = [
    'phone' => $phone,
    'body' => $message,
];

$options = stream_context_create(['http' => [
    'method'  => 'POST',
    'header'  => 'Content-type: application/json',
    'content' => json_encode($data)
]]);

$response = file_get_contents($url, false, $options);
echo $response;
