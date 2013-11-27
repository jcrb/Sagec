<?php
/**
*	org_geoloc.php
*	met à jour les ambulances privées: organisme_type_ID = 4 
*/
$backPathToRoot = "../";
require_once($backPathToRoot."utilitaires/google/adresse.php");
require($backPathToRoot."dbConnection.php");

$requete = "SELECT adresse.ad_zone1,adresse.ad_zone2, ville_nom,ad_ID
				FROM adresse,organisme,ville
				WHERE ad_longitude = 0
				AND ad_ID = adresse_ID
				AND organisme_type_ID = 4
				AND ville.ville_ID = adresse.ville_ID
				";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
//$rub=mysql_fetch_array($resultat);
{
	$adresse="";
	if($rub[ad_zone1] != "") $adresse .= $rub[ad_zone1].',';
	if($rub[ad_zone2] != "") $adresse .= $rub[ad_zone2].',';
	$adresse .= $rub[ville_nom].','." FRANCE";
	$rep = localise($adresse);
	$geoloc=explode(",",$rep);

	if($geoloc[0]==200){
		$requete2 = "UPDATE adresse SET ad_latitude = '$geoloc[2]',ad_longitude = '$geoloc[3]' WHERE ad_ID = '$rub[ad_ID]'";
		ExecRequete($requete2,$connexion);
		print($requete2."<br>");
	}
	else{
		print("erreur: ".$geoloc[0]." adresse_ID: ".$rub[ad_ID]."<br>");
	}
}
?>