<?php

//require("verif_session.php");
require("fonction_medecins.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_medecin'])) {
        $id_medecin = $_POST['id_medecin'];

        $sqlQuery = 'SELECT * FROM medecin WHERE id_medecin = :id';
        $resultat = $linkpdo->prepare($sqlQuery);
        $resultat->bindParam(':id', $id_medecin);
        $resultat->execute();
        $medecin = $resultat->fetch(PDO::FETCH_ASSOC);

        if ($medecin) {
            echo "
            <!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
                <link rel='stylesheet' type='text/css' href='form.css'>
                <title>Modifier Médecin</title>
            </head>
            <body>
                <div class='container'>
                <fieldset>
                    <legend><h1>Modifier Médecin</h1></legend>
                    <form action='' method='post'>
                        <input type='hidden' name='id_medecin' value='{$medecin['id_medecin']}'>
                        
                        <label for='civilite'>Civilité :</label>
                        <select name='civilite'>
                            <option value=''>Choisissez une option</option>
                            <option value='M' " . ($medecin['civilite'] == 'M' ? 'selected' : '') . ">M</option>
                            <option value='Mme' " . ($medecin['civilite'] == 'Mme' ? 'selected' : '') . ">Mme</option>
                            <!-- Ajoutez d'autres options si nécessaire -->
                        </select><br><br>
                        
                        <label for='nom'>Nom :</label>
                        <input type='text' name='nom' value='{$medecin['nom']}' required><br><br>
                        
                        <label for='prenom'>Prénom :</label>
                        <input type='text' name='prenom' value='{$medecin['prenom']}' required><br><br>
                        
                        <input type='submit' name='modifier' value='Modifier'>
                    </form>
                </fieldset>
                <br>
                <script src='retour.js'></script>
                <button id='retour' onclick='retour()'><i class='fas fa-arrow-left'></i> Annuler</button>
                </div>
            </body>
            </html>";
        } else {
            echo "Aucun médecin trouvé.";
        }

        if (isset($_POST['modifier'])) {
            $civilite = $_POST['civilite'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];

            $sqlUpdate = 'UPDATE medecin SET civilite = :civilite, nom = :nom, prenom = :prenom WHERE id_medecin = :id';
            $stmt = $linkpdo->prepare($sqlUpdate);
            $stmt->bindParam(':civilite', $civilite);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':id', $id_medecin);
            $stmt->execute();

            echo "Médecin mis à jour avec succès !";
            header("Location: liste_medecins.php");
            exit();
        }
    } else {
        echo "Aucun médecin sélectionné.";
    }
}

?>
