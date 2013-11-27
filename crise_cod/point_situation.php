<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
/**												
*	programme: 		blocnote_lire.php							
*	date de création: 	18/08/2003								
*	auteur:			jcb									
*	description:		Lire le contenu du bloc-notes					
*				par ordre chronologique inverse						
*	@version:		$Id: blocnote_lire.php 36 2008-02-22 16:05:49Z jcb $								
*	maj le:			09/04/2004								
*/												
//--------------------------------------------------------------------------------------------------------
// la liste s'affiche par ordre cronologique inverse
// la liste est rafraichie toutes les 30 secondes
// le nom du rédacteur apparait
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "COD - Points de situation";
include_once("cc_top.php");
include_once("cc_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
$langue = $_SESSION['langue'];

include("../utilitaires/table.php");
//require '../utilitaires/globals_string_lang.php';
//require("../pma_connect.php");
//require("../pma_connexion.php");
//require '../utilitaires/requete.php';
//require("../html.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>point de situation</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	<meta http-equiv="refresh" content="30">
</head>

<?php

if(isset($_GET['back'])) $back = $_GET['back'];
else $back = "sagec67.php";
?>

<table>
	<tr>
		<td><a href="point_situation.php">Points de situation</a></td>
		<td><a href="point_situation_nouveau.php"><b>Nouveau Point</b></a></td>
		<?php if($_SESSION['autorisation']>0)?>
			<td><a href="blocnote_lire.php">Sauvegarder</a></td>
	</tr>
</table>

<table>
	<tr>
		<th style="width:5%"><B>n°</B></th>
		<th style="width:10%"><b><?php echo $string_lang['DATE'][$langue];?></b></th>
		<th style="width:10%"><b><?php echo $string_lang['EXPEDITEUR'][$langue];?></b></th>
		<th style="width:50%"><b><?php echo $string_lang['MESSAGE'][$langue];?></b></th>
		<th style="width:5%"><b><?php echo $string_lang['MODIFIER'][$langue];?></b></th>
		
	</tr>
<?php
	$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
	$requete="SELECT LBS_ID,LBS_Date,LBS_Expediteur,LBS_Message,nom
		FROM livrebord_service,utilisateurs
		WHERE LBS_Expediteur = ID_utilisateur
		AND LBS_groupe = 3
		AND LBS_visible = 'o'
		ORDER BY LBS_Date DESC";
		
	$requete = "SELECT *
					FROM points_situation
					";
					
	$result = ExecRequete($requete,$connect);
	$mot = $string_lang['MODIFIER'][$langue];
	while($i = LigneSuivante($result))
	{
		if($_style=="A7")$_style="A8";
		else $_style="A7";
		TblDebutLigne("$_style");
		TblCellule("$i->point_ID");
		TblCellule("$i->date");
		TblCellule("$i->auteur");
		?>
		<td><div align="left"><?php echo Security::db2str($i->contenu);?></div></td>
		<?php
		TblCellule("<B><a href=\"bloc_note_modifier.php?LB_IDField=$i->LBS_ID\">$mot</a></B>");
		TblFinLigne();
	}
	?>
</table>
