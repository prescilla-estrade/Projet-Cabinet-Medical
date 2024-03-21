<?php
#require("verif_session.php");
$duree_json = file_get_contents("http://localhost/Cabinet_Medical_API/Projet-Cabinet-Medical/index_stat_consultations.php");
$duree_data = json_decode($duree_json, true);

// Vérifier si les données sont définies avant d'y accéder
if (isset($duree_data['data'])) {
  $durees = $duree_data['data'];
} else {
  // Si les données ne sont pas définies, initialiser le tableau vide
  $durees = [];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Statistiques - durée totale des consultations par médecin</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
    </style>
    <script src="retour.js"></script>
    <link rel="stylesheet" type="text/css" href="menu.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" type="text/css" href="styles.css">
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

<h1>Durée totale des consultations par médecin</h1>

<div class="table-container">
<table>
  <tr>
    <th>Médecin</th>
    <th>Durée totale (en heures)</th>
  </tr>
  <?php foreach ($durees as $duree) { ?>
    <tr>
        <td><?php echo $duree['medecin']; ?></td>
        <td><?php echo $duree['duree_totale']; ?></td>
    </tr>
  <?php } ?>
</table>
</div>

<br>
<button id='retour' onclick='retour()'><i class='fas fa-arrow-left'></i> Retour</button>
</body>
</html>
