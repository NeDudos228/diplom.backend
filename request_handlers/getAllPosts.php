<?php

$sql = "SELECT id, name, category, subcategory FROM `posts`";
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

mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

$resultArray = array();

if (mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_bind_result($stmt, $dbid, $dbname, $dbcategory, $dbsubcategory);

    for ($i=0; mysqli_stmt_fetch($stmt); $i++) { 
        $resultArray[$i] = array(
            "postId" => $dbid,
            "name" => $dbname,
            "category" => $dbcategory,
            "subcategory" => $dbsubcategory,
        );
    }
}
mysqli_stmt_close($stmt);

echo json_encode($resultArray);