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

function get_medecins(){
    require('connectionBD_App.php');
    $res = $linkpdo->query('SELECT * FROM medecin');
    $resultat = $res->fetchAll();
    return $resultat;
}

function get_medecins_id($id) {
    require('connectionBD_App.php');
    $sql = "SELECT * FROM medecin WHERE id_medecin = :id_medecin";
    $stmt = $linkpdo->prepare($sql);
    $stmt->bindParam(':id_medecin', $id);
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultat;
}

function create_medecins($data){
    require('connectionBD_App.php');
    $sqlCreate = "INSERT INTO medecin(civilite, nom, prenom) VALUES(:civilite, :nom, :prenom)";
    $stmt = $linkpdo->prepare($sqlCreate);
    $stmt->bindParam(':civilite', $data['civilite']);
    $stmt->bindParam(':nom', $data['nom']);
    $stmt->bindParam(':prenom', $data['prenom']);
    return $stmt->execute();
}

/* 
function update_medecins($id, $data){
    require('connectionBD_App.php');
    
    $civilite = $_POST['civilite'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $id_medecin = $_GET['id'];
    $sqlUpdate = "UPDATE medecin SET civilite = :civilite, nom = :nom, prenom = :prenom WHERE id_medecin = :id";
    $stmt = $linkpdo->prepare($sqlUpdate);
    $stmt->bindParam(':civilite', $civilite);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':id', $id_medecin);
    $stmt->execute();
    echo "Médecin mis à jour avec succès !";
    header("Location: liste_medecins.php");
    exit();
}

function update_medecins_partially($id, $data) {
    require('connectionBD_App.php');
} */

function delete_medecins($id){
    require('connectionBD_App.php');
    $sqlDelete = "DELETE FROM Medecin WHERE id_medecin = :id_medecin";
    $stmtMedecin = $linkpdo->prepare($sqlDelete);
    $stmtMedecin->bindParam(':id_medecin', $id_medecin);
    $stmtMedecin->execute();
    return $stmt->rowCount();
}

?>