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

function get_repartition_usagers() {
    require('connectionBD_App.php');
    $query = "SELECT civilite, date_de_naiss FROM Usagers";
    $usagersResult = $linkpdo->query($query);
    $usagers = $usagersResult->fetchAll(PDO::FETCH_ASSOC);

    $moins25Hommes = 0;
    $moins25Femmes = 0;
    $entre25et50Hommes = 0;
    $entre25et50Femmes = 0;
    $plus50Hommes = 0;
    $plus50Femmes = 0;

    foreach ($usagers as $usager) {
        $dateNaissance = new DateTime($usager['date_de_naiss']);
        $aujourdHui = new DateTime();
        $age = $dateNaissance->diff($aujourdHui)->y;

        if ($age < 25) {
            if ($usager['civilite'] === 'M') {
                $moins25Hommes++;
            } else {
                $moins25Femmes++;
            }
        } elseif ($age >= 25 && $age <= 50) {
            if ($usager['civilite'] === 'M') {
                $entre25et50Hommes++;
            } else {
                $entre25et50Femmes++;
            }
        } else {
            if ($usager['civilite'] === 'M') {
                $plus50Hommes++;
            } else {
                $plus50Femmes++;
            }
        }
    }
}

function get_durée_consultation() {
    require('connectionBD_App.php');
    $query = "SELECT CONCAT(Medecin.nom, ' ', Medecin.prenom) AS medecin, SEC_TO_TIME(SUM(TIME_TO_SEC(Consultation.duree_consult))) AS duree_totale 
    FROM Consultation, Medecin
    WHERE Consultation.id_medecin = Medecin.id_medecin
    GROUP BY Consultation.id_medecin";
    $consultationsResult = $linkpdo->query($query);
    $durees = $consultationsResult->fetchAll(PDO::FETCH_ASSOC);
}

?>