<?php 
/**
	utilitaire pharmacie
	pharmacies/extract_med.php
* @package Sagec
* @author JCB
* @version $Id$
*/
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
require_once("../gis/gis_utilitaires.php");

$no_error = 200; // AND med_ID >216 AND med_ID < 622
$requete = "SELECT med_ID,med_adresse,ville.ville_ID, ville_nom,ville_zip
				FROM mg67,ville
				WHERE ville_insee = code_insee
				AND mg67.ville_ID = 0
				";
$execution = ExecRequete($requete,$connexion);
while($rep = MySql_Fetch_Array($execution))
{
	$ad = formatte_adresse('',$rep['med_adresse'],$rep['ville_zip'],$rep['ville_nom'],"FRANCE");
	$coord = geolocalise($ad);
	if($coord['0'] == $no_error)
	{
		$lat = $coord['2']; 
		$lng = $coord['3'];
	}
	$requete = "UPDATE mg67 SET 
					ville_ID = '$rep[ville_ID]',
					lat = '$lat',
					lng = '$lng'
					WHERE med_ID = '$rep[med_ID]'";
	ExecRequete($requete,$connexion);
	print($rep['med_ID']." ".$rep['code_insee']." ".$rep['ville_ID']." ".$lat." ".$lng."<br>");
}

/*
	if(!$resultat[0])
		print("Pas de résultats pour ".$elements['0']."<br>");
	else 
	{
		$zip = $elements['1'];
		$adresse = $elements['2']." ".$elements['3']." ".$elements['4']." ".$elements['5'];
		$nom = $elements[6];
		$tel = $elements[7];

		$ad = formatte_adresse($elements[2],$elements[5],$zip,$ville,"FRANCE");
		$coord = geolocalise($ad);

		if($coord['0'] != $no_error)
			print("Pas de coordoonées pour: ");
		print($nom." ".$adresse.", ".$zip." ".$commune_id." ".$tel."  lat = ".$coord['2']." long = ".$coord['3']."<br>");

		// remplissage de la table pharmacie de la base
		$requete = "INSERT INTO pharmacie ( `ID_pharmacie` , `ID_commune` , `nom` , `adresse` , `zip` , `tel` , `fax` , `long` , `lat` , `secteur` )
					VALUES('','$commune_id','$nom','$adresse','$zip','$tel','','$coord[3]',$coord[2],'')";
		print($requete.'<br>');
		ExecRequete($requete,$connexion);
	}
}
*/

?>