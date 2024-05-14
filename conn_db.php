<?php
$servername = "localhost";
$database = "handbook";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    http_response_code(500);
    //echo json_encode(array("message" => "Підключення до бази даних не вдалось: " . mysqli_connect_error()));
    exit();
}
http_response_code(201);

?>