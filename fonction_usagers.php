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
function get_usagers() {
    require('connectionBD_App.php');
    $res = $linkpdo->query('SELECT * FROM usagers');
    $resultat = $res->fetchAll();
    return $resultat;
}

function get_usagers_id($id) {
    require('connectionBD_App.php');
    $sql = "SELECT * FROM usagers WHERE id_usager = :id_usager";
    $stmt = $linkpdo->prepare($sql);
    $stmt->bindParam(':id_usager', $id);
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultat;
}

function create_usagers($data) {
    require('connectionBD_App.php');
    $sql = "INSERT INTO usagers (civilite, nom, prenom, sexe, adresse, code_postal, date_de_naiss, lieu_de_naiss, num_securite_sociale) 
    VALUES (:civilite, :nom, :prenom, :sexe, :adresse, :code_postal, :date_de_naiss, :lieu_de_naiss, :num_securite_sociale)";
    $stmt = $linkpdo->prepare($sql);
    $stmt->bindParam(':civilite', $data['civilite']);
    $stmt->bindParam(':nom', $data['nom']);
    $stmt->bindParam(':prenom', $data['prenom']);
    $stmt->bindParam(':sexe', $data['sexe']);
    $stmt->bindParam(':adresse', $data['adresse']);
    $stmt->bindParam(':code_postal', $data['code_postal']);
    $stmt->bindParam(':date_de_naiss', $data['date_de_naiss']);
    $stmt->bindParam(':lieu_de_naiss', $data['lieu_de_naiss']);
    $stmt->bindParam(':num_securite_sociale', $data['num_securite_sociale']);
    $stmt->execute();
}

function update_usagers($id, $data) {
    require('connectionBD_App.php');
    $sql = "UPDATE usagers where id_iusager = :id_usager SET civilite = :civilite, nom = :nom, prenom = :prenom, sexe = :sexe, adresse = :adresse, code_postal = :code_postal, date_de_naiss = :date_de_naiss, lieu_de_naiss = :lieu_de_naiss, num_securite_sociale = :num_securite_sociale WHERE id = :id";
    $stmt = $linkpdo->prepare($sql);
    $stmt->bindParam(':civilite', $data['civilite']);
    $stmt->bindParam(':nom', $data['nom']);
    $stmt->bindParam(':prenom', $data['prenom']);
    $stmt->bindParam(':sexe', $data['sexe']);
    $stmt->bindParam(':adresse', $data['adresse']);
    $stmt->bindParam(':code_postal', $data['code_postal']);
    $stmt->bindParam(':date_de_naiss', $data['date_de_naiss']);
    $stmt->bindParam(':lieu_de_naiss',$data['lieu_de_naiss']);
    $stmt->bindParam(':num_securite_sociale', $data['num_securite_sociale']);
    $stmt->bindParam(':id_usager', $id);
    $stmt->execute();
}

function delete_usagers($id) {
    require('connectionBD_App.php');
    $sql = "DELETE FROM usagers WHERE id = :id";
    $stmt = $linkpdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

?>