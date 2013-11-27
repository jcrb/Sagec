<?php
//cron/formate.php
include "utilitaire_cron.php";

$chpHeure = "*";
$chpMinute = "*";
$chpJourMois = "*";
$chpJourSemaine = "*";
$chpMois = "*";
//$chpCommande = "/var/www/html/SAGEC67_v3/veille_sanitaire/cron/test.php";
$chpCommande = "wget http://localhost/SAGEC67_v3/veille_sanitaire/cron/test.php";
$chpCommentaire = "test";
$rep = ajouteScript($chpHeure, $chpMinute, $chpJourMois, $chpJourSemaine, $chpMois, $chpCommande, $chpCommentaire);
print("formatage de cron: ".$rep);
?>