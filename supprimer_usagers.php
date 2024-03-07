<?php
require("bd_connection.php");
if (isset($_GET['id_usager'])) {
    try {
        $id_usager = $_GET['id_usager'];

        $sqlDelete = 'DELETE FROM Usagers WHERE id_usager = :id';
        $statement = $linkpdo->prepare($sqlDelete);
        $statement->bindParam(':id', $id_usager, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            echo 'Suppression réussie.';
        } else {
            echo 'Erreur lors de la suppression : ' . $statement->errorInfo()[2];
        }

        header('Location: liste_usagers.php');
        exit();
    } catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
} else {
    echo 'Aucun ID d\'usager fourni.';
}

?>