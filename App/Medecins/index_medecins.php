<?php

require('fonction_medecins.php');

$http_method = $_SERVER['REQUEST_METHOD'];
switch ($http_method){
    case "GET" :
        if(isset($_GET['id'])) {
            $id = htmlspecialchars($_GET['id']);
            $matchingData = get_medecins_id($id);
            if ($matchingData) {
                deliver_response(200, "Success", $matchingData);
            } else {
                deliver_response(404, "Not Found");
            }
        } else {
            $matchingData = get_medecins();
            deliver_response(200, "Success", $matchingData);
        }
        break;

    case "POST" :
        $data = json_decode(file_get_contents('php://input'), true);
        $matchingData = create_medecins($data);
        deliver_response(201, "Created", $matchingData);
        break;
        
    case "PUT" :
        $data = json_decode(file_get_contents('php://input'), true);
        if(isset($_GET['id'])) {
            $id = htmlspecialchars($_GET['id']);
            $matchingData = update_medecins($id, $data);
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
            $matchingData = update_medecins_partially($id, $data);
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
            $matchingData = delete_medecins($id);
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