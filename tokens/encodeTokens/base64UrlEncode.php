<?php 

function base64UrlEncode($data){
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}