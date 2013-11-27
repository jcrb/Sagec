<?php
//indique que le type de la réponse renvoyée au client sera du Texte
header("Content-Type: text/plain");
//anti Cache pour HTTP/1.1
header("Cache-Control: no-cache , private");
//anti Cache pour HTTP/1.0
header("Pragma: no-cache");
//simulation du  temps d'attente du serveur (2 secondes)
sleep(2);
//calcul du nouveau gain entre 0 et 100 Euros
$resultat =  rand(0,100);
//envoi de la réponse à la page HTML
echo $resultat ;
?>