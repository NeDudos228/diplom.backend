<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Content-Type');


switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        $data = file_get_contents("php://input");
        $json_data = json_decode($data, true);

        
        if ($json_data !== null && isset($json_data['action'])) {
            $action = $json_data['action'];

            include 'conn_db.php';


            switch($action){
                case 1:
                    include 'request_handlers/registration.php';
                    break;
                case 2:
                    include 'request_handlers/login.php';
                    break;
                case 3:
                    include 'request_handlers/check_login.php';
                    break;
            }
        }
        break;
    default:
        echo json_encode(array(
            "message" => "Не вірний тип запиту",
            "success" => false,
        ));
}