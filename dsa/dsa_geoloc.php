<?php
/**
  *	dsa_geoloc.php
  *
  * @package Sagec
  * @author JCB
  * @copyright 2008
  *
  */
  $backPathToRoot = "../";
include($backPathToRoot.'dbConnection.php');
$titre_principal = "DSA - Localisation";
include_once("top.php");
include_once("menu.php");

include($backPathToRoot.'utilitaires/google/adresse.php');
include($backPathToRoot."utilitaires/google/orthodro.php");
include($backPathToRoot."login/init_security.php");

//print_r($_REQUEST);

$adresse = $_REQUEST['rue'];
$ville_nom = $_REQUEST['ville'];
$pays_nom = $_REQUEST['pays'];
$ville_zip = "";

/*
$adresse = "8 rue des noyers";
$ville_nom="vendenheim";
$pays_nom="France";
$ville_zip = "67550";
*/
/**
*	Si le lieu de l'intervention correspondent à une geolocalisation utilisable
*	alors le centre de référence est le lieu de l'incident
*	sinon ce sont les coordonnées de la ville qui servent de point de référence
*/
if($adresse != ""){
	$a = $adresse.",";
	if($ville_zip) $a.= $ville_zip.",";
	if($ville_nom) $a.= $ville_nom.",".$pays_nom;
	
	$r = localise($a);
	$local = explode(",",$r);
	if($local[0]==200){
		$ville_lng = $local[3];
		$ville_lat = $local[2];
	}
	else
		print('Ville inconnue<br>');
}

//print($a.'<br>'.$local[0].'<br>');

//print($ville_lng.'<br>'.$ville_lat);

/**
	*	DSA les plus proches
	*/
	$requete = "SELECT dsa_site,dsa_lat,dsa_lng FROM dsa";
	$resultat = ExecRequete($requete,$connexion);
	$dh=array();
	while($rep=mysql_fetch_array($resultat))
	{
		if($rep[dsa_lng] != 0){
			$dist = orthodro($rep[dsa_lat],$rep[dsa_lng],$ville_lat,$ville_lng);
			if($dist > 1) $dist= ceil($dist);
			else $dist = ceil($dist*1000)/1000;
			$dh[Security::db2str($rep['dsa_site'])] = $dist;
		}
	}
	$d = asort($dh);
	?>
	</table>
	</fieldset>
	
	<fieldset id="field1">
		<legend> DSA le plus proche</legend>
		<table id="lat" border="1" cellspacing="0">
	<?php
	foreach($dh as $key => $value)
	{
			if($value < 5){
				?><tr>
					<td><? echo $key;?></td>
					<td><? 
						if($value<1){
							echo $value * 1000;echo" m";}
						else 
							echo $value." km";
					?></td>
				</tr><?php
			}
	}
	?>
	</table>
	</fieldset>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>Nouveau DSA</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<script  type="text/javascript" src="utilitaires.js"></script>
	<script src = "../utilitaires/google/key.js"></script>
</head>

</html>