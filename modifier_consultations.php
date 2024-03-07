<?php

require("verif_session.php");

require("bd_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_usager']) && isset($_POST['id_medecin'])) {
        $id_usager = $_POST['id_usager'];
        $id_medecin = $_POST['id_medecin'];

        $sqlQuery = 'SELECT * FROM Rdv WHERE id_usager = :id_usager AND id_medecin = :id_medecin';
        $resultat = $linkpdo->prepare($sqlQuery);
        $resultat->bindParam(':id_usager', $id_usager);
        $resultat->bindParam(':id_medecin', $id_medecin);
        $resultat->execute();
        $consultation = $resultat->fetch(PDO::FETCH_ASSOC);

        if ($consultation) {
            echo "
            <!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
                <link rel='stylesheet' type='text/css' href='form.css'>
                <title>Modifier Consultation</title>
            </head>
            <body>
                <div class='container'>
                <fieldset>
                    <legend><h1>Modifier Consultation</h1></legend>
                    <form action='' method='post'>
                        <input type='hidden' name='id_usager' value='{$consultation['id_usager']}'>
                        <input type='hidden' name='id_medecin' value='{$consultation['id_medecin']}'>
                        
                        <label for='date_heure_rdv'>Date/Heure :</label>
                        <input type='datetime-local' name='date_heure_rdv' value='{$consultation['date_heure_rdv']}' required><br><br>
                        
                        <label for='duree'>Durée (en heures) :</label>
                        <select name='duree' required>
                            <option value='15min' " . ($consultation['duree'] === '15min' ? 'selected' : '') . ">0:15</option>
                            <option value='30min' " . ($consultation['duree'] === '30min' ? 'selected' : '') . ">0:30</option>
                            <option value='45min' " . ($consultation['duree'] === '45min' ? 'selected' : '') . ">0:45</option>
                            <option value='1h' " . ($consultation['duree'] === '1h' ? 'selected' : '') . ">1:00</option>
                        </select><br><br>
                        
                        <input type='submit' name='modifier' value='Modifier'>
                    </form>
                </fieldset>
                <br>
                <script src='retour.js'></script>
                <button id='retour' onclick='retour()'><i class='fas fa-arrow-left'></i> Annuler</button>
                </div>
            </body>
            </html>";

            if (isset($_POST['modifier'])) {
                $date_heure_rdv = $_POST['date_heure_rdv'];
                $duree = $_POST['duree'];

                $sqlUpdate = 'UPDATE Rdv SET date_heure_rdv = :date_heure_rdv, duree = :duree WHERE id_usager = :id_usager AND id_medecin = :id_medecin';
                $stmt = $linkpdo->prepare($sqlUpdate);
                $stmt->bindParam(':date_heure_rdv', $date_heure_rdv);
                $stmt->bindParam(':duree', $duree);
                $stmt->bindParam(':id_usager', $id_usager);
                $stmt->bindParam(':id_medecin', $id_medecin);
                $stmt->execute();

                echo "Consultation mise à jour avec succès !";
                header('Location: liste_consultations.php');
                exit();
            }
        } else {
            echo "Aucune consultation trouvée.";
        }
    } else {
        echo "Aucune consultation sélectionnée.";
    }
}

?>