<?php
//require("verif_session.php");
require("fonction_medecins.php");

// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification des champs requis
    $errors = array();
    if (empty($_POST["civilite"])) {
        $errors[] = "La civilité est requise.";
    }
    if (empty($_POST["nom"])) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($_POST["prenom"])) {
        $errors[] = "Le prénom est requis.";
    }

    // Si aucune erreur n'est détectée, procéder à l'insertion dans la base de données
    if (empty($errors)) {
        // Préparation des données pour l'insertion
        $data = array(
            'civilite' => $_POST['civilite'],
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom']
        );

        // Appel de la fonction pour créer un médecin dans la base de données
        $result = create_medecins($data);

        if ($result) {
            echo "<script>alert('Medecin ajouté avec succès.');</script>";
            // Vous pouvez rediriger l'utilisateur ou effectuer d'autres actions ici
        } else {
            echo "<script>alert('Erreur lors de l'ajout du médecin. Veuillez réessayer.');</script>";
        }
    } else {
        // Affichage des erreurs
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Ajout d'un médecin</title>
        <script src="retour.js"></script>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
        <link rel='stylesheet' type='text/css' href='form.css'>
    </head>
    <body>
        <div class='container'>
        <fieldset>
            <legend> <h1>Formulaire d'ajout d'un médecin</h1> </legend>
                <form action="ajout_medecin.php" method="post">
                    <br> Civilité 
                    <select name="civilite">
                        <option>Choisissez une option</option>
                        <option>M</option>
                        <option>Mme</option>
                    </select><br>
                    <br> Nom <input type="text" name="nom"></br>
                    <br> Prénom <input type="text" name="prenom"><br>
                    <br>
                    <input type="submit" value="Valider">
                </form>
        </fieldset>
        <br>
        <button id='retour' onclick='retour()'><i class='fas fa-arrow-left'></i> Annuler</button>
        </div>
    </body>
</html>