<?php
$server = "mysql-authentifications.alwaysdata.net";
$bd = "authentifications_api";
$login = "352915_admin";
$mdp = "U2p0p2A1*2003";

try {
    $linkpdo = new PDO("mysql:host=$server;dbname=$bd", $login, $mdp);
} catch (Exception $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}
?>
