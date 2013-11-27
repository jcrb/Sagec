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
//
//	programme: 		commune_vers_ville.php
//	date de création: 	06/02/2005
//	auteur:			jcb
//	description:		Met le contenu du fichier dans une table
//	version:		1.1
//	maj le:			23/09/2005 Apostrophes
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require "../classe_dessin.php";
require "../gis/gis_utilitaires.php";

$langue = $_SESSION['langue'];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<head>");
print("<title>F2T</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");
//================================================================================
print("<BODY>");
print("<FORM name=\"menu\" method=\"post\" enctype=\"multipart/form-data\" action=\"commune_vers_ville.php\">");

/*
if(!$_REQUEST['ok']=='OK')
{
	print("<table>");
	print("<tr>");// fichier à charger
	print("<td>Fichier source</td>");
	print("<td><input type=\"file\" lang=\"fr\" name=\"fichier\"></td>");
	print("</tr>");

	print("<tr>");
	print("<td>&nbsp;</td>");
	print("<td><input type = \"submit\" name = \"ok\" value=\"OK\"></td>");
	print("</tr>");
	print("<table>");
}
else
{
	$fichier= $_FILES['fichier']['name'];
	$taille= $_FILES['fichier']['size'];
	$tmp= $_FILES['fichier']['tmp_name'];
	$type= $_FILES['fichier']['type'];
	$erreur= $_FILES['fichier']['error'];

	echo"Nom originel => $fichier <br />";
	echo"Taille => $taille <br />";
	echo"Adresse temporaire sur le serveur => $tmp <br />";
	echo"Type de fichier => $type <br />";
	echo"Code erreur => $erreur. <br />";

	if ($err = $_FILES['fichier']['error']){
	echo"il y a eu une erreur<br>";
	if($err == UPLOAD_ERR_INI_SIZE)
  		echo"Le fichier est plus gros que le max autorisé par PHP";
	elseif($err == UPLOAD_ERR_FORM_SIZE)
		echo"Le fichier est plus gros qu'indiqué dans le formulaire";
	elseif($err == UPLOAD_ERR_PARTIAL)
  		echo"Le fichier n'a été que partiellement téléchargé";
	elseif($err == UPLOAD_ERR_NO_FILE)
  		echo"Aucun fichier n'a été téléchargé.";
	} else echo"fichier correctement téléchargé" ;

	print("<br>");
	$fp=@fopen($tmp,"r");

	// zone de proximité
	//	$requete = "SELECT* FROM zone_proximite";
	//	$resultat = ExecRequete($requete,$connexion);
	//	while($zp=mysql_fetch_array($resultat))
	//	{
	//		$zonep[$zp['z_proximite_nom']] = $zp['z_proximite_ID']; 
	//	}
	//	print_r($zonep);

	while(!feof($fp)){
		$mot = fgets($fp,4096);
		//if($mot<1)break;// éviter les enregistrements vides
		echo $mot."<br>";
		//$mot = str_replace("'","\'",$mot);//protection des apostrophes
		//$rub = explode("\t",$mot);
		$rub = explode(",",$mot);

		// recherche dans la commune dans le fichier ville par son nom
		$requete = "SELECT ville_ID FROM ville WHERE ville_nom = '$rub[4]'";
		$resultat = ExecRequete($requete,$connexion);
		$mot = mysql_fetch_array($resultat);
		
		// recherche dans la table communes avec ne n° Insee
		//$requete = "SELECT * FROM commune WHERE com_insee = '$rub[1]'";
		//$resultat = ExecRequete($requete,$connexion);
		//$com = mysql_fetch_array($resultat);

		if($mot['ville_ID'])
		{
			// update
			$zone = $zonep[$rub[5]];
			$requete = "UPDATE ville SET 
				ville_INSEE = '$rub[2]',
				canton_ID = '$rub[12]',
				arrondissement_ID = '$rub[13]',
				territoire_sante = '$rub[15]',
				zone_proximite = '$rub[20]',
				departement_ID = '$rub[6]',
				secteur_Vsav_ID = '$rub[19]',
				secteur_Adps_ID = '$rub[18]',
				secteur_Smur_ID = '$rub[17]',
				secteur_apa_ID = '$rub[16]',
				admin_ID = '$rub[14]'
			WHERE ville_ID = $mot[ville_ID]";
		}
		else
		{
			// create
			$zone = $zonep[$rub[5]];
			$requete = "INSERT INTO ville (ville_ID,ville_nom,ville_INSEE,canton_ID,arrondissement_ID,territoire_sante,zone_proximite,pays_ID,zone_ID,region_ID,departement_ID,secteur_Vsav_ID,secteur_Adps_ID,secteur_Smur_ID,secteur_apa_ID,admin_ID,ville_zip,ville_longitude,ville_latitude,ville_lambertX,ville_lambertY) VALUES( 
				 '',
				 '$rub[1]', 
				 '$rub[2]', 
				 '$rub[12]',
				 '$rub[13]',
				 '$rub[15]', 
				 '$rub[20]',
				 '$rub[9]',
				 '$rub[8]',
				 '$rub[7]',
				 '$rub[6]',
				 '$rub[19]',
				 '$rub[18]',
				 '$rub[17]',
				 '$rub[16]',
				 '$rub[14]',
				 '$rub[3]',
				 '$rub[10]',
				 '$rub[11]',
				 '$rub[4]',
				 '$rub[5]'
				)";
		}
		print($requete."<br>");
		$resultat = ExecRequete($requete,$connexion);
	}
	fclose($fp);
}
*/

