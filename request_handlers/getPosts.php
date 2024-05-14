<?php

$sql = "SELECT name, content, category FROM `posts` WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
$postId = $_GET['postId'];

if (!$stmt) {
    http_response_code(555);
    echo json_encode(array(
        "message" => "Помилка підготовлення заяви: " . mysqli_error($conn),
        "success" => false,
        "errorType" => "serverError",
    ));
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $postId);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $dbname, $dbcontent, $dbcategory);
mysqli_stmt_fetch($stmt);

echo json_encode(array(
    "success" => true,
    "name" => $dbname,
    "content" => $dbcontent,
    "category" => $dbcategory,
));