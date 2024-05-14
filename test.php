<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, x-auth-token");
header('SameSite=None; Secure');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Для обробки запитів OPTIONS (попередній запит для CORS)
    header('HTTP/1.1 200 OK');
    exit;
}
//$json_data = json_decode(file_get_contents('php://input'), true);

//$action = $json_data['action'];
/*switch($action){
    case 1:
        $token = "Test";
        $expirationDate = time() + (7 * 24 * 60 * 60);
        if (setcookie('token', $token, $expirationDate, '/', '', false, false)) {
            echo "Cookie 'token' встановлено!";
        } else {
            echo "Помилка встановлення куки 'token'!";
        }

        if (headers_sent()) {
            echo "Куки встановлено, але заголовки вже відправлені. Куки будуть доступні в наступному запиті.";
        } else {
            echo "Куки встановлено успішно!";
        }
        break;
    case 2:
        print_r($_COOKIE);
        var_dump($_COOKIE);
        break;
}*/
/*$tokenHeader = isset($_SERVER['HTTP_X_AUTH_TOKEN']) ? $_SERVER['HTTP_X_AUTH_TOKEN'] : null;

if (!empty($tokenHeader)) {
    $tokenParts = explode(" ", $tokenHeader);
    
    if (count($tokenParts) === 2 && $tokenParts[0] === "Bearer") {
        $token = $tokenParts[1];
        echo $token;
    } else {
        echo "Invalid token format";
    }
} else {
    echo "Token not provided";
}*/






//require_once "tokens/decodeTokens/getJWTFJWE.php";
//require_once "tokens/decodeTokens/checkValidJWE.php";
//require_once "tokens/encodeTokens/generateJWT.php";
//require_once "tokens/getUserIdJWE.php";

//$encodeData = generateJWT(12);
//echo checkValidJWE($encodeData);
//$decodeJWT = getJWTFJWE($encodeData);
//$decodeData = getUserId($decodeJWT);
//echo "Decoded data " . $decodeData;
//echo "<br>";
//echo getUserIdJWE($encodeData);

require_once 'conn_db.php';
require_once 'functions/setSettingBasicCard.php';

require_once 'functions/getUserIdFromMobilephone.php';
require_once 'functions/getUserIdFromCardnumber.php';
//setSettingBasicCard($conn, 95, 1234567890123456);
//echo getUserIdFromMobilephone($conn, "+380", "0609450642");
//include 'request_handlers/getUserStatistic.php';
require_once 'functions/createCard.php';

createCard($conn, 120);

//print_r(json_encode(getAllUserHistory($conn, 79)));

//print_r($_SERVER);
/*if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'avatars/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded or an error occurred']);
    }
}*/
//move_uploaded_file($uploadFile, 'avatars/testt.jpg')
