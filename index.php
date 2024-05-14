<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, x-auth-token");

require_once 'tokens/decodeTokens/checkValidJWE.php';
require_once 'tokens/getUserIdJWE.php';
require_once 'conn_db.php';

$tokenHeader = isset($_SERVER['HTTP_X_AUTH_TOKEN']) ? $_SERVER['HTTP_X_AUTH_TOKEN'] : null;

if (!empty($tokenHeader)) {
    $tokenParts = explode(" ", $tokenHeader);

    if (count($tokenParts) === 2 && $tokenParts[0] === "Bearer") {
        $token = $tokenParts[1];

        if(checkValidJWE($token)){
            $userId = getUserIdJWE($token);

            switch($_SERVER['REQUEST_METHOD']){
                case 'POST':;
                case 'GET':
                    $getAction = $_GET['action'];

                    switch($getAction){
                        case 'getPosts':
                            include 'request_handlers/getPosts.php';
                            break;
                        case 'getAllPosts':
                            include 'request_handlers/getAllPosts.php';
                            break;
                        case 'getProfileUserData':
                            include 'request_handlers/user_profile.php';
                            break;
                    }
                    break;
                default:
                    echo json_encode(array(
                    "message" => "Не вірний тип запиту",
                    "success" => false,
                ));
            }
        }else{
            echo json_encode(array(
                    "message" => "Не дійсний токен",
                    "success" => false,
                    "errorType" => "token",
            ));
        }

    } else {
        echo json_encode(array(
            "message" => "Не вірний формат токену",
            "success" => false,
            "errorType" => "token",
    ));
    }
} else {
    echo json_encode(array(
        "message" => "Токен не переданий",
        "success" => false,
        "errorType" => "token",
));
}


?>