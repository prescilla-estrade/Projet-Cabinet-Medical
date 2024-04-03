<?php
$server = "mysql-appcabinetmedical.alwaysdata.net";
$bd = "cabinet_medical_api";
$login = "353444_admin";
$mdp = "35iut44!";

try {
    $linkpdo = new PDO("mysql:host=$server;dbname=$bd", $login, $mdp);
} catch (Exception $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}
?>
