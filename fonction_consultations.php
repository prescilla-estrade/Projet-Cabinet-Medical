<?php

function deliver_response($status_code, $status_message, $data=null){
    /// Paramétrage de l'entête HTTP
    http_response_code($status_code); //Utilise un message standardisé en fonction du code HTTP
    header('Access-Control-Allow-Origin: *'); //Permet de spécifier les domaines qui peuvent accéder à la ressource
    //header("HTTP/1.1 $status_code $status_message"); //Permet de personnaliser le message associé au code HTTP
    header("Content-Type:application/json; charset=utf-8");//Indique a client le format de la réponse
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

/* 
function read_consultations($linkpdo){
    require('connectionBD_App.php');
    $sqlRead = "SELECT DISTINCT id_medecin, nom, prenom FROM medecin 
    WHERE id_medecin IN (SELECT DISTINCT id_medecin FROM rdv)";
    $stmt = $linkpdo->prepare($sqlRead);
    $stmt->bindParam('id', $id, PDO::FETCH_ALL);
    $stmt->execute();
}*/

function create_consultations($linkpdo, $data['phrase']){
    require('connectionBD_App.php');
    $sqlCreate = "INSERT INTO Rdv (id_usager, id_medecin, date_heure_rdv, duree) VALUES (:id_usager, :id_medecin, :date_heure_rdv, :duree)";
    $stmt = $linkpdo->prepare($sqlCreate);
    $stmt->bindParam(':id_usager', $data['id_usager']);
    $stmt->bindParam(':date_heure_rdv', $data['date_heure_rdv']);
    $stmt->bindParam(':duree', $data['duree']);
    $stmt->execute();
}

/*
function update_consultations($linkpdo, $id){
    require('connectionBD_App.php');
    $date_heure_rdv=$_GET['date_heure_rdv'];
    $duree = $_GET['duree'];
    $id_usager = $_GET['id_usager'];
    $id_medecin = $_GET[id_medecin];
    $sqlUpdate = "UPDATE Rdv SET date_heure_rdv = :date_heure_rdv, duree = :duree WHERE id_usager = :id_usager AND id_medecin = :id_medecin";
    $stmt = $linkpdo->prepare($sqlUpdate);
    $stmt->bindParam(':date_heure_rdv', $date_heure_rdv);
    $stmt->bindParam(':duree', $duree);
    $stmt->bindParam(':id_usager', $id_usager);
    $stmt->bindParam(':id_medecin', $id_medecin);
    $stmt->execute();

    echo "Consultation mise à jour avec succès !";
    header('Location: liste_consultations.php');
    $stmt->execute();
}

function update_consultations_partially($id, $data) {
    require('connectionBD_App.php');
}
*/

function delete_consultations($id){
    require('connectionBD_App.php');
    $sqlDelete = "DELETE FROM Rdv WHERE id_rdv = :id_rdv";
    $stmt = $linkpdo->prepare($sqlDelete);
    $stmt->bindParam(':id_rdv', $id_rdv);
    $stmt->execute();
    return $stmt->rowCount();
}

?>