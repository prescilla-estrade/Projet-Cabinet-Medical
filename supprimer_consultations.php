<?php
require("bd_connection.php");

if (isset($_GET['id_rdv'])) {
    try {
        $id_rdv = $_GET['id_rdv']; 

        $sqlDelete = "DELETE FROM Rdv WHERE id_rdv = :id_rdv";
        $stmt = $linkpdo->prepare($sqlDelete);
        $stmt->bindParam(':id_rdv', $id_rdv, PDO::PARAM_INT);
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
