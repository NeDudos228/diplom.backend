<?php

require_once 'tokens/encodeTokens/generateJWT.php';

$login = $json_data['login'];
$password = $json_data['password'];

$sql = "SELECT id, login, password, name, surname FROM `main` WHERE `login` = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo json_encode(array(
        "message" => "Помилка підготовки запиту: " . mysqli_error($conn),
        "success" => false,
        "errorType" => "serverError",
    ));
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $login);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

mysqli_stmt_bind_result($stmt, $userId, $dbLogin, $dbPassword, $dbname, $dbsurname);

if (mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_fetch($stmt);
    
    if (password_verify($password, $dbPassword)) {
        $token = generateJWT($userId);


        echo json_encode(array(
            "message" => "Авторизовано",
            "success" => true,
            "token" => $token,
            "name" => $dbname,
            "surname" => $dbsurname
        ));
        
    } else {
        echo json_encode(array(
            //"message" => "Невірний пароль.",
            "success" => false,
            "errorType" => "failedAuth",
        ));
    }
} else {
    echo json_encode(array(
        //"message" => "Не знайдено користувача з таким логіном.",
        "success" => false,
        "errorType" => "failedAuth",
    ));
}

mysqli_stmt_close($stmt);

