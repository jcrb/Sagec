<?php
/**
  *	centrales_liste.php
  */
  
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
include_once("top.php");
include_once("menu.php");
require($backPathToRoot."dbConnection.php");

$requete = "SELECT centrale_ID, centrale_nom, centrale_type_nom,centrale_adresse_ID,org_ID
				FROM centrale, centrale_type
				WHERE centrale.centrale_type_ID = centrale_type.centrale_type_ID
				ORDER BY centrale_type_nom,centrale_nom
				";
$resultat = ExecRequete($requete,$connexion);

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

<body>
<div id="div2">

	<fieldset id="field1">
		<legend>Liste des centrales de moyens</legend>
		<table>
			<tr>
			<th>type</th>
			<th>Nom</th>
			<th>Organisme</th>
			<th>Adresse_ID</th>
			<th>Voir</th>
			</tr>
		<?php while($rep=mysql_fetch_array($resultat)){?>
			<tr>
				<td><?php echo $rep['centrale_type_nom'];?></td>
				<td><?php echo $rep['centrale_nom'];?></td>
				<td><?php echo $rep['org_ID'];?></td>
				<td><?php echo $rep['centrale_adresse_ID'];?></td>
				<td><a href="centrales_main.php?centraleID=<?php echo $rep['centrale_ID'];?>">voir</a></td>
			</tr>
			<?php } ?>
		</table>
	</fieldset>
</body>
</html>
