<?php
require("verif_session.php");
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
            <legend> <h1>Formulaire d'ajout d'un usager</h1> </legend>
                <form action="ajout_usager.php" method="post">
                    <br> Civilité 
                    <select name="civilite">
                        <option>Choisissez une option</option>
                        <option>M</option>
                        <option>Mme</option>
                    </select><br>
                    <br> Nom <input type="text" name="nom"><br>
                    <br> Prénom <input type="text" name="prenom"><br>
                    <br> Adresse <input type="text" name="adresse"><br>
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
