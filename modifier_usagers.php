<?php

//require("verif_session.php");
require("fonction_usagers.php");

// Vérification de la soumission du formulaire
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

                        <br><label for='prenom'>Sexe :</label>
                        <input type='text' name='sexe' value='{$usager['sexe']}'><br>

                        <br><label for='civilite'>Civilité :</label>
                        <select name='civilite'>
                            <option value=''>Choisissez une option</option>
                            <option value='M' " . ($usager['civilite'] == 'M' ? 'selected' : '') . ">M</option>
                            <option value='Mme' " . ($usager['civilite'] == 'Mme' ? 'selected' : '') . ">Mme</option>
                        </select><br>
                        
                        <br><label for='adresse'>Adresse :</label>
                        <input type='text' name='adresse' value='{$usager['adresse']}'><br>

                        <br><label for='prenom'>Code postal :</label>
                        <input type='text' name='code_postal' value='{$usager['code_postal']}'><br>

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

        // Vérification des champs requis
        $errors = array();
        if (empty($_POST["nom"])) {
            $errors[] = "Le nom est requis.";
        }
        if (empty($_POST["civilite"])) {
            $errors[] = "La civilité est requise.";
        }
        if (empty($_POST["sexe"])) {
            $errors[] = "Le sexe est requis.";
        }
        if (empty($_POST["civilite"])) {
            $errors[] = "La civilite est requise.";
        }
        if (empty($_POST["adresse"])) {
            $errors[] = "L'adresse est requise.";
        }
        if (empty($_POST["code_postal"])) {
            $errors[] = "Le code postal est requis.";
        }
        if (empty($_POST["date_de_naiss"])) {
            $errors[] = "La date de naissance est requise.";
        }
        if (empty($_POST["lieu_de_naiss"])) {
            $errors[] = "Le lieu de naissance est requis.";
        }
        if (empty($_POST["num_securite_sociale"])) {
            $errors[] = "Le numéro de securité sociale est requis.";
        }
        
        // Si aucune erreur n'est détectée, procéder à la modification dans la base de données
        if (empty($errors)) {
            // Préparation des données pour l'insertion
            $data = array(
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'sexe' => $_POST['sexe'],
                'civilite' => $_POST['civilite'],
                'adresse' => $_POST['adresse'],
                'code_postal' => $_POST['code_postal'],
                'date_de_naiss' => $_POST['date_de_naiss'],
                'lieu_de_naiss' => $_POST['lieu_de_naiss'],
                'num_securite_sociale' => $_POST['num_securite_sociale']
            );
            
            // Appel de la fonction pour modifier un usager dans la base de données
            $result = update_usagers($id, $data);

            if ($result) {
                echo "<script>alert('Usager modifié avec succès.');</script>";
                // Vous pouvez rediriger l'utilisateur ou effectuer d'autres actions ici
            } else {
                echo "<script>alert('Erreur lors de la modification de l'usager. Veuillez réessayer.');</script>";
            }
        } else {
            // Affichage des erreurs
            foreach ($errors as $error) {
                echo "<script>alert('$error');</script>";
            }
        }

        /*
        if (isset($_POST['modifier'])) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $sexe = $_POST['sexe'];
            $civilite = $_POST['civilite'];
            $adresse = $_POST['adresse'];
            $code_postal = $_POST['code_postal'];
            $date_de_naiss = $_POST['date_de_naiss'];
            $lieu_de_naiss = $_POST['lieu_de_naiss'];
            $num_securite_sociale = $_POST['num_securite_sociale'];

            $sqlUpdate = 'UPDATE usagers SET nom = :nom, prenom = :prenom, sexe = :sexe, civilite = :civilite, adresse = :adresse, code_postal = :code_postal, date_de_naiss = :date_de_naiss, lieu_de_naiss = :lieu_de_naiss, num_securite_sociale = :num_securite_sociale WHERE id_usager = :id_usager';
            $stmt = $linkpdo->prepare($sqlUpdate);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':sexe', $sexe);
            $stmt->bindParam(':civilite', $civilite);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->bindParam(':code_postal', $code_postal);
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
    }*/

}

?>