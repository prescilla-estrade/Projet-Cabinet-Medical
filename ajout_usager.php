<?php
require("verif_session.php");

require("bd_connection.php");

$civilite = $_POST['civilite'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$sexe= $_POST['sexe'];
$adresse = $_POST['adresse'];
$code_postal = $_POST['code_postal'];
$date_de_naiss = $_POST['date_de_naiss'];
$lieu_de_naiss = $_POST['lieu_de_naiss'];
$num_securite_sociale = $_POST['num_securite_sociale'];

// Utilisation de requête préparée pour éviter les erreurs de syntaxe et les problèmes de sécurité
$res = $linkpdo->prepare('SELECT nom, prenom FROM usagers WHERE nom = :nom AND prenom = :prenom');
$res->execute(array('nom' => $nom, 'prenom' => $prenom));
$resultat = $res->fetchAll();

if (count($resultat) > 0) {
    $message = $nom . ' fait déjà partie de la base de données, il n\'a donc pas été ajouté';
    echo $message;
} else {
    // L'utilisateur n'existe pas, effectuer l'insertion
    $req = $linkpdo->prepare('INSERT INTO usagers(civilite, nom, prenom, sexe, adresse, code_postal, date_de_naiss,
    lieu_de_naiss, num_securite_sociale) VALUES(:civilite, :nom, :prenom, :sexe, :adresse, :code_postal, :date_de_naiss, :lieu_de_naiss, :num_securite_sociale)');

    $req->execute(array(
        'civilite' => $civilite,
        'nom' => $nom,
        'prenom' => $prenom,
        'sexe' => $sexe,
        'adresse' => $adresse,
        'code_postal' => $code_postal,
        'date_de_naiss' => $date_de_naiss,
        'lieu_de_naiss' => $lieu_de_naiss,
        'num_securite_sociale' => $num_securite_sociale
    ));

    header('Location: liste_usagers.php');
    exit();
}

$res->closeCursor();
?>
