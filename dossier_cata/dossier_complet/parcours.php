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
  * programme: 			parcours.php
  * date de création: 	21/05/2011
  * auteur:					jcb
  * description:			parcours de la victime
  *							Reconstitué à partir de la table victime_gravite
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
$titre_principal = "Dossier complet - Parcours";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
/**
  *	identifiant patient
  */
$id = $_REQUEST['id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Parcours</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="" action= "" method = "post">

<?php
	$victime = $_REQUEST['victime'];
	
	$requete = "SELECT victime.no_ordre FROM victime WHERE victime.victime_ID = '$victime' LIMIT 1";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	$noOrdre = $rub['no_ordre'];

	$requete = "SELECT victime_gravite.heure AS h1,ts_nom,victime_status_nom,evac_ID,gravite_ID,
						TIMEDIFF((SELECT heure AS h2 FROM victime_gravite WHERE victime_ID = '$victime' AND heure > h1 AND localisation_ID > 0 ORDER BY heure LIMIT 1),heure) as h3
					FROM victime_gravite,temp_structure,victime_status
					WHERE victime_gravite.victime_ID = '$victime'
					AND victime_gravite.localisation_ID = ts_ID
					AND  victime_gravite.status_ID = victime_status.victime_status_ID
					ORDER BY heure
					";			
	$resultat = ExecRequete($requete,$connexion);
?>

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Parcours de la victime <?php echo $victime;?> - <?php echo($noOrdre);?></legend>
		<table>
			<tr>
				<th>date heure</th>
				<th>Localisation</th>
				<th>Zone</th>
				<th>Triage</th>
				<th>Départ</th>
				<th>Durée</th>
				<th>Vecteur</th>
			</tr>
			<?php while($rep = mysql_fetch_array($resultat)){?>
			<tr>
				<td><?php echo $rep['h1'];?></td>
				<td><?php echo $rep['ts_nom'];?></td>
				<td><?php echo $rep['victime_status_nom'];?></td>
				<td><?php echo $rep['gravite_ID'];?></td>
				<td><?php echo $rep['h2'];?></td>
				<td><?php echo $rep['h3'];?></td>
				<td><?php echo $rep['evac_ID'];?></td>
			</tr>
			<?php } ?>
		</table>
	</fieldset>

	
</div>

<?php
?>

</form>
</body>
</html>