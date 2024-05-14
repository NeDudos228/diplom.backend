<?php

require_once "base64UrlEncode.php";

function generateJWE($jwt){
    $jsonString = file_get_contents('jsonFiles/secretJWE.JSON');
    $secretData = json_decode($jsonString, true);
    
    if ($secretData !== null && isset($secretData['key'])) {
        $encryptionKey = $secretData['key'];
    } else {
        echo "Невдалося розкодувати JSON або відсутній ключ 'key'.";
        return false;
    }

    $iv = random_bytes(16);
    $cipherText = openssl_encrypt($jwt, 'aes-256-cbc', $encryptionKey, OPENSSL_RAW_DATA, $iv);
    $encodedCipherText = base64UrlEncode($cipherText);

    $encodedIv = base64UrlEncode($iv);

    return "$encodedIv.$encodedCipherText";
}
