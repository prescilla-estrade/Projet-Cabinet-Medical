<?php
require("bd_connection.php");

if (isset($_GET['id_consult'])) {
    try {
        $id_rdv = $_GET['id_consult']; 

        $sqlDelete = "DELETE FROM Consultation WHERE id_consult = :id_consult";
        $stmt = $linkpdo->prepare($sqlDelete);
        $stmt->bindParam(':id_consult', $id_consult, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo 'Suppression réussie.';
        } else {
            echo 'Erreur lors de la suppression : ' . $stmt->errorInfo()[2];
        }

        header("Location: liste_consultations.php");
        exit();
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
} else {
    echo 'Aucun ID de consultation fourni.';
}
?>
