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

function readMedecin($linkpdo){ /** liste_medecins */
    require('connectionBD_App.php');
    /* header("Content-Type:application/json; charset=utf-8"); */
    $sqlRead = "SELECT * FROM medecin";
    $stmt = $linkpdo->prepare($sqlRead);
    $stmt->bindParam('id', $id, PDO::FETCH_ALL);
    $stmt->execute();
}

function create_medecins($linkpdo, $data['phrase']){
    require('connectionBD_App.php');
    header("Content-Type:application/json; charset=utf-8");
    $response['data'] = $data;
    $civilite = $_POST['civilite'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $sqlCreate = "INSERT INTO medecin(civilite, nom, prenom) VALUES(:civilite, :nom, :prenom)";
    $stmt = $linkpdo->prepare($sqlCreate);
    $stmt->execute(array('civilite' => $civilite, 'nom' => $nom, 'prenom' => $prenom));
    echo 'Le médecin a bien été ajouté.';
    header('Location: liste_medecins.php');
    exit();
}

function update_medecins($linkpdo, $data['phrase']){
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

function delete_medecins($linkpdo, $data['phrase']){
    require('connectionBD_App.php');
    $id_medecin = $_GET['id_medecin'];
    $linkpdo->beginTransaction();
    $sqlDelete = "DELETE FROM Medecin WHERE id_medecin = :id_medecin";
    $stmtMedecin = $linkpdo->prepare($sqlDeleteMedecin);
    $stmtMedecin->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);
    $stmtMedecin->execute();
    echo 'Suppression réussie.';
    header("Location: liste_medecins.php");
    exit();
}

?>