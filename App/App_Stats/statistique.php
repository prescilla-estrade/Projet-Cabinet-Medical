<?php
require("verif_session.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Statistiques</title>
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
        <h1>Statistiques</h1>
        <button><a class="bouton-link" href="repartition_usagers.php">Répartition des usagers <i class="fas fa-chart-pie"></i></a></button>
        <button><a class="bouton-link" href="duree_consultations.php">Durée des consultations <i class="far fa-clock"></i></a></button>
        <button id='retour' onclick='retour()'><i class='fas fa-arrow-left'></i> Retour</button>
    </body>
</html>