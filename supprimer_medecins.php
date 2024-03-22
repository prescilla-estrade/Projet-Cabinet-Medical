<?php
//require("verif_session.php");
require("fonction_medecins.php");

if (isset($_GET['id_medecin'])) {
    try {
        $id_medecin = $_GET['id_medecin'];
        
        // Début de la transaction
        $linkpdo->beginTransaction();

        // Suppression dans la table Medecin
        $sqlDeleteMedecin = "DELETE FROM Medecin WHERE id_medecin = :id_medecin";
        $stmtMedecin = $linkpdo->prepare($sqlDeleteMedecin);
        $stmtMedecin->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);
        $stmtMedecin->execute();

        // Vérifiez si la suppression dans Medecin a réussi
        if ($stmtMedecin->rowCount() > 0) {
            // Suppression dans la table Avoir
            $sqlDeleteAvoir = "DELETE FROM Avoir WHERE id_medecin = :id_medecin";
            $stmtAvoir = $linkpdo->prepare($sqlDeleteAvoir);
            $stmtAvoir->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);
            $stmtAvoir->execute();

            // Commit si tout s'est bien passé
            $linkpdo->commit();

            echo 'Suppression réussie.';
        } else {
            // Rollback si la suppression dans Medecin a échoué
            $linkpdo->rollBack();

            echo 'Erreur lors de la suppression : ' . $stmtMedecin->errorInfo()[2];
        }

        header("Location: liste_medecins.php");
        exit();
    } catch (Exception $e) {
        // Rollback en cas d'erreur inattendue
        $linkpdo->rollBack();

        die('Erreur : ' . $e->getMessage());
    }
} else {
    echo 'Aucun ID de médecin fourni.';
}
?>
