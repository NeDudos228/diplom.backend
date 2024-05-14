<?php


require_once 'functions/checkLogin.php';
require_once 'tokens/encodeTokens/generateJWT.php';
require_once 'functions/emptyCheck.php';

$debug = true;


$name = emptyCheck($json_data, 'name');
$surname = emptyCheck($json_data, 'surname');
$login = emptyCheck($json_data, 'login');
$password = emptyCheck($json_data, 'password');
$phone = emptyCheck($json_data, 'phone');
$email = emptyCheck($json_data, 'email');
$codeCountry = emptyCheck($json_data, 'codeCountry');
$currentDateTime  = date('Y-m-d H:i:s');


if (!($name && $surname && $login && $password && $phone && $email && $codeCountry) && !$debug) {
    echo json_encode(array(
        "message" => "Не всі обов'язкові поля надіслані.",
        "success" => false,
        "errorType" => "gyhujmi",
    ));
    exit();
}

if(checkLogin($conn, $login)) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO `main` (login, password, name, surname, mobilephone, email, data) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(array(
            "message" => "Помилка підготовлення заяви: " . mysqli_error($conn),
            "success" => false,
            "errorType" => "serverError",
        ));
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssss", $login, $hashedPassword, $name, $surname, $phone, $email, $currentDateTime);

    if (mysqli_stmt_execute($stmt)) {
        $insertedUserId = mysqli_insert_id($conn);
        $token = generateJWT($insertedUserId);
        echo json_encode(array(
            "message" => "Користувача успішно зареєстровано",
            "success" => true,
            "token" => $token,
            "name" => $name,
            "surname" => $surname
        ));            
        
    } else {
        echo json_encode(array(
            "message" => "Помилка виконання заяви: " .mysqli_stmt_error($stmt),
            "success" => false,
            "errorType" => "serverError",
        ));
    }
    mysqli_stmt_close($stmt);
}else{
    echo json_encode(array(
        "message" => "Логін зайнятий",
        "success" => false,
        "errorType" => "occupiedLogin",
    ));
}



