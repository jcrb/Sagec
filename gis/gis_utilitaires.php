<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//----------------------------------------- SAGEC --------------------------------
/**
//	programme: 		gis_utilitaires.php
//	date de création: 	06/02/2005
//	auteur:			jcb
//	description:		Met le contenu du fichier dans une table
//	version:		1.1
//	maj le:			23/09/2005 Apostrophes
//
//-------------------------------------------------------------------------------*/
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

/**
* formate une adresse pour google map
*/
function formatte_adresse($no,$rue,$cp,$ville,$pays)
{
	$ad='';
	if($no) $ad.=$no." ";
	if($rue)  $ad.=$rue.",";
	if($cp) $ad.=$cp." ";
	if($ville)  $ad.=$ville;
	if($pays) $ad.=",".$pays;
	$adresse = rawurlencode($ad);
	return $adresse;
}
/**
* retourne les coordonnées d'un lieu à partir de son adresse
* @return $_coords[0] = resultat de la requête (200 si réponse OK)
* @return $_coords[1] = zoom
* @return $_coords[2] = latitude
* @return $_coords[3] = longitude
*/
function geolocalise($adresse)
{
	$key="ABQIAAAAOiFPV0Y5zzLw7M6z-aRD5RS5u1nAG4uSd7t1qAnJ_TFOSdaPdBQ7Vq8M6vT5wPThrBtK6O6z4mB3Og";
	$_url = "http://maps.google.com/maps/geo?q=".$adresse."&key=".$key."&output=csv";
	$_result = file_get_contents($_url);
	$_coords = array(4);
	$_coords = explode(',',$_result);
	return $_coords;
}
?>