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
  * programme: 			ars_test.php
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
  *	Sélectionne les services d'urgence en fonction du département
  *	renvoie le résultat de la requete sans l'afficher
  *	@data $dep vaut '67','68' ou ('67','68')
  */
function get_sau($dep)
{
	global $connexion;
	$requete = "SELECT service_nom,org_nom
					FROM service, type_service,organisme, ville,adresse, hopital
					WHERE type_service.type_nom = 'SAU'
					AND service.org_ID = organisme.org_ID
					AND service.type_ID = type_service.type_ID
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND ville.departement_ID IN('$dep')
					ORDER BY org_nom
					";
	return ExecRequete($requete,$connexion);
}

/**
  *	Sélectionne les services d'urgence par département
  *	et les regroupe par établissement
  */
function get_sau_par_etablissement($dep)
{
	global $connexion;
	$requete = "SELECT service_nom,org_nom
					FROM service, type_service,organisme, ville,adresse, hopital
					WHERE type_service.type_nom = 'SAU'
					AND service.org_ID = organisme.org_ID
					AND service.type_ID = type_service.type_ID
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND ville.departement_ID IN('$dep')
					GROUP BY organisme.org_ID
					ORDER BY org_nom
					";
	return ExecRequete($requete,$connexion);
}

$d[] = $_REQUEST['d1'];
$d[] = $_REQUEST['d2'];
$dx = implode("','",$d);
$resultat = get_sau($dx);
$resultat2 = get_sau_par_etablissement($dx);

/** nb de jpours écoulés depuis mardi
  * date("w",time()) retourne le jour de la semaine courant sous la forme dimanche = 0, mardi = 2
  * date("w",time())-2 retourne le nb de jours écoulés depuis mardi
  * multiplié par le nb de secondes dans un jour
  * date unix actuelle - nb de secondes écoulées depuis le dernier mardi => date du dernier mardi
  */
$last_mardi = (time()-(date("w",time())-2)*un_jour);
/**
  * une fois que l'on a le dernier mardi, il suffit de retrancher 7 jours
  * pour obtenir la date du mardi précédant
  */
$last_last_mardi = $last_mardi - sept_jour;
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
		<legend> Commentaires </legend>
		<p>
			<label for="ferme">Département :</label>
			67 <input type="checkbox" id="ferme" name="d1" value="67" <?php if($_REQUEST['d1']=='67') echo(' CHECKED')?> /><br>
			68 <input type="checkbox" id="ferme" name="d2" value="68" <?php if($_REQUEST['d2']=='68') echo(' CHECKED')?> />
		</p>
		
		<p>
			<table>
			<?php while($rep=mysql_fetch_array($resultat)){?>
				<tr>
					<td><?php echo ++$i;?></td>
					<td><?php echo Security::db2str($rep[org_nom]);?></td>
					<td><?php echo $rep[service_nom];?></td>
				</tr>
			<?php } ?>
			</table>
		</p>
		
		<p>
			<table>
			<?php $i=0;while($rep=mysql_fetch_array($resultat2)){?>
				<tr>
					<td><?php echo ++$i;?></td>
					<td><?php echo Security::db2str($rep[org_nom]);?></td>
					<td><?php echo $rep[service_nom];?></td>
				</tr>
			<?php } ?>
			</table>
		</p>
		
	</fieldset>
	
	<fieldset id="field1">
		<legend> Commentaires </legend>
		<p>
			<label for="ferme">aujourd'hui :</label>
			<h4><?php echo date("w",time()).'  ';echo uDate2French(time()); ?></h4> 
		</p>
		<p>
			<label for="ferme">mardi dernier :</label>
			<h4><?php echo uDate2French($last_mardi); ?></h4> 
		</p>
		<p>
			<label for="ferme">mardi d'avant :</label>
			<h4><?php echo uDate2French($last_last_mardi); ?></h4> 
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> conversion de dates </legend>
		<p>
			<label for="datex">date :</label>
			<input type="text" name="datex" id="datexu" value="<?php echo $_REQUEST['datex'];?>">
			time Unix <?php echo ':'.fDate2unix($_REQUEST['datex']);?>
		</p>
		<p>
			<label for="dateUnix">date unix:</label>
			<input type="text" name="dateUnix" id="dateUnix" value="<?php echo $_REQUEST['dateUnix'];?>">
			date <?php echo ':'.uDate2French($_REQUEST['dateUnix']);?>
		</p>
	</fieldset>
	
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
</div>

<?php
	/**
	  *	Sélectionne les services d'urgence en fonction du département
	  */
/*
	while($rep=mysql_fetch_array($resultat))
	{
		echo Security::db2str($rep['org_nom']).'  '.$rep['service_nom'].'<br>';
	}
*/
?>

</form>
</body>
</html>