<?php
require('connectionBD_Auth.php');
require('jwt_utils.php');

$http_method = $_SERVER['REQUEST_METHOD'];
if($http_method=="POST") {

    $login=$_POST['login'];
    $password=$_POST['password'];

    $res = $linkpdo->prepare('SELECT login, password FROM authentification WHERE login = :login AND password = :password');
    $res->execute(array('login' => $login, 'password' => $password));
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