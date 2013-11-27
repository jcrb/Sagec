<?php
/**
*	sau.php
*/

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "SAU d'Alsace";
$sousmenu = "";
include_once("ror_top.php");
include_once("ror_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."utilitaires/liste.php");

$requete = "SELECT Hop_nom,ville_nom,Hop_finess,departement_ID,Hop_smur
				FROM hopital,adresse,ville
				WHERE Hop_SAU = 'o'
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.region_ID = '42'
				ORDER BY ville.departement_ID
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
	
	<link rel="stylesheet" type="text/css" href="ma_feuille_css_imprimante.css" media="print" />
	
	<!--<link rel="stylesheet" href="../js/css/jquery.dataTables.css" />
	<link rel="stylesheet" href="../js/css/TableTools.css" />-->
	<style type="text/css" media="screen">
		@import "../js/css/jquery.dataTables.css";
		@import "../js/css/TableTools.css";
	</style>
	
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery.dataTables.min.js"></script>
	<script src="../js/TableTools.min.js"></script>
	<script src="../js/ZeroClipboard.js"></script>
	
	<script src="../js/startDataTables.js"></script>

</head>

<body>
<form>
<p>Liste des SAU d'Alsace</p>
	
	<div id = "">
		<fieldset id="">
		<table id="table_hop" >  <!-- width="100%"  style="table-layout:fixed" -->
		<thead>
			<tr>
				<th>H�pital</th>
				<th>SMUR</th>
				<th>FINES</th>
				<th>Ville</th>
				<th>Dept</th>
				<th>Adresse</th>
				<th>Adresse</th>
				<th>voir</th>
			</tr>
		</thead>
		<tboby>
			<?php while($rub = mysql_fetch_array($resultat)){?>
			<tr>
				<td><?php echo Security::db2str($rub['Hop_nom']);?></td>
				<td><?php echo $rub['Hop_smur'];?></td>
				<td><?php echo $rub['Hop_finess'];?></td>
				<td><?php echo Security::db2str($rub['ville_nom']);?></td>
				<td><?php echo Security::db2str($rub['departement_ID']);?></td>
				<td><?php echo Security::db2str($rub['ad_zone1']);?></td>
				<td><?php echo Security::db2str($rub['ad_zone2']);?></td>
				<td><a href="../hopital.php?ID_hopital=<?php echo $rub['Hop_ID'];?> ">voir</a></td>
			</tr>
			<?php } ?>
		</tboby>
		</table>
	</div>
</form>
</body>
</html>