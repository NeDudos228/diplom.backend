<?php

require_once "generateJWE.php";

function generateJWT($userId){
    $jsonString = file_get_contents('jsonFiles/secretKey.JSON');
    $secretData = json_decode($jsonString, true);
    
    if ($secretData !== null && isset($secretData['key'])) {
        $secretKey = $secretData['key'];
    } else {
        return false;
    }

    $data = array(
        "user_id" => $userId,
    );

    //60 minutes
    $expirationTime = time() + 3600;

    $header = base64UrlEncode(json_encode(array("alg" => "HS256", "typ" => "JWT")));

    $payload = base64UrlEncode(json_encode(array(
        'iss' => 'SERVER',
        'iat' => time(),
        'exp' => $expirationTime,
        'data' => $data
    )));

    $signature = hash_hmac('sha256', "$header.$payload", $secretKey, true);
    $encodedSignature = base64UrlEncode($signature);
    
    $token = "$header.$payload.$encodedSignature";
    $jweToken = generateJWE($token);
    
    return $jweToken;
}
