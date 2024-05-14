<?php

require_once "decodeTokens/checkValidJWE.php";
require_once "decodeTokens/getJWTFJWE.php";

function getUserIdJWE($jwe){
    if(checkValidJWE($jwe)){
        $jwt = getJWTFJWE($jwe);
        list($header, $payload, $signature) = explode('.', $jwt);
        $decodedPayload = json_decode(base64UrlDecode($payload), true);
        return $decodedPayload['data']['user_id'];
    }else{
        return false;
    }
}