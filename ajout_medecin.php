<?php

    require("verif_session.php");

    require("bd_connection.php");

    $civilite = $_POST['civilite'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    if (empty($civilite) || empty($nom) || empty($prenom)) {
        echo 'Veuillez remplir tous les champs du formulaire.';
        exit();
    } else {
        $res = $linkpdo->query('SELECT nom, prenom FROM medecin WHERE nom=\''.$_POST['nom']. '\' and prenom=\''.$_POST['prenom']. '\' ');
        $resultat = $res->fetchAll();

        if (count($resultat)>0) {  
            $message = $nom . ' fait déjà partie de la base de données, il n\'a donc pas été ajouté';
		    echo $message;
        } else {
            $req = $linkpdo->prepare('INSERT INTO medecin(civilite, nom, prenom) VALUES(:civilite, :nom, :prenom)');
            $req->execute(array('civilite' => $civilite, 'nom' => $nom, 'prenom' => $prenom));
            echo 'Le médecin a bien été ajouté.';
            header('Location: liste_medecins.php');
            exit();
        }
    }

    $res->closeCursor();  
    
?>
