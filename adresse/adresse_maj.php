<?php
/**
  *	adresse_maj.php
  */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
require_once($backPathToRoot."utilitaires/google/adresse.php");
require($backPathToRoot."dbConnection.php");
include_once("top.php");
include_once("menu.php");

require $backPathToRoot.'utilitaires/google/utilitaires_carto.php';
include($backPathToRoot."utilitairesHTML.php");
require($backPathToRoot."dbConnection.php");
include($backPathToRoot."html.php");
include_once($backPathToRoot."login/init_security.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>Gestion des organismes</title>
	<meta http-equiv="content-type" content="="text/ht; charset=ISO-8859-15" ">
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="">
<form name="" action= "" method="">
<div id="div2">
	<fieldset id="field1">
		<legend>Mise à jour des coordonnées de géolocalisation</legend>
		<p>
			Le programme parcourt la table <b>adresse</b>. Si les champs <i>latitude</i> et/ou <i>longitude</i><br>
			sont vides, alors le programme les calcule à condition de disposerd'une adresse complète: pays, rue, ville.
			
		</p>
		<input type="submit" name="ok" id="valider" value="geolocalise"/>
	</fieldset>
</div>
<?php
	if($_REQUEST['ok']=='geolocalise')
	{
		$nbEnregistrement = 0;
		$requete = "SELECT adresse.* ,pays_nom,ville_nom
						FROM adresse, ville,pays
						WHERE adresse.ad_longitude = 0
						AND (ad_zone1 <> '' OR ad_zone2 <> '')
						AND adresse.ville_ID = ville.ville_ID
						AND ville.pays_ID = pays.pays_ID
						";
		$resultat = ExecRequete($requete,$connexion);
		while($rub=mysql_fetch_array($resultat))
		{
			$adresse="";
			if($rub[ad_zone1] != "") $adresse .= Security::db2str($rub[ad_zone1]).',';
			if($rub[ad_zone2] != "") $adresse .= Security::db2str($rub[ad_zone2]).',';
			if($rub[zip] != "") $adresse .= $rub[zip].',';
			$adresse .= Security::db2str($rub[ville_nom]).','.Security::db2str($rub[pays_nom]);
			print($adresse."<br>");
			
			$rep = localise($adresse);
			$geoloc=explode(",",$rep);
			if($geoloc[0]==200)
			{
				$requete2 = "UPDATE adresse SET ad_latitude = '$geoloc[2]',ad_longitude = '$geoloc[3]' WHERE ad_ID = '$rub[ad_ID]'";
				ExecRequete($requete2,$connexion);
				print($requete2."<br>");
				$nbEnregistrement++;
			}
			else
			{
				print("erreur: ".$geoloc[0]." adresse_ID: ".$rub[ad_ID]."<br>");
			}
			
		}
		print("<br>".$nbEnregistrement." enregistrements ont été mis à jour<br>");
	}
?>

</form>
</body>
</html>
