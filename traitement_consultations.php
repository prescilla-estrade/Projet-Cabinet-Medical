<?php
require("verif_session.php");

$id_usager = $_POST['id_usager'];
$id_medecin = $_POST['id_medecin'];
$date_heure_rdv = $_POST['date_heure_rdv'];
$duree = $_POST['duree'];

$server = "localhost";
$login = "admin";
$mdp = "password";
$bd = "cabinet_medical";

try {
    $conn = new PDO("mysql:host=$server;dbname=$bd", $login, $mdp);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $insert_query = "INSERT INTO Rdv (id_usager, id_medecin, date_heure_rdv, duree) VALUES (:id_usager, :id_medecin, :date_heure_rdv, :duree)"; 
    $stmt = $conn->prepare($insert_query);
    $stmt->bindParam(':id_usager', $id_usager);
    $stmt->bindParam(':id_medecin', $id_medecin);
    $stmt->bindParam(':date_heure_rdv', $date_heure_rdv);
    $stmt->bindParam(':duree', $duree);
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
