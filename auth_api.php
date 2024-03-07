<?php
require('connectionBD_Auth.php');
require('jwt_utils.php');

$http_method = $_SERVER['REQUEST_METHOD'];
if($http_method=="POST") {

    $login=$_POST['login'];
    $mdp=$_POST['mdp'];

    $res = $linkpdo->prepare('SELECT login, mdp FROM user_auth_v1 WHERE login = :login AND mdp = :mdp');
    $res->execute(array('login' => $login, 'mdp' => $mdp));
    $resultat = $res->fetchAll();

    if (count($resultat) > 0) {
        $token = generate_jwt($header, $payload, $secret);
       
    } else {
        echo "Login ou mot de passe incorrect";
    }
}
else {
    echo "Méthode non autorisée";
}
?>