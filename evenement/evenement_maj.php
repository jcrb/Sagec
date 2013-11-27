<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
//----------------------------------------- SAGEC ---------------------------------------------//
/**
//	programme: 			evenement_maj.php
//	date de cr�ation: 	12/11/2004
//	@author:			jcb
//	description:
//	@version:			1.0 - $Id: evenement_maj.php 10 2006-08-17 22:41:56Z jcb $
//	maj le:				14/08/2006
*/
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>8) header("Location:../logout.php");
$backPathToRoot = "../";
include("evenement_routines.php");
//require($backPathToRoot."pma_connect.php");
require $backPathToRoot.'login/init_security.php';
include($backPathToRoot."html.php");
require($backPathToRoot."pma_connexion.php");
require $backPathToRoot.'utilitaires/requete.php';
require $backPathToRoot.'utilitaires/liste.php';
$connect = $connexion;

?>
<html>
<head>
	<title> Ev�nement MAJ </title>
	<meta name="author" content="jcb">
	<LINK REL=stylesheet HREF="../pma.css" TYPE ="text/css">
	<style type="text/css">
		table.sample {
		border-width: 0px 0px 0px 0px;
		border-spacing: 2px;
		border-style: outset outset outset outset;
		border-color: gray gray gray gray;
		border-collapse: separate;
		background-color: white;
		}
		table.sample th {
		border-width: 1px 1px 1px 1px;
		padding: 1px 1px 1px 1px;
		border-style: outset outset outset outset;
		border-color: blue blue blue blue;
		background-color: rgb(255, 255, 240);
		-moz-border-radius: 3px 3px 3px 3px;
		}
		table.sample td {
		border-width: 1px 1px 1px 1px;
		padding: 1px 1px 1px 1px;
		border-style: outset outset outset outset;
		border-color: blue blue blue blue;
		background-color: rgb(255, 255, 240);
		-moz-border-radius: 3px 3px 3px 3px;
		}
	</style>
</head>

<body>
	<form action ="evenement_maj.php" METHOD="POST">
	<?php
	if($_REQUEST['ok']=='MAJ')
	{
		$requete = "SELECT * FROM evenement WHERE evenement_ID = '$_REQUEST[ev_courant]'";
		//$requete = "SELECT * FROM evenement WHERE evenement_actif = 'en cours'";
		$resultat = ExecRequete($requete,$connect);
		$rub=mysql_fetch_array($resultat);
		// on enregistre dans un champ cach� la valeur de l'�v�nement courant pr�c�dant
		print("<input type=\"hidden\" name=\"ev_courant\" value=\"$_REQUEST[ev_courant]\">");
		echo 'maj';
	?>
	<table>
		<tr>
			<td>Ev�nement courant</td>
			<td><input type="text" name="titre" value="<?php echo $rub[evenement_nom];?>" size="50"></td>
			<td><input type="submit" name="ok" value="Valider"></td>
		</tr>
		<tr>
			<td>Type incident</td>
			<td><?php select_generique('incident_type','type_ID','typeID','type_nom',$item_select);?></td> <!-- // retourne typeID-->
			<td>Sous Type</td>
			<td><?php select_generique('incident_soustype','stype_ID','stypeID','stype_nom',$item_select);?></td><!--// retourne stypeID-->
		</tr>
		<tr>
			<td>Cat�gorie</td>
			<td><?php select_generique('incident_categorie','categorie_ID','categorieID','categorie_nom',$item_select);?></td><!--// retourne categorieID -->
		</tr>
		<tr>
			<td>Certitude</td>
			<td><?php select_generique('incident_certitude','certitude_ID','certitudeID','certitude_nom',$item_select);?></td><!-- // retourne certitudeID-->
		</tr>
		<tr>
			<td>Gravit�</td>
			<td><?php select_generique('incident_gravite','gravite_ID','graviteID','gravite_nom',$item_select);?></td><!-- // retourne graviteID-->
		</tr>
		<tr>
			<td>Niveau</td>
			<td><?php select_generique('incident_niveau','niveau_ID','niveauID','niveau_nom',$item_select);?></td><!--  // retourne niveauID-->
		</tr>
		<tr>
			<td>S�v�rit�</td>
			<td><?php select_generique('incident_severite','severite_ID','severiteID','severite_nom',$item_select);?> </td><!--  // retourne severiteID-->
		</tr>
		<tr>
			<td>Phase</td>
			<td><?php select_generique('incident_phase','phase_ID','phaseID','phase_nom',$item_select); ?> </td><!--// retourne phaseID -->
		</tr>
		<tr>
			<td>Status</td>
			<td><?php select_generique('incident_status','status_ID','statusID','status_nom',$item_select); ?> </td><!--// retourne statusID -->
		</tr>
		<tr>
			<td></td>
			<td><?php ?></td><!-- -->
		</tr>
	</table>
	<?php } 
	//================================== MAJ ===============================================
elseif($_REQUEST['ok']=='Valider')
{
	$titre = Security::esc2Db($_REQUEST['titre']);
	$date1 = Security::esc2Db($_REQUEST['date1']);
	$heure1 = Security::esc2Db($_REQUEST['heure1']);
	$date2 = Security::esc2Db($_REQUEST['date2']);
	$heure2 = Security::esc2Db($_REQUEST['heure2']);
	$samu = Security::esc2Db($_REQUEST['dossier_samu']);
	$sdis = Security::esc2Db($_REQUEST['dossier_sdis']);
	$comment = Security::esc2Db($_REQUEST['comment']);
	$actif = Security::esc2Db($_REQUEST['actif']);
	$maj = date("Y-m-j H:i:s");
	$ppi = Security::esc2Db($_REQUEST['ppi_id']);
	$plans_array =  Security::esc2Db($_REQUEST['plans_id']);
	
	$requete = "UPDATE evenement SET
					evenement_nom = '$titre',
					evenement_date1 = '$date1',
					evenement_heure1 = '$heure1',
					evenement_date2 = '$date2',
					evenement_heure2 = '$heure2',
					last_update = '$maj',
					evenement_actif = '$actif',
					dossier_samu= '$samu',
					dossier_sdis = '$sdis',
					comment = '$comment'
				WHERE evenement_ID = $_REQUEST[ev_courant]";
	//$resultat = ExecRequete($requete,$connect);
	//================================== CHOIX ===============================================
	else
	{
	// liste des �v�nements actifs
		$requete = "SELECT evenement_ID, evenement_nom FROM evenement WHERE evenement_actif = 'oui'";
		$resultat = ExecRequete($requete,$connect);
		print("Ev�nement � modifier <SELECT name=\"ev_courant\" size=\"5\">");
		while($rub=mysql_fetch_array($resultat))
		{
			print("<option value=\"$rub[evenement_ID]\"> $rub[evenement_nom]</option>");
		}
		print("</SELECT>");
		print("<br><input type=\"submit\" name=\"ok\" value=\"MAJ\">");
	}
	?>
	</form>
</body>
</html>
