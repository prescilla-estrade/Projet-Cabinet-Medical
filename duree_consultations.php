<?php
require("verif_session.php");

require("bd_connection.php");

$query = "SELECT CONCAT(Medecin.nom, ' ', Medecin.prenom) AS medecin, SEC_TO_TIME(SUM(TIME_TO_SEC(Rdv.duree))) AS duree_totale 
          FROM Consultation, Medecin
          WHERE Consultation.id_medecin = Medecin.id_medecin
          GROUP BY Consultation.id_medecin";
$rdvsResult = $linkpdo->query($query);
$durees = $rdvsResult->fetchAll(PDO::FETCH_ASSOC);
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
