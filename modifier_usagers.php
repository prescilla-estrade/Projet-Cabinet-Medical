<?php

require("verif_session.php");

require("bd_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_usager'])) {
        $id_usager = $_POST['id_usager'];
        
        $sqlSelect = 'SELECT * FROM Usagers WHERE id_usager = :id_usager';
        $stmtSelect = $linkpdo->prepare($sqlSelect);
        $stmtSelect->bindParam(':id_usager', $id_usager);
        $stmtSelect->execute();
        $usager = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if ($usager) {
            echo "
            <!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
                <link rel='stylesheet' type='text/css' href='form.css'>
                <title>Modifier Usager</title>
            </head>
            <body>
            <div class='container'>
            <fieldset>
                <legend> <h1>Modifier usager</h1> </legend>

                    <form action='' method='post'>
                        
                        <input type='hidden' name='id_usager' value='{$usager['id_usager']}'>

                        <br><label for='nom'>Nom :</label>
                        <input type='text' name='nom' value='{$usager['nom']}'><br>

                        <br><label for='prenom'>Prénom :</label>
                        <input type='text' name='prenom' value='{$usager['prenom']}'><br>

                        <br><label for='civilite'>Civilité :</label>
                        <select name='civilite'>
                            <option value=''>Choisissez une option</option>
                            <option value='M' " . ($usager['civilite'] == 'M' ? 'selected' : '') . ">M</option>
                            <option value='Mme' " . ($usager['civilite'] == 'Mme' ? 'selected' : '') . ">Mme</option>
                        </select><br>
                        
                        <br><label for='adresse'>Adresse :</label>
                        <input type='text' name='adresse' value='{$usager['adresse']}'><br>

                        <br><label for='date_de_naiss'>Date de Naissance :</label>
                        <input type='date' name='date_de_naiss' value='{$usager['date_de_naiss']}'><br>

                        <br><label for='lieu_de_naiss'>Lieu de Naissance :</label>
                        <input type='text' name='lieu_de_naiss' value='{$usager['lieu_de_naiss']}'><br>

                        <br><label for='num_securite_sociale'>Numéro de Sécurité Sociale :</label>
                        <input type='text' name='num_securite_sociale' value='{$usager['num_securite_sociale']}' maxlength='11'><br>

                        <br><input type='submit' name='modifier' value='Modifier'>
                    </form>
                </fieldset>
                <br>
                <script src='retour.js'></script>
                <button id='retour' onclick='retour()'><i class='fas fa-arrow-left'></i> Annuler</button>
                </div>
            </body>
            </html>";
        } else {
            echo "Aucun usager trouvé.";
        }

        if (isset($_POST['modifier'])) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $civilite = $_POST['civilite'];
            $adresse = $_POST['adresse'];
            $date_de_naiss = $_POST['date_de_naiss'];
            $lieu_de_naiss = $_POST['lieu_de_naiss'];
            $num_securite_sociale = $_POST['num_securite_sociale'];

            $sqlUpdate = 'UPDATE usagers SET nom = :nom, prenom = :prenom, civilite = :civilite, adresse = :adresse, date_de_naiss = :date_de_naiss, lieu_de_naiss = :lieu_de_naiss, num_securite_sociale = :num_securite_sociale WHERE id_usager = :id_usager';
            $stmt = $linkpdo->prepare($sqlUpdate);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':civilite', $civilite);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->bindParam(':date_de_naiss', $date_de_naiss);
            $stmt->bindParam(':lieu_de_naiss', $lieu_de_naiss);
            $stmt->bindParam(':num_securite_sociale', $num_securite_sociale);
            $stmt->bindParam(':id_usager', $id_usager);
            $stmt->execute();

            header("Location: liste_usagers.php");
            exit();

        }
    } else {
        echo "Aucun usager sélectionné.";
    }

     
}

?>