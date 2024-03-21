<?php
//require("verif_session.php");

$baseUrl = "http://localhost/Cabinet_Medical_API/Projet-Cabinet-Medical/index_usagers.php";
$res = file_get_contents($baseUrl);

$res = json_decode($res, true);

echo "
<!DOCTYPE HTML>
<html>
<head>
    <meta charset='utf-8' />
    <title>Liste des usagers</title>
    <script src='retour.js'></script>
    <link rel='stylesheet' type='text/css' href='menu.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel='stylesheet' type='text/css' href='styles.css'>
    <style>
        table, td, th {
            width: 80%;
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <nav>
        <ul class='menu-list'>
            <li class='menu-item'><a class='menu-link' href='usager.php'>Usagers</a></li>
            <li class='menu-item'><a class='menu-link' href='medecin.php'>Medecins</a></li>
            <li class='menu-item'><a class='menu-link' href='consultation.php'>Consultations</a></li>
            <li class='menu-item'><a class='menu-link' href='statistique.php'>Statistiques</a></li>
        </ul>
    </nav>
    <h1>Liste des usagers</h1>
    <div class='table-container'>
        <table>
            <tr>
                <th>Civilité</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Sexe</th>
                <th>Date de naissance</th>
                <th>Lieu de naissance</th>
                <th>Numéro de sécurité sociale</th>
                <th>Adresse</th>
                <th>Code Postal</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>";

// Parcours des résultats et affichage dans le tableau
foreach ($res['data'] as $usager) {
    echo "
    <tr>
        <td>{$usager['civilite']}</td>
        <td>{$usager['nom']}</td>
        <td>{$usager['prenom']}</td>
        <td>{$usager['sexe']}</td>
        <td>{$usager['date_de_naiss']}</td>
        <td>{$usager['lieu_de_naiss']}</td>
        <td>{$usager['num_securite_sociale']}</td>
        <td>{$usager['adresse']}</td>
        <td>{$usager['code_postal']}</td>
        <td>
            <form action='modifier_usagers.php' method='post'>
                <input type='hidden' name='id_usager' value='{$usager['id_usager']}'>
                <button id='btn_modifier' type='submit' class='icon'><i class='fas fa-edit'></i> Modifier</button>
            </form>
        </td>
        <td>
            <button id='btn_supprimer' onclick='confirmDelete({$usager['id_usager']})' class='icon'><i id='supprimer' class='fas fa-trash-alt'></i> Supprimer</button>
        </td>
    </tr>";
}

echo "</table></div>";

echo "<br>";
echo "<button id='retour' onclick='retour()'><i class='fas fa-arrow-left'></i> Retour</button>";
echo "</body></html>";
?>
