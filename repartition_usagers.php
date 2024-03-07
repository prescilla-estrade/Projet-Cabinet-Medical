<?php

require("verif_session.php");
require("bd_connection.php");

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