<?php

require("fonction_statistiques.php");

$http_method = $_SERVER['REQUEST_METHOD'];
if ($http_method === "GET") {
    $matchingData = get_repartition_usagers(); 
    if ($matchingData) {
        deliver_response(200, "Success", $matchingData);
    } else {
        deliver_response(405, "Method Not Allowed");
    }
}

?>
