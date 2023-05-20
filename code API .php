<?php
// send_message.php
$phone = 'NUMERO_DE_TELEPHONE_DU_DESTINATAIRE';
$message = 'VOTRE_MESSAGE';

// Utilisez l'API WhatsApp pour envoyer le message
// Remplacez les valeurs de token, instanceId et clientId par vos propres valeurs
$token = 'VOTRE_TOKEN';
$instanceId = 'VOTRE_INSTANCE_ID';
$clientId = 'VOTRE_CLIENT_ID';

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
