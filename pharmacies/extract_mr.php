<?php 
/**
	utilitaire maison de retraite
	extract_mr.php
*/
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../adresse_ajout.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
require_once("../gis/gis_utilitaires.php");

$source = "/home/jcb/Documents/sagec/Finess nouveau/maison de retraite.csv";
$no_error = 200;

$fp = fopen($source,"r");
//for($i = 0; $i < 10; $i++)
while(!feof($fp))
{
	$ligne = fgets($fp);
	$ligne = fgets($fp);
	$elements = explode(";",$ligne);
	//print_r($elements)."<br>";
	
	// identifiant de la ville
	print($elements[7]." --> ");
	$v = trim($elements[7],'""');
	// si le nom de ville existe
	if(strlen($v)>2)
	{
		// suppression de l'extension cedex
		$v = str_replace(' CEDEX','',$v);
		// mise en place de séparateur sauf si commence par LA ex LA WANTZENAU
		
		if(substr_compare($v,'LA ',0,3,TRUE)==0 || substr_compare($v,'LE ',0,3,TRUE)==0)
		{
			$x = substr($v,0,3); 			// 'LA '
			$y = substr($v,3,strlen($v)); // 'Petite Pierre'
			$y = str_replace(' ','-',$y); // 'Petite-Pierre'
			$v = $x.$y;							// 'La Petite Pierre'
		}
		else
		{
			$v = str_replace(' ','-',$v);
		}
		// on cherche l'identifiant de la ville dans la BD 
		$requete = "SELECT * FROM `ville` WHERE `ville_nom` LIKE '$v' LIMIT 1";
		//print($requete.'<br>');
		$rep = ExecRequete($requete,$connexion);
		$resultat = MySql_Fetch_Array($rep);
		print("ville_id = ".$resultat['ville_ID']."  ");
		if($resultat['ville_ID']=="")
			print($v." n'a pu être identifié<br>");
		else
		{
			$ville = $resultat['ville_ID'];
			print('<br>');
		}
	}
	
	// récupération des données adresse 
	$zip = $elements[6];
	$z1 =  $elements[4];
	$z2 =  $elements[5];
	$adresseID = enregistre_adresse('',$z1,$z2,$ville_id,$zip='','V',$latitude,$longitude);
	
	/**
	$requete = "INSERT INTO `pma`.`ems` (`ems_ID`, `ems_finess`, `ems_nom`, `ems_org_ID`, `ems_adresse_ID`, `ems_date_ouverture`, `ems_date_maj`, 
	`ems_code_categorie`, `ems_code_statut`, `ems_code_tarif`, `ems_finess_juridique`, `ems_discipline_code`, `ems_fonction_code`) 
	VALUES (NULL, \'123456\', \'Epadh Vendenheim\', \'1\', \'2\', \'19/10/1953\', \'16/06/2010\', \'3\', \'4\', \'5\', \'66666\', \'7\', \'8\');";
	
	
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
	*/
}
fclose($fp);

?>