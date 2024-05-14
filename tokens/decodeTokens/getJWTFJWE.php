<?php

require_once "base64UrlDecode.php";

function getJWTFJWE($jwe){
    $jsonString = file_get_contents('jsonFiles/secretJWE.JSON');
    $secretData = json_decode($jsonString, true);

    if ($secretData !== null && isset($secretData['key'])) {
        $encryptionKey = $secretData['key'];
    } else {
        return false;
    }

    list($encodedIv, $encodedCipherText) = explode('.', $jwe);

    //$iv = base64UrlDecode($encodedIv);
    $iv = str_pad(base64UrlDecode($encodedIv), 16, "\0");
    $cipherText = base64UrlDecode($encodedCipherText);
    $decryptedData = openssl_decrypt($cipherText, 'aes-256-cbc', $encryptionKey, OPENSSL_RAW_DATA, $iv);

    return $decryptedData;
}
