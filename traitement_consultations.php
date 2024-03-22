<?php
//require("verif_session.php");
require("fonction_consultations.php");

$id_usager = $_POST['id_usager'];
$id_medecin = $_POST['id_medecin'];
$date_consult = $_POST['date_consult'];
$date_heure_rdv = $_POST['heure_consult'];
$duree_consult = $_POST['duree_consult'];

$server = "localhost";
$login = "admin";
$mdp = "password";
$bd = "cabinet_medical";

try {
    $conn = new PDO("mysql:host=$server;dbname=$bd", $login, $mdp);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $insert_query = "INSERT INTO Consultation (id_usager, id_medecin, date_consult, heure_consult, duree_consult) VALUES (:id_usager, :id_medecin, :date_consult, :heure_consult, :duree_consult)"; 
    $stmt = $conn->prepare($insert_query);
    $stmt->bindParam(':id_usager', $id_usager);
    $stmt->bindParam(':id_medecin', $id_medecin);
    $stmt->bindParam(':date_consult', $date_consult);
    $stmt->bindParam(':heure_consult', $heure_consult);
    $stmt->bindParam(':duree_consult', $duree_consult);
    $stmt->execute();

    $verif = "SELECT id_usager from Avoir where id_usager = :id_usager";
    $statement = $conn->prepare($verif);
    $statement->bindParam(':id_usager', $id_usager);
    $statement->execute();

    if ($statement->rowCount() == 0) {
        $avoir = "INSERT INTO Avoir (id_usager, Referent, id_medecin) Values (:id_usager, 1, :id_medecin)";
        $statement = $conn->prepare($avoir);
        $statement->bindParam(':id_usager', $id_usager);
        $statement->bindParam(':id_medecin', $id_medecin);
    }


    header('Location: liste_consultations.php');
    exit();
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
