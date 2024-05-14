<?php

require_once 'base64UrlDecode.php';
require_once 'getJWTFJWE.php';

function checkValidJWE($jwe){
    $jsonString = file_get_contents('jsonFiles/secretKey.JSON');
    $secretData = json_decode($jsonString, true);
    
    $jwt = getJWTFJWE($jwe);

    if ($secretData !== null && isset($secretData['key'])) {
        $secretKey = $secretData['key'];
    } else {
        return false;
    }

    list($header, $payload, $signature) = explode('.', $jwt);

    $decodedPayload = json_decode(base64UrlDecode($payload), true);

    $expectedSignature = base64UrlDecode($signature);
    return hash_hmac('sha256', "$header.$payload", $secretKey, true) === $expectedSignature & $decodedPayload['exp'] > time();
}