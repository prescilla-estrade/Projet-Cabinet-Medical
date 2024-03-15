<?php

//require("verif_session.php");
require("fonction_medecins.php");

//récupération des médecins depuis la base de données
$res = get_medecins();

echo "
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset='utf-8' />
        <title>Liste des médecins</title>
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
        <h1> Liste des médecins </h1>
    <div class='table-container'>
    <table>
        <tr>
            <th>Civilité</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
    </body>";

foreach ($res as $medecin) {
    echo "
    <tr>
        <td>{$medecin['civilite']}</td>
        <td>{$medecin['nom']}</td>
        <td>{$medecin['prenom']}</td>
        <td>
            <form action='modifier_medecins.php' method='post'>
                <input type='hidden' name='id_medecin' value='{$medecin['id_medecin']}'>
                <button type='submit' class='icon'><i class='fas fa-edit'></i> Modifier</button>
            </form>
        </td>
        <td>
            <input type='hidden' name='id_medecin' value='{$medecin['id_medecin']}'>
            <button onclick='confirmDelete({$medecin['id_medecin']})' class='icon'><i id='supprimer' class='fas fa-trash-alt'></i> Supprimer</button>
        </td>
    </tr>
    <script>
        function confirmDelete(id_medecin) {
            var confirmation = confirm('Voulez-vous vraiment supprimer cet utilisateur ?');
            if (confirmation) {
                window.location.href = 'supprimer_medecins.php?id_medecin=' + id_medecin;
            }
        }
    </script>";
}

echo "</table></div>";

echo "<br>";
echo "<script src='retour.js'></script>";
echo "<button id='retour' onclick='retour()'><i class='fas fa-arrow-left'></i> Retour</button>";

?>
