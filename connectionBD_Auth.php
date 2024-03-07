<?php
$server = "localhost";
$bd = "authentification";
$login = "admin";
$mdp = "password";

try {
    $linkpdo = new PDO("mysql:host=$server;dbname=$bd", $login, $mdp);
} catch (Exception $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}
?>
