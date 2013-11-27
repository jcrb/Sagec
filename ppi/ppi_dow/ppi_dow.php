<?php

/**
 * ppi_dow.php
 *
 * @version $Id: index.php 38 2008-02-27 21:07:19Z jcb $
 * @package Sagec
 * @author JCB
 * @copyright 2008
 */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION['auto_sagec'] && !$_SESSION['auto_ppi'])header("Location:../../logout.php");
$backPathToRoot = "../../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
$ppi_id = $_REQUEST['id'];
$ppi_nom = $_REQUEST['nom'];
$requete = "UPDATE plan_courant SET plan_ID = '$ppi_id' WHERE plan_courant_ID = 1";
ExecRequete($requete,$connexion);

/**
  *	produits et scenarios
  */
  
  $requete = "SELECT stocki_nom,stocki_ID
					FROM stockage_industriel,produitsChimiques 
					WHERE ppi_ID = '$ppi_id'
					AND stockage_industriel.produit_ID = produitsChimiques.chem_ID
					";
	$scenarios = ExecRequete($requete,$connexion);
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<script>var path="../../";</script>
	<script>var path2="";</script>
	<!-- Ceci est spécifique de Sagec, localhost  -->
	<script src = "../../utilitaires/google/key.js"></script>
	<script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
    </script>
		<script src = "ppi_icones.js"></script>
		<script src = "ppi_markers.js"></script>
		<script src = "../../ajax/jquery-courant.js"></script>
    <script src="ppi_dow_data.php" type="text/javascript"></script>
    <link href="../map.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="map"></div>
	<div id="mouseTrack">SAGEC Alsace</div>
	<!-- le fct time() oblige à  réaafficher la nouvelle image et non celle restant en cache -->
	<div class="transp" id="rose"><img src="../rose_vent.png?<?echo time()?>"/></div>
	<div id="toolbar">
		<table>
			<tr><td><B><?php echo Security::db2str($ppi_nom);?></B></td>
			<tr><td><input type="checkbox" name="mouseTracking" id="mt" onClick="analyseMenu()"> Geoloc </td></tr>
			<tr><td><input type="checkbox" name="struct_temp" id="st" onClick="analyseMenu()"> Structures PPI </td></tr>
			<tr><td><input type="checkbox" name="rdv" id="rdv" onclick="analyseMenu()">Rose des Vents</td></tr>
		
  		<tr><td>-------</td></tr>

  		<?php while($rub=mysql_fetch_array($scenarios)){$no = $rub['stocki_ID'];?>
			<tr>
				<td><input type="checkbox" name="struct_temp" id="<?php echo $no;?>" onClick="analyseMenu(<?php echo $no;?>)"><?php echo $rub['stocki_nom'];?></td>
			</tr>
		<?php } ?>
		</table>
	</div>

</body>
</html>
