<?php

function base64UrlDecode($data){
    $paddedData = str_pad($data, ceil(strlen($data) / 4) * 4, '=', STR_PAD_RIGHT);
    return base64_decode(strtr($paddedData, '-_', '+/'));
}