<?php

function deliver_response($status_code, $status_message, $data=null){
    /// Paramétrage de l'entête HTTP
    http_response_code($status_code); //Utilise un message standardisé en fonction du code HTTP
    header('Access-Control-Allow-Origin: *'); //Permet de spécifier les domaines qui peuvent accéder à la ressource
    //header("HTTP/1.1 $status_code $status_message"); //Permet de personnaliser le message associé au code HTTP
    header("Content-Type:application/json; charset=utf-8");//Indique au client le format de la réponse
    $response['status_code'] = $status_code;
    $response['status_message'] = $status_message;
    $response['data'] = $data;
    /// Mapping de la réponse au format JSON
    $json_response = json_encode($response);
    if($json_response===false)
     die('json encode ERROR : '.json_last_error_msg());
    /// Affichage de la réponse (Retourné au client)
    echo $json_response;
}

function get_consultations($linkpdo) {
    $res = $linkpdo->query('SELECT * FROM Consultation');
    $resultat = $res->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function get_consultations_id($id, $linkpdo) {
    $sql = "SELECT * FROM Consultation WHERE id_consult = :id_consult";
    $stmt = $linkpdo->prepare($sql);
    $stmt->bindParam(':id_consult', $id);
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultat;
}

function create_consultations($data){
    require('../connectionBD_App.php');
    $sqlCreate = "INSERT INTO Consultation (id_usager, id_medecin, date_consult, heure_consult, duree_consult) VALUES (:id_usager, :id_medecin, :date_consult, :heure_consult, :duree_consult)";
    $stmt = $linkpdo->prepare($sqlCreate);
    $stmt->bindParam(':id_usager', $data['id_usager']);
    $stmt->bindParam(':id_medecin', $data['id_medecin']);
    $stmt->bindParam(':date_consult', $data['date_consult']);
    $stmt->bindParam(':heure_consult', $data['heure_consult']);
    $stmt->bindParam(':duree_consult', $data['duree_consult']);
    return $stmt->execute();
}

function update_consultations($id, $data) {
    require('../connectionBD_App.php');
    $fields = array_keys($data);
    $placeholders = array_map(function($field) {
        return "$field = :$field";
    }, $fields);
    $sql = "UPDATE Consultation SET " . implode(", ", $placeholders) . " where id_consult = :id_consult";
    $stmt = $linkpdo->prepare($sql);
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    $stmt->bindValue(":id_consult", $id);
    $stmt->execute();
    return $stmt->rowCount();
}

function update_consultations_partially($id, $data) {
    require('../connectionBD_App.php');
    $fields = array_keys($data);
    $placeholders = array_map(function($field) {
        return "$field = :$field";
    }, $fields);
    $sql = "UPDATE Consultation SET " . implode(", ", $placeholders) . " where id_consult = :id_consult";
    $stmt = $linkpdo->prepare($sql);
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    $stmt->bindValue(":id_consult", $id);
    $stmt->execute();
    return $stmt->rowCount();
}

function delete_consultations($id){
    require('../connectionBD_App.php');
    $sqlDelete = "DELETE FROM Consultation WHERE id_consult = :id_consult";
    $stmt = $linkpdo->prepare($sqlDelete);
    $stmt->bindParam(':id_consult', $id_consult);
    $stmt->execute();
    return $stmt->rowCount();
}

?>