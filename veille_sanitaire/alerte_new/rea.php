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
  * programme: 			rea.php
  * date de crÃ©ation: 	03/08/2012
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
$titre_principal = "Point de situation - Réanimations";
$sousmenu = "";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Point  de situation</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href= "<?php echo $backPathToRoot;?>images/sagec67.ico" />
	<!--<script  type="text/javascript" src= "<?php echo $backPathToRoot;?>utilitaires.js"></script>-->
	
	<link rel="stylesheet" href="../../js/css/jquery.dataTables.css" />
	<script src="../../js/jquery.js"></script>
	<script src="../../js/jquery.dataTables.min.js"></script>
	<script src="startDataTables.js"></script>
</head>

<body onload="">
	<?php
	
		$dates = 1209852000;
		$dates2 = $dates + sept_jour;
		/*
			Sélectionne les lits(lits.service_ID) des services de rea (service.Type_ID=2) en activité (service.Priorite_Alerte != 9),
			le nom de l'hopital hébergeant ces services, en région Alsace(ville.region_ID = '42')
		*/
		$requete = "SELECT Hop_nom,hopital.Hop_ID, departement_ID,service_nom,lits_sp,lits_journal.lits_dispo
						FROM hopital,adresse,ville,service,lits,lits_journal
						WHERE service.Type_ID = 2
						AND service.Priorite_Alerte != 9
						AND lits.service_ID = service.service_ID
						AND service.Hop_ID = hopital.Hop_ID
						AND lits_journal.service_ID = service.service_ID
						AND lits_journal.date = '$dates'
						AND hopital.adresse_ID = adresse.ad_ID
						AND adresse.ville_ID = ville.ville_ID
						AND ville.region_ID = '42'
						ORDER BY ville.departement_ID
						";
		/**
			Sélectionne les services de réanimation d'Alsace
			Pour chacun calcule le nb moyen de lits disponibles sur 8 jours
		*/				
		$requete = "SELECT Hop_nom,hopital.Hop_ID, departement_ID,service_nom,d.service_ID,lits_sp,
						(SELECT AVG(lits_journal.lits_dispo)
							FROM lits_journal,service e
							WHERE lits_journal.date BETWEEN '$dates' AND '$dates2'
							AND lits_journal.service_ID = e.service_ID
							AND e.Priorite_Alerte != 9
							AND e.service_ID = d.service_ID
							) AS ld
						FROM hopital,adresse,ville,service d,lits
						WHERE d.Type_ID = 2
						AND d.Priorite_Alerte != 9
						AND lits.service_ID = d.service_ID
						AND d.Hop_ID = hopital.Hop_ID
						AND hopital.adresse_ID = adresse.ad_ID
						AND adresse.ville_ID = ville.ville_ID
						AND ville.region_ID = '42'
						";
		/**
			fait la somme des lits de réanimation adulte en Alsace
		*/				
		$requete2 = "SELECT SUM(lits_sp)AS lits_autorise,
							(SELECT SUM(lits_journal.lits_dispo)
							 FROM lits_journal,service e
							 WHERE lits_journal.date BETWEEN '$dates' AND '$dates2'
							 AND lits_journal.service_ID = e.service_ID
							 AND e.Type_ID = 2
							 AND e.service_ID = d.service_ID
							)AS lits_vacants
						FROM lits, adresse,hopital,ville,service d
						WHERE d.Type_ID = 2
						AND d.Priorite_Alerte != 9
						AND lits.service_ID = d.service_ID
						AND d.Hop_ID = hopital.Hop_ID
						AND hopital.adresse_ID = adresse.ad_ID
						AND adresse.ville_ID = ville.ville_ID
						AND ville.region_ID = '42'
						";
		/**
			Lits de réa en Alsace disponibles sur 8 jours
		*/				
		$requete2 = "SELECT AVG(lits_journal.lits_dispo)AS lits_vacants
						 FROM lits_journal,service,adresse,hopital,ville
						 WHERE lits_journal.date BETWEEN '$dates' AND '$dates2'
						 AND lits_journal.service_ID = service.service_ID
						 AND service.Type_ID = 2
						AND service.Priorite_Alerte != 9
						AND service.Hop_ID = hopital.Hop_ID
						AND hopital.adresse_ID = adresse.ad_ID
						AND adresse.ville_ID = ville.ville_ID
						AND ville.region_ID = '42'
						";
						
		$reponse = ExecRequete($requete2,$connexion);
		$lits_tot = 0;
	?>
	<p>date1: <?php echo uDate2French($dates);?></p>
	<p>date2: <?php echo uDate2French($dates2);?></p>
	
	<?php
		while($rub = mysql_fetch_array($reponse)) {
			echo $rub['lits_autorise'].' - '.$rub['lits_vacants'];
		}
	?>
	
	<div id = "table" width="80%">
		<fieldset id="">
		<table id="table_hop" >  <!-- width="100%"  style="table-layout:fixed" -->
		<thead>
			<tr>
				<th>Hôpital</th>
				<th>Identifiant</th>
				<th>Service</th>
				<th>Service ID</th>
				<th>Lits</th>
				<th>Lits disponibles</th>
				<th>Département</th>
			</tr>
		</thead>
		<tboby>
			<?php while($rub = mysql_fetch_array($reponse)){?>
			<tr>
				<td><?php echo Security::db2str($rub['Hop_nom']);?></td>
				<td><?php echo $rub['Hop_ID'];?></td>
				<td><?php echo $rub['service_nom'];?></td>
				<td><?php echo $rub['service_ID'];?></td>
				<td><?php echo $rub['lits_sp'];?></td>
				<td><?php echo $rub['ld'];?></td>
				<td><?php echo $rub['departement_ID'];?></td>
			</tr>
			<?php $lits_tot += $rub['lits_sp'];} ?>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><b>Total:</b></td>
				<td><b><?php echo $lits_tot;?></b></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</tboby>
		</table>
	</div>

</form>
</body>
</html>
