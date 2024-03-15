<?php

//require("verif_session.php");
require("fonction_consultations.php");

//récupération des médecins depuis la base de données
$res = get_consultations();
?>

<title>Liste des consultations</title>
<link rel='stylesheet' type='text/css' href='menu.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="retour.js"></script>

<nav>
    <ul class='menu-list'>
        <li class='menu-item'><a class='menu-link' href='usager.php'>Usagers</a></li>
        <li class='menu-item'><a class='menu-link' href='medecin.php'>Medecins</a></li>
        <li class='menu-item'><a class='menu-link' href='consultation.php'>Consultations</a></li>
        <li class='menu-item'><a class='menu-link' href='statistique.php'>Statistiques</a></li>
    </ul>
</nav>

<h1> Liste des consultations </h1>

<form action="" method="GET">
    <label for="selectMedecin">Filtrer par médecin :</label>
    <select name="selectMedecin" id="selectMedecin">
        <option value="all">Tous les médecins</option>
        <?php foreach ($medecins as $medecin) { ?>
            <option value="<?php echo $medecin['id_medecin']; ?>"><?php echo $medecin['nom'] . ' ' . $medecin['prenom']; ?></option>
        <?php } ?>
    </select>
    <button type="submit">Filtrer</button>
</form>

<?php
$sqlQuery = 'SELECT consultation.*, usagers.nom AS usager_nom, usagers.prenom AS usager_prenom, medecin.nom AS medecin_nom, medecin.prenom AS medecin_prenom
             FROM consultation, usagers, medecin 
             WHERE consultation.id_usager = usagers.id_usager 
             AND consultation.id_medecin = medecin.id_medecin';

$medecinFiltre = $_GET['selectMedecin'] ?? 'all';

if ($medecinFiltre !== 'all') {
    $sqlQuery .= ' AND consultation.id_medecin = :id_medecin ORDER BY date_consult DESC'; //ORDER BY date_heure_rdv
    $resultat = $linkpdo->prepare($sqlQuery);
    $resultat->bindParam(':id_medecin', $medecinFiltre, PDO::PARAM_INT);
} else {
    $sqlQuery .= ' ORDER BY date_consult DESC';  //ORDER BY date_heure_rdv
    $resultat = $linkpdo->query($sqlQuery);
}

$resultat->execute();
$res = $resultat->fetchAll();
?>

<style>
    table, td, th {
        width: 80%;
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<div class='table-container'>
<table>
    <tr>
        <th>Usager</th>
        <th>Médecin</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Durée (en heure)</th>
        <th>Modifier</th>
        <th>Supprimer</th>
    </tr>

    <?php foreach ($res as $rdv) { ?>
        <tr>
            <td><?php echo $rdv['usager_nom'] . ' ' . $rdv['usager_prenom']; ?></td>
            <td><?php echo $rdv['medecin_nom'] . ' ' . $rdv['medecin_prenom']; ?></td>
            <td><?php echo $rdv['date_consult']; ?></td>
            <td><?php echo $rdv['heure_consult']; ?></td>
            <td><?php echo $rdv['duree_consult']; ?></td>
            <td>
                <form action='modifier_consultations.php' method='post'>
                    <input type='hidden' name='id_usager' value='<?php echo $rdv['id_usager']; ?>'>
                    <input type='hidden' name='id_medecin' value='<?php echo $rdv['id_medecin']; ?>'>
                    <button type='submit' class='icon'><i class='fas fa-edit'></i> Modifier</button>
                </form>
            </td>
            <td>
            <button onclick='confirmDelete(<?php echo $rdv['id_rdv']; ?>)' class='icon'><i id='supprimer' class='fas fa-trash-alt'></i> Supprimer</button>
            </td>

        </tr>
        <script>
            function confirmDelete(id_rdv) {
                var confirmation = confirm('Voulez-vous vraiment supprimer cette consultation ?');
                if (confirmation) {
                    window.location.href = 'supprimer_consultations.php?id_rdv=' + id_rdv;
                }
            }
        </script>

    <?php } ?>
</table>
</div>

<br>
<button id='retour' onclick='retour()'><i class='fas fa-arrow-left'></i> Retour</button>