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
  * programme: 			ars_sau.php
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
require($backPathToRoot."date.php");

/**
  * pour test
  */
  
  $date1 = '1287612000';
  $date2 = '1292540400';
  $d1 = fDate2unix($_REQUEST['date1']);
  $d2 = fDate2unix($_REQUEST['date2']);
  if($d1 > $date1 && $d1 < $date2) $date1 = $d1;else $date1 = '1287612000';
  if($d2 > $date1 && $d2 < $date2) $date2 = $d2;else $date2 = '1292540400';

/**
  *	Sélectionne les services d'urgence en fonction du département
  *	renvoie le résultat de la requete sans l'afficher
  *	@data $dep vaut '67','68' ou ('67','68')
  *	Utilise la table veille_SAU
  */
function get_sau($dep)
{
	global $connexion;
	$requete = "SELECT service_nom,org_nom,SUM(passage) as passage,SUM(inf_1an) as junior, SUM(sup_75an) as senior, SUM(hosp) as hosp
					FROM service, type_service,organisme, ville,adresse, hopital, veille_SAU
					WHERE type_service.type_nom = 'SAU'
					AND service.org_ID = organisme.org_ID
					AND service.type_ID = type_service.type_ID
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND ville.departement_ID IN('$dep')
					AND date BETWEEN '2008-04-19' AND '2008-04-20'
					AND veille_SAU.service_ID = service.service_ID
					GROUP BY organisme.org_ID
					ORDER BY org_nom
					";
	return ExecRequete($requete,$connexion);
}

/**
  *	Sélectionne les services d'urgence en fonction du département
  *	renvoie le résultat de la requete sans l'afficher
  *	@data $dep vaut '67','68' ou ( (attention ce n'est pas la même que supra)'67','68')
  *	Utilise la table veille_sau
  *	Renvoie la moyenne de passage
  */
function get_sau_moy($dep,$date1,$date2)
{
	global $connexion;
	$requete = "SELECT service_nom,org_nom,AVG(entre1_75) as passage,AVG(inf_1_an) as junior, AVG(sup_75_an) as senior, AVG(hospitalise) as hosp
					FROM service, type_service,organisme, ville,adresse, hopital, veille_sau
					WHERE type_service.type_nom = 'SAU'
					AND service.org_ID = organisme.org_ID
					AND service.type_ID = type_service.type_ID
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND ville.departement_ID IN('$dep')
					AND date BETWEEN '$date1' AND '$date2'
					AND veille_sau.service_ID = service.service_ID
					GROUP BY organisme.org_ID
					ORDER BY org_nom
					";
	return ExecRequete($requete,$connexion);
}

/**
  *	Sélectionne les services d'urgence en fonction du département
  *	et les regrouppe par établissements.
  *	renvoie le résultat de la requete sans l'afficher
  *	@data $dep vaut '67','68' ou ( (attention ce n'est pas la même que supra)'67','68')
  *	Utilise la table veille_sau
  */
function get_sau2($dep,$date1,$date2)
{
	global $connexion;
	$requete = "SELECT service_nom,org_nom,SUM(entre1_75) as passage,SUM(inf_1_an) as junior, SUM(sup_75_an) as senior, SUM(hospitalise) as hosp
					FROM service, type_service,organisme, ville,adresse, hopital, veille_sau
					WHERE type_service.type_nom = 'SAU'
					AND service.org_ID = organisme.org_ID
					AND service.type_ID = type_service.type_ID
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND ville.departement_ID IN('$dep')
					AND date BETWEEN '$date1' AND '$date2'
					AND veille_sau.service_ID = service.service_ID
					GROUP BY organisme.org_ID
					ORDER BY org_nom
					";
	return ExecRequete($requete,$connexion);
}

$d[] = $_REQUEST['d1'];
$d[] = $_REQUEST['d2'];
$dx = implode("','",$d);
$resultat = get_sau2($dx,$date1,$date2);
$resultat2 = get_sau_moy($dep,$date1,$date1-7*24*60*60);
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

<form name="dispo_main" action= "" method = "get">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Passages aux urgences </legend>
		<p>
			<label for="ferme">Département :</label>
			67 <input type="checkbox" id="ferme" name="d1" value="67" <?php if($_REQUEST['d1']=='67') echo(' CHECKED')?> /><br>
			68 <input type="checkbox" id="ferme" name="d2" value="68" <?php if($_REQUEST['d2']=='68') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="ferme">Date 1 :</label>
			<input type="text" name = "date1" value="<?php echo uDate2French($date1);?>">
		</p>
		<p>
			<label for="ferme">Date 2 :</label>
			<input type="text" name = "date2" value="<?php echo uDate2French($date2);?>">
		</p>
		<p>
			<table>
				<tr>
					<th>n°</th>
					<th>Etablissement</th>
					<!-- <th>service</th> -->
					<th>Passages</th>
					<th>< 1 an</th>
					<th>> 75 ans</th>
					<th> % > 75 ans</th>
					<th>1 à 75 ans</th>
					<th>hospitalisations</th>
					<th>% hospitalisation</th>
				</tr>
			<?php while($rep=mysql_fetch_array($resultat)) {?>
				<tr>
					<td><?php echo ++$i;?></td>
					<td><?php echo Security::db2str($rep['org_nom']);?></td>
					<!-- <td><?php echo $rep['service_nom'];?></td> -->
					<!-- valeurs -->
					<td><?php echo $rep['passage'];?></td>
					<td><?php echo $rep['junior'];?></td>
					<td><?php echo $rep['senior'];?></td>
					<td><?php echo round($rep['senior']*100/$rep['passage']).' %';?></td>
					<td><?php echo $rep['passage']-$rep['junior']-$rep['senior'];?></td>
					<td><?php echo $rep['hosp'];?></td>
					<td><?php echo round($rep['hosp']*100/$rep['passage']).' %';?></td>
				</tr>
			<?php } ?>
			</table>
		</p>
	</fieldset>
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
</div>

<?php
?>

</form>
</body>
</html>
