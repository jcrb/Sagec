<?php
/**----------------------------------------- SAGEC ---------------------------------
  * This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
  * SAGEC67 is free software; you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation; either version 2 of the License, or
  * (at your option) any later version.
  * SAGEC67 is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  * You should have received a copy of the GNU General Public License
  * along with SAGEC67; if not, write to the Free Software
  * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */	
/** ---------------------------------------------------------------------------------
  * programme: 			ars_services.php
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
include_once("ars_top.php");
include_once("ars_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
include_once("ars_utilitaires.php");

$dep = "68','67";
$date1 = "1293577200";
$date2 = "1293577200";

$type_service = '2';

$requete = "SELECT lits_journal.lits_dispo,service.service_nom,lits_sp
				FROM lits_journal,service,hopital,adresse,ville,lits
				WHERE service.type_ID IN ('$type_service')
				AND service.priorite_alerte <> 9
				AND lits_journal.service_ID = service.service_ID
				AND service.Hop_ID = hopital.Hop_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID IN('$dep')
				AND lits_journal.date = '$date1'
				AND lits.service_ID = lits_journal.service_ID
				";
				
$resultat = ExecRequete($requete,$connexion);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="dispo_main" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Commentaires </legend>
		<p>
		<table>
				<tr>
					<td>n</td>
					<td>service</td>
					<td>lits dispo</td>
					<td>lits ouverts</td>
					<td>lits occupés</td>
					<td>taux occupation</td>
				</tr>
			<?php 
				$total_lits_ouverts = 0;
				$total_lits_dispo = 0;
				$i = 0;
				while($rep = mysql_fetch_array($resultat)){
					$i++;
					if($rep['lits_dispo'] < 0) $rep['lits_dispo']=0;
					$total_lits_ouverts += $rep['lits_sp'];
					$total_lits_dispo += $rep['lits_dispo'];
					?>
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $rep['service_nom'];?></td>
						<td><?php echo $rep['lits_dispo'];?></td>
						<td><?php echo $rep['lits_sp'];?></td>
						<td><?php echo $rep['lits_sp']-$rep['lits_dispo'];?></td>
						<td><?php
							$taux = round(100*($rep['lits_sp']-$rep['lits_dispo'])/$rep['lits_sp']);
							echo $taux.' %';
							?>
						</td>
					</tr>
			<?php } ?>
			</table>
			<br>
			<table>
				<tr>
					<td>Taux d'occupation moyen</td>
				</tr>
				<tr>
					<td><?php echo round(100*($total_lits_ouverts-$total_lits_dispo)/$total_lits_ouverts).' %'?></td>
				</tr>
			</table>
		</p>
	</fieldset>
	
</div>

<?php
?>

</form>
</body>
</html>