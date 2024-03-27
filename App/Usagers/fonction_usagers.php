<?php

function deliver_response($status_code, $status_message, $data=null){
    http_response_code($status_code);
    header('Access-Control-Allow-Origin: *');
    header("Content-Type:application/json; charset=utf-8");
    $response['status_code'] = $status_code;
    $response['status_message'] = $status_message;
    $response['data'] = $data;
    
    $json_response = json_encode($response);
    echo $json_response; // Affiche la réponse
    return $json_response; // Renvoie la réponse
}

function get_usagers() {
    require('../connectionBD_App.php');
    $res = $linkpdo->query('SELECT * FROM usagers');
    $resultat = $res->fetchAll(PDO::FETCH_ASSOC); // Utilisation de PDO::FETCH_ASSOC pour récupérer un tableau associatif
    return $resultat;
}

function get_usagers_id($id) {
    require('../connectionBD_App.php');
    $sql = "SELECT * FROM usagers WHERE id_usager = :id_usager";
    $stmt = $linkpdo->prepare($sql);
    $stmt->bindParam(':id_usager', $id);
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC); // Utilisation de PDO::FETCH_ASSOC pour récupérer un tableau associatif
    return $resultat;
}

function create_usagers($data) {
    require('../connectionBD_App.php');
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
    return $stmt->execute();
}

function update_usagers($id, $data) {
    require('../connectionBD_App.php');
    $fields = array_keys($data);
    $placeholders = array_map(function($field) {
        return "$field = :$field";
    }, $fields);
    $sql = "UPDATE usagers SET " . implode(", ", $placeholders) . " where id_usager = :id_usager";
    $stmt = $linkpdo->prepare($sql);
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    $stmt->bindValue(":id_usager", $id);
    $stmt->execute();
    return $stmt->rowCount();
}

function update_usagers_partially($id, $data) {
    require('../connectionBD_App.php');
    $fields = array_keys($data);
    $placeholders = array_map(function($field) {
        return "$field = :$field";
    }, $fields);
    $sql = "UPDATE usagers SET " . implode(", ", $placeholders) . " where id_usager = :id_usager";
    $stmt = $linkpdo->prepare($sql);
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    $stmt->bindValue(":id_usager", $id);
    $stmt->execute();
    return $stmt->rowCount();
}

function delete_usagers($id) {
    require('../connectionBD_App.php');
    $sql = "DELETE FROM usagers WHERE id_usager = :id_usager";
    $stmt = $linkpdo->prepare($sql);
    $stmt->bindParam(':id_usager', $id);
    $stmt->execute();
    return $stmt->rowCount();
}

?>