<?php

function checkLogin($conn, $login){
    $sql = "SELECT login FROM `main` WHERE `login` = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(array(
            "message" => "Помилка підготовки запиту: " . mysqli_error($conn),
            "success" => false,
        ));
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $login);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    mysqli_stmt_bind_result($stmt, $dbLogin);

    $res = !mysqli_stmt_num_rows($stmt);

    mysqli_stmt_close($stmt);
    return $res;
}