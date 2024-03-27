<?php
require("verif_session.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Consultations</title>
        <script src="retour.js"></script>
        <link rel="stylesheet" type="text/css" href="menu.css">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <nav>
            <ul class="menu-list">
                <li class="menu-item"><a class="menu-link" href="usager.php">Usagers</a></li>
                <li class="menu-item"><a class="menu-link" href="medecin.php">Medecins</a></li>
                <li class="menu-item"><a class="menu-link" href="consultation.php">Consultations</a></li>
                <li class="menu-item"><a class="menu-link" href="statistique.php">Statistiques</a></li>
                <div class="logout"><a href="logout.php"><button type="button" class="btn"><img src="logout.png">Déconnexion</img></button><a></div>
            </ul>
        </nav>
        <h1>Consultations</h1>
        <button><a class="bouton-link" href="saisie_consultations.php">Saisie des consultations <i class="fas fa-plus"></i></a></button>
        <button><a class="bouton-link" href="liste_consultations.php">Liste des consultations <i class='far fa-calendar-alt'></i></a></button>
        <button id='retour' onclick='retour()'><i class='fas fa-arrow-left'></i> Retour</button>
    </body>
</html>