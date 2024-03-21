<?php
//require("verif_session.php");
require("fonction_consultations.php");

// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification des champs requis
    $errors = array();
    if (empty($_POST["date_consult"])) {
        $errors[] = "La date de consultation est requise.";
    }
    if (empty($_POST["heure_consult"])) {
        $errors[] = "L'heure de consultation est requise.";
    }
    if (empty($_POST["duree_consult"])) {
        $errors[] = "La durée de consultation est requise.";
    }

    // Si aucune erreur n'est détectée, procéder à l'insertion dans la base de données
    if (empty($errors)) {
        // Préparation des données pour l'insertion
        $data = array(
            'date_consult' => $_POST['date_consult'],
            'heure_consult' => $_POST['heure_consult'],
            'duree_consult' => $_POST['duree_consult']
        );

        // Appel de la fonction pour créer une consultation dans la base de données
        $result = create_consultations($data);

        if ($result) {
            echo "<script>alert('Consultation ajoutée avec succès.');</script>";
            // Vous pouvez rediriger l'utilisateur ou effectuer d'autres actions ici
        } else {
            echo "<script>alert('Erreur lors de l'ajout de la consultation. Veuillez réessayer.');</script>";
        }
    } else {
        // Affichage des erreurs
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Saisie d'une consultation</title>
    <script src="retour.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel='stylesheet' type='text/css' href='form.css'>
</head>
<body>
    <div class='container'>
    <fieldset>
        <br>
       <legend> <h1>Formulaire de saisie d'une consultation</h1></legend>
        <form action="traitement_consultations.php" method="post">

        <label for="date_consult">Date de la consultation </label>
        <input type="date" id="date_consult" name="date_consult"><br><br>
        <label for="heure_consult">Heure de la consultation </label>
        <input type="time" id="heure_consult" name="heure_consult"><br><br>
        <label for="duree_consult">Durée de la consultation (en heure)</label>
        <select name="duree_consult">
            <option>Choisissez une option</option>
            <option value="15min">15min</option>
            <option value="30min">30min</option>
            <option value="45min">45min</option>
            <option value="1h">1h</option>
        </select><br><br>

        <label for="usager">Sélectionnez l'usager </label>
        <select name="id_usager" id="usager">
            <?php
            $server = "localhost";
            $bd = "cabinet_medical";
            $login = "admin";
            $mdp = "password";

            try {
                $conn = new PDO("mysql:host=$server;dbname=$bd", $login, $mdp);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Récupération des médecins référents pour chaque usager
                $medecinsReferents = array();

                $medecinReferent_query = "SELECT id_usager, id_medecin FROM Avoir WHERE Referent = 1";
                $medecinReferent_result = $conn->query($medecinReferent_query);

                while ($row = $medecinReferent_result->fetch(PDO::FETCH_ASSOC)) {
                    $medecinsReferents[$row['id_usager']] = $row['id_medecin'];
                }

                // Récupération des noms des usagers
                $usagers_query = "SELECT id_usager, nom, prenom FROM Usagers";
                $usagers_result = $conn->query($usagers_query);

                while ($row = $usagers_result->fetch(PDO::FETCH_ASSOC)) {
                    $isReferent = isset($medecinsReferents[$row['id_usager']]);
                    $optionClass = $isReferent ? 'bold-option' : '';
                    
                    echo "<option value='" . $row['id_usager'] . "'>" . $row['nom'] . " " . $row['prenom'] . "</option>";
                }
            } catch(PDOException $e) {
                echo "Erreur de connexion à la base de données : " . $e->getMessage();
            }
            ?>
        </select>

        <br><br>

        <label for="medecin">Sélectionnez le médecin </label>
        <select name="id_medecin" id="medecin">
            <?php
            try {
                // Vérifier si un usager est sélectionné
                if (isset($_POST['id_usager'])) {
                    $selectedUsager = $_POST['id_usager'];

                    // Afficher le médecin référent en premier s'il y en a un pour cet usager
                    if (isset($medecinsReferents[$selectedUsager])) {
                        $medecinReferent_query = "SELECT nom, prenom FROM Medecin WHERE id_medecin = " . $medecinsReferents[$selectedUsager];
                        $medecinReferent_result = $conn->query($medecinReferent_query);
                        $medecinReferent = $medecinReferent_result->fetch(PDO::FETCH_ASSOC);

                        // Affichage du médecin référent dans la liste déroulante s'il existe
                        if ($medecinReferent) {
                            echo "<option value='" . $medecinReferent['id_medecin'] . "' class='bold-option'>" . "(Médecin Référent) " . $medecinReferent['nom'] . " " . $medecinReferent['prenom'] . "</option>";
                        }
                    }
                }

                // Afficher les autres médecins dans la liste déroulante
                $medecins_query = "SELECT id_medecin, nom, prenom FROM Medecin";
                $medecins_result = $conn->query($medecins_query);

                while ($row = $medecins_result->fetch(PDO::FETCH_ASSOC)) {
                    // Ne pas répéter le médecin référent dans la liste
                    if (!isset($medecinsReferents[$selectedUsager]) || $medecinsReferents[$selectedUsager] !== $row['id_medecin']) {
                        echo "<option value='" . $row['id_medecin'] . "'>" . $row['nom'] . " " . $row['prenom'] . "</option>";
                    }
                }
            } catch(PDOException $e) {
                echo "Erreur de connexion à la base de données : " . $e->getMessage();
            }
            ?>
        </select>
        <br><br>
        <input type="submit" value="Valider">
        </form>
    </fieldset>
    <br>
    <button id='retour' onclick='retour()'><i class='fas fa-arrow-left'></i> Annuler</button>
    </div>
</body>
</html>
