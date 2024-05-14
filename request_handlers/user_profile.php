<?php

$sql = "SELECT login, name, surname, mobilephone, email FROM `main` WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
    
if (!$stmt) {
    http_response_code(555);
    echo json_encode(array(
        "message" => "Помилка підготовлення заяви: " . mysqli_error($conn),
        "success" => false,
        "errorType" => "serverError",
    ));
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $userId);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $dblogin, $dbname, $dbsurname, $dbmobilephone, $email);
mysqli_stmt_fetch($stmt);

echo json_encode(array(
    "success" => true,
    "login" => $dblogin,
    "name" => $dbname,
    "surname" => $dbsurname,
    "mobilephone" => $dbmobilephone,
    "email" => $email
));