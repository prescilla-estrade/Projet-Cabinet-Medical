<?php

$repartition_usagers_json = file_get_contents("http://localhost/Cabinet_Medical_API/Projet-Cabinet-Medical/index_stat_usagers.php");
$repartition_usagers_data = json_decode($repartition_usagers_json, true);

// Afficher les statistiques de répartition des usagers
$repartition_usagers = $repartition_usagers_data['data'];

$moins25Hommes = $repartition_usagers['moins25Hommes'];
$moins25Femmes = $repartition_usagers['moins25Femmes'];
$entre25et50Hommes = $repartition_usagers['entre25et50Hommes'];
$entre25et50Femmes = $repartition_usagers['entre25et50Femmes'];
$plus50Hommes = $repartition_usagers['plus50Hommes'];
$plus50Femmes = $repartition_usagers['plus50Femmes'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Statistiques - répartition des usagers</title>
    <script src="retour.js"></script>
    <link rel="stylesheet" type="text/css" href="menu.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
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

<h1>Répartition des usagers selon leur sexe et leur âge</h1>

<div class="table-container">
<table>
  <tr>
    <th>Tranche d'âge</th>
    <th>Nb Hommes</th>
    <th>Nb Femmes</th>
  </tr>
  <tr>
    <td>Moins de 25 ans</td>
    <td><?php echo $moins25Hommes; ?></td>
    <td><?php echo $moins25Femmes; ?></td>
  </tr>
  <tr>
    <td>Entre 25 et 50 ans</td>
    <td><?php echo $entre25et50Hommes; ?></td>
    <td><?php echo $entre25et50Femmes; ?></td>
  </tr>
  <tr>
    <td>Plus de 50 ans</td>
    <td><?php echo $plus50Hommes; ?></td>
    <td><?php echo $plus50Femmes; ?></td>
  </tr>
</table>
</div>

<br>
<button id='retour' onclick='retour()'><i class='fas fa-arrow-left'></i> Retour</button>

</body>
</html>
