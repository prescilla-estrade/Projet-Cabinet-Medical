<?php

require('fonction_usagers.php');

$http_method = $_SERVER['REQUEST_METHOD'];
switch ($http_method){
    case "GET" :
        if(isset($_GET['id'])) {
            $id = htmlspecialchars($_GET['id']);
            $matchingData = get_usagers_id($id);
            if ($matchingData) {
                deliver_response(200, "Success", $matchingData);
            } else {
                deliver_response(404, "Not Found");
            }
        } else {
            $matchingData = get_usagers();
            deliver_response(200, "Success", $matchingData);
        }
        break;

    case "POST" :
        $data = json_decode(file_get_contents('php://input'), true);
        $matchingData = create_usagers($data);
        deliver_response(201, "Created", $matchingData);
        break;
        
    case "PUT" :
        $data = json_decode(file_get_contents('php://input'), true);
        if(isset($_GET['id'])) {
            $id = htmlspecialchars($_GET['id']);
            $matchingData = update_usagers($id, $data);
            if ($matchingData) {
                deliver_response(200, "Success", $matchingData);
            } else {
                deliver_response(404, "Not Found");
            }
        } 
        break;
    
    case "PATCH" :
        $data = json_decode(file_get_contents('php://input'), true);
        if(isset($_GET['id'])) {
            $id = htmlspecialchars($_GET['id']);
            $matchingData = update_usagers_partially($id, $data);
            if ($matchingData) {
                deliver_response(200, "Success", $matchingData);
            } else {
                deliver_response(404, "Not Found");
            }
        }
        break;
           
    case "DELETE" :
        if(isset($_GET['id'])) {
            $id = htmlspecialchars($_GET['id']);
            $matchingData = delete_usagers($id);
            if ($matchingData) {
                deliver_response(200, "Success", $matchingData);
            } else {
                deliver_response(404, "Not Found");
            }
        }
        break;
        
    default:
        deliver_response(400, "Bad Request");
        break;
}
?>