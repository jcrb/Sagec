<?php
/**
*	ressource_liste.php
*/

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
include_once("ror_top.php");
include_once("ror_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."utilitaires/liste.php");
require($backPathToRoot."login/init_security.php");

$locationID = $_REQUEST['locationID'];
$locationType =  $_REQUEST['locationtype'];
$ressourceID =  $_REQUEST['ressourceID'];

$requete = "SELECT DISTINCT ressource_type_nom,ressource_type_ID
				FROM ror_ressource_type,ror_locationtype_ressource
				WHERE ror_locationtype_ressource.locationtype_ID = '$locationType'
				AND   ror_locationtype_ressource.ressourcetype_ID = ror_ressource_type.ressource_type_ID
				";		
$resultat = ExecRequete($requete,$connexion);

if(isset($ressourceID))
{
	$requete = "SELECT ressource_nom
					FROM ror_ressource
					WHERE ressource_type_ID = '$ressourceID'
					";
	/*
	$requete = "SELECT ror_inventaire.*,ressource_nom
				FROM ror_inventaire,ror_ressource
				WHERE location_ID = '$locationID'
				AND ror_inventaire.ressource_type_ID = '$locationType'
				AND ror_ressource.ror_ressource_ID = ror_inventaire.ressource_ID
				ORDER BY ror_ressource.ressource_nom
				";
				*/
	$resultat2 = ExecRequete($requete,$connexion);
	while($rep2 = mysql_fetch_array($resultat2))
	{
		echo $rep2['ressource_nom']."<br>";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="../top.css" type="text/css" media="all" />
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="">

<form name="" action= "" method = "get">

<input type="hidden" name="locationID" value="<?php echo $locationID;?>">
<input type="hidden" name="locationtype" value="<?php echo $locationType;?>">

<div id="div2">
	
		<table>
			<tr>
				<th>Type de ressource</th>
				<th>Voir</th>
			</tr>
			<? while($rep = mysql_fetch_array($resultat)){?>
				<tr>
					<td><?php echo Security::db2str($rep[ressource_type_nom]);?></td>
					<td><a href="ressource_inventaire?ressourceID=<?php echo $rep[ressource_type_ID];?>&locationID=<?php echo $locationID;?>&locationtype=<?php echo $locationType;?>">voir</a></td>
				</tr>
				<? } ?>
		</table>
</div>
</form>
</body>
</html>