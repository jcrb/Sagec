<?php
/**
*	ror_gabarit.php
*/

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "ROR";
$sousmenu = "";
include_once("ror_top.php");
include_once("ror_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."utilitaires/liste.php");

$requete = "SELECT ror_ressource.*, ressource_type_nom
				FROM ror_ressource,ror_ressource_type
				WHERE ror_ressource_type.ressource_type_ID = ror_ressource.ressource_type_ID
				ORDER BY ror_ressource.ressource_nom
				";
$resultat = ExecRequete($requete,$connexion);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="top.css" type="text/css" media="all" />
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>


<body onload="">

<form name="" action= "" method = "get">
<div id="div2">

	<a href="ressource_new.php">Créer une nouvelle ressource</a><br>
	
		<table>
			<tr>
				<th>intitulé</th>
				<th>Type</th>
				<th>Fréquence</th>
				<th>visible</th>
				<th>ordre</th>
				<th>modifier</th>
				<th>supprimer</th>
			</tr>
			<? while($rep = mysql_fetch_array($resultat)){?>
				<tr>
					<td><?php echo Security::db2str($rep[ressource_nom]);?></td>
					<td><?php echo ($rep[ressource_type_nom]);?></td> <!-- Security::db2str -->
					<td><?php echo $rep[report_frequency];?></td>
					<td><?php echo $rep[visible];?></td>
					<td><?php echo $rep[display_order];?></td>
					<td><a href="ressource_new?ressourceID=<?php echo $rep[ror_ressource_ID];?>">modifier</a></td>
					<td><a href="ressource_delete?ressourceID=<?php echo $rep[ror_ressource_ID];?>">supprimer</a></td>
				</tr>
				<? } ?>
		</table>
</div>

</form>
</body>
</html>