/*
// longitude et latitude
$key="ABQIAAAAOiFPV0Y5zzLw7M6z-aRD5RS5u1nAG4uSd7t1qAnJ_TFOSdaPdBQ7Vq8M6vT5wPThrBtK6O6z4mB3Og";
$requete = "SELECT ville_ID,ville_nom, iso2 FROM ville, pays WHERE ville_longitude = 0 AND ville_latitude = 0 AND ville.pays_ID = pays.pays_ID ORDER BY ville_nom";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	$localisation = rawurlencode($rub['ville_nom'].",".$rub['iso2']);
	echo $localisation."<br>";
	$_url = "http://maps.google.com/maps/geo?q=".$localisation."&key=".$key."&output=csv";
	//print($_url."<br>");
	//$_url = sprintf('http://%s/maps/geo?&q=%s&output=csv&key=%s','maps.google.com','strasbourg',$key);
    $_result = false;
    if($_result = file_get_contents($_url))
	{
		print_r($_result);print("<br>");
       	$_result_parts = explode(',',$_result);
       	if($_result_parts[0] != 200) print(" adresse inconnue <br>");
       	$_coords['lat'] = $_result_parts[2];
       	$_coords['lon'] = $_result_parts[3];
		$requete = "UPDATE ville SET ville_longitude = '$_result_parts[3]',ville_latitude = '$_result_parts[2]' WHERE ville_ID = '$rub[ville_ID]'";
		ExecRequete($requete,$connexion);
	}
}
*/

//remplacement dans organisme de commune par ville
$requete = "SELECT * FROM commune";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	$requete = "SELECT ville_nom FROM ville, commune WHERE ville_nom = '$rub[com_nom]'";
	$result = ExecRequete($requete,$connexion);
	$ville=mysql_fetch_array($result);
	if(!$ville)
	{
		$adresse = formatte_adresse('','','',$rub['com_nom'],'FR');print($adresse.'<br>');
		$coord = geolocalise($adresse);print_r($coord);
		$requete = "INSERT INTO ville (ville_ID,ville_nom,ville_INSEE,canton_ID,arrondissement_ID,territoire_sante,zone_proximite,pays_ID,zone_ID,region_ID,departement_ID,secteur_Vsav_ID,secteur_Adps_ID,secteur_Smur_ID,secteur_apa_ID,admin_ID,ville_zip,ville_longitude,ville_latitude,ville_lambertX,ville_lambertY) VALUES( 
				 '',
				 '$rub[com_nom]', 
				 '$rub[com_INSEE]', 
				 '$rub[canton_ID]',
				 '',
				 '', 
				 '',
				 '1',
				 '1',
				 '42',
				 '67',
				 '',
				 '',
				 '',
				 '',
				 '',
				 '',
				 '$coord[2]',
				 '$coord[3]',
				 '$rub[ville_lambertX]',
				 '$rub[ville_lambertY]'
				)";
		print($requete.'<br>');
		ExecRequete($requete,$connexion);
	}
}

print("</BODY>");
?>