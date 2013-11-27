<?php 
/**
	utilitaire pharmacie
	extract_pharma.php
*/
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
require_once("../gis/gis_utilitaires.php");

$source = "pharmacies.txt";
$no_error = 200;

$fp = fopen($source,"r");
//for($i = 0; $i < 10; $i++)
while(!feof($fp))
{
	$ligne = fgets($fp);
	$elements = explode("\t",$ligne);
	$ville = str_replace (' ', '-', $elements[0]);
	$requete = "SELECT ville_ID FROM ville WHERE ville_nom LIKE( '%$ville%') ";
	$rep = ExecRequete($requete,$connexion);
	$resultat = MySql_Fetch_Array($rep);
	$commune_id = $resultat[0];
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
fclose($fp);

?>