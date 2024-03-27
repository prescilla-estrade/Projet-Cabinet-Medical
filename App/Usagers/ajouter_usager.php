<?php
//require("verif_session.php");
$baseUrl = "http://localhost/Cabinet_Medical_API/Projet-Cabinet-Medical/index_usagers.php";
$res = file_get_contents($baseUrl);
$res = json_decode($res, true);


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
    if (empty($_POST["sexe"])) {
        $errors[] = "Le sexe est requis.";
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
        $errors[] = "Le numéro de sécurité sociale est requis.";
    }

    // Si aucune erreur n'est détectée, procéder à l'insertion dans la base de données
    if (empty($errors)) {
        // Préparation des données pour l'insertion
        $data = array(
            'civilite' => $_POST['civilite'],
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'sexe' => $_POST['sexe'],
            'adresse' => $_POST['adresse'],
            'code_postal' => $_POST['code_postal'],
            'date_de_naiss' => $_POST['date_de_naiss'],
            'lieu_de_naiss' => $_POST['lieu_de_naiss'],
            'num_securite_sociale' => $_POST['num_securite_sociale']
        );

        // Appel de la fonction pour créer un usager dans la base de données
        $result = create_usagers($data);

        if ($result) {
            echo "<script>alert('Usager ajouté avec succès.');</script>";
            // Vous pouvez rediriger l'utilisateur ou effectuer d'autres actions ici
        } else {
            echo "<script>alert('Erreur lors de l'ajout de l'usager. Veuillez réessayer.');</script>";
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
    <script src="retour.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel='stylesheet' type='text/css' href='form.css'>
</head>
<body>
    <div class='container'>
        <fieldset>
            <legend><h1>Formulaire d'ajout d'un usager</h1></legend>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <br> Civilité
                <select name="civilite">
                    <option>Choisissez une option</option>
                    <option>M</option>
                    <option>Mme</option>
                </select><br>
                <br> Nom <input type="text" name="nom"><br>
                <br> Prénom <input type="text" name="prenom"><br>
                <br> Sexe <input type="text" name="sexe"><br>
                <br> Adresse <input type="text" name="adresse"><br>
                <br> Code Postal <input type="text" name="code_postal"><br>
                <br> Date de naissance <input type="date" name="date_de_naiss"><br>
                <br> Lieu de naissance <input type="text" name="lieu_de_naiss"><br>
                <br> Numéro de sécurité sociale <input type="text" name="num_securite_sociale" required maxlength="11"><br>
                <br>
                <input type="submit" value="Valider">
            </form>
        </fieldset>
        <br>
        <button id='retour' onclick='retour()'><i class='fas fa-arrow-left'></i> Annuler</button>
    </div>
</body>
</html>
