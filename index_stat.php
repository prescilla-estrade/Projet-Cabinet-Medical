<?php

require("fonction_statistiques.php");

$http_method = $_SERVER['REQUEST_METHOD'];
if ($http_method === "GET") {
    $matchingData = get_repartition_usagers(); 
    $matchingData2 = get_duree_consultation(); 
    if ($matchingData) {
        deliver_response(200, "Success", $matchingData);
    } else {
        deliver_response(405, "Method Not Allowed");
    }

    if ($matchingData2) {
        deliver_response(200, "Success", $matchingData2);
    } else {
        deliver_response(405, "Method Not Allowed");
    }
}
?>
