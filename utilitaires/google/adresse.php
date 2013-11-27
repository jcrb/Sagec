<?php
/**
*	utilitaires/google/adresse.php
*	Utilitaires divers pour la cartographie
*	@version $Id$
*/

include("key.php");

/**
* 	A partir d'une adresse postale, retourne les coord. en longitude et latitude
* 	@var $adresse 8 rue des noyers, 67550 vendenheim, france
* 	@ouput format du fichier de retour: csv, xml (cf. google GeoCoder
* 	@return chaine de 3 éléments: résultat de la requête (200 si succès), latitude, longitude
*	@data[out] [0] code d'erreur
*	@data[out] [1] 
*	@data[out] [2] Latitude
*	@data[out] [3] Longitude
*/
function localise($adresse)
{
	//$key="ABQIAAAAOiFPV0Y5zzLw7M6z-aRD5RS5u1nAG4uSd7t1qAnJ_TFOSdaPdBQ7Vq8M6vT5wPThrBtK6O6z4mB3Og";//localhost
	//$key="ABQIAAAAOiFPV0Y5zzLw7M6z-aRD5RS4M0VztE0O-QJMMgCt9di7cKfD1RRqOuGcbIuRW0zmeP9ety1-dA17AA";//hus
	global $myKey;
	$localisation = rawurlencode($adresse.",".$rub['iso2']);
	$_url = "http://maps.google.com/maps/geo?q=".$localisation."&key=".$myKey."&output=csv";
	$_result = file_get_contents($_url);
	return $_result;
}

/**
*	analyse des codes d'erreur
*	@ $e = code de l'erreur
*/
function analyse_erreur($e)
{
	switch($e)
	{
		case 200:print("Aucune erreur");break;
		case 500:print("Erreur interne du serveur");break;
		case 601:print("Il manque l'adresse");break;
		case 602:print("Adresse inconnue");break;
		case 603:print("Adresse sur liste rouge");break;
		case 610:print("La clé est invalide");break;
		case 620:print("Vous avez dépassé le nombre d'accès autorisés");break;
		default:print("Erreur inconnue");
	}
	print("<br>");
}