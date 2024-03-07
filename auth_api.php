<?php
require('connectionBD_Auth.php');
require('jwt_utils.php');

$http_method = $_SERVER['REQUEST_METHOD'];
if($http_method=="POST") {
    // Récupérer le corps de la requête
    $data = file_get_contents("php://input");
    // Convertir le JSON en tableau associatif
    $data = json_decode($data, true);

    // Vérifier si les données de formulaire sont présentes
    if(isset($data['login']) && isset($data['mdp'])) {
        $login=$data['login'];
        $mdp=$data['mdp'];

        $res = $linkpdo->prepare('SELECT login, mdp FROM user_auth_v1 WHERE login = :login AND mdp = :mdp');
        $res->execute(array('login' => $login, 'mdp' => $mdp));
        $resultat = $res->fetchAll();

        if (count($resultat) > 0) {
            // Générer un jeton JWT
            $header = array(
                "typ" => "JWT",
                "alg" => "HS256"
            );
            $payload = array(
                "login" => $login,
                // Autres données que vous souhaitez inclure dans le JWT
            );
            $secret = "votre_secret_key"; // Changez ceci par votre clé secrète
            $token = generate_jwt($header, $payload, $secret);

            // Envoyer le jeton JWT dans la réponse
            http_response_code(200);
            echo json_encode(array("message" => "Authentification réussie", "token" => $token));
        } else {
            http_response_code(401); // 401 Unauthorized
            echo json_encode(array("message" => "Login ou mot de passe incorrect"));
        }
    } else {
        http_response_code(400); // 400 Bad Request
        echo json_encode(array("message" => "Veuillez fournir un login et un mot de passe"));
    }
} else {
    http_response_code(405); // 405 Method Not Allowed
    echo json_encode(array("message" => "Méthode non autorisée"));
}
?>
