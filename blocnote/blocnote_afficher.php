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
//													//
//	programme: 		blocnote_afficher.php							//
//	date de création: 	18/08/2003								//
//	auteur:			jcb									//
//	description:		Lire le contenu du bloc-notes						//
//				par ordre chronologique inverse						//
//	version:		1.2									//
//	maj le:			09/04/2004								//
//													//
//--------------------------------------------------------------------------------------------------------
// la liste s'affiche par ordre cronologique inverse
// la liste est rafraichie toutes les 30 secondes
// le nom du rédacteur apparait
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$BackToRoot = "../";
$backPathToRoot = "../";
require_once $backPathToRoot."autorisations/droits.php";
include($backPathToRoot."utilitaires/table.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
include($backPathToRoot."login/init_security.php");
include_once("blocnote_menu2.php");
?>
<HTML>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/sagec67.ico" />
		<TITLE>Liste des messages</TITLE>
		<LINK REL=stylesheet HREF="../pma.css" TYPE ="text/css">
	</HEAD>
	<body>
	<form name="blocnote" method="get" action="blocnote_affiche.php">
<?php

entete("Main courante");
print("<br>");

	$sens = $_REQUEST[sens];
	if($sens==" DESC")$sens = " ASC";else $sens=" DESC";

TblDebut(0,"100%");
$_style = "A2";
	TblDebutLigne("$_style");
		TblCellule("<B><a href=\"blocnote_afficher.php?tri=no&sens=$sens\">n°</a></B>");
		$mot = $string_lang['DATE'][$langue];TblCellule("<B><a href=\"blocnote_afficher.php?tri=date&sens=$sens\">$mot</a></B>");
		$mot = $string_lang['EXPEDITEUR'][$langue];TblCellule("<B><a href=\"blocnote_afficher.php?tri=exp&sens=$sens\">$mot</a></B>");
		$mot = $string_lang['LOCALISATION'][$langue];TblCellule("<B><a href=\"blocnote_afficher.php?tri=loc&sens=$sens\">$mot</a></B>");
		$mot = $string_lang['MESSAGE'][$langue];TblCellule("<B>$mot</B>");
		if(est_autorise("MCS_ECRITURE"))
		{
			$mot = $string_lang['MODIFIER'][$langue];TblCellule("<B>$mot</B>");
		}
	TblFinLigne();
	$_style = "A5";
	
	if($_REQUEST[tri]=="date") $order = "LB_Date";
	else if($_REQUEST[tri]=="exp") $order = "LB_Expediteur";
	else if($_REQUEST[tri]=="loc") $order = "LB_Date";
	else if($_REQUEST[tri]=="no") $order = "LB_ID";
	else $order = "LB_Date";
	
	$requete="SELECT LB_ID,LB_Date,LB_Expediteur,LB_Message,nom,livrebord.org_ID
		FROM livrebord,utilisateurs
		WHERE LB_Expediteur = ID_utilisateur
		AND LB_visible = 'o'
		ORDER BY ".$order.$sens;
	$result = ExecRequete($requete,$connexion);
	while($i = LigneSuivante($result))
	{
		$requete = "SELECT org_nom FROM organisme WHERE organisme.org_ID = $i->org_ID ";
		$resultat2 = ExecRequete($requete,$connexion);
		$rep = mysql_fetch_array($resultat2);
		$organisme = $rep['org_nom'];
		
		$requete = "SELECT ts_nom FROM temp_structure WHERE ts_ID = '$_SESSION[localisation]'";
		$resultat2 = ExecRequete($requete,$connexion);
		$rep = mysql_fetch_array($resultat2);
		$localisation = $rep['ts_nom'];

		if($_style=="A7")$_style="A8";
		else $_style="A7";
		TblDebutLigne("$_style");
		TblCellule("$i->LB_ID");
		TblCellule("$i->LB_Date");
		TblCellule("[".$organisme."] "."$i->nom");
		TblCellule($localisation);
		TblCellule(stripslashes("$i->LB_Message"));
		if(($i->LB_Expediteur == $_SESSION["member_id"]) || (est_autorise("MCS_MODIFICATION")))
		{
			$mot = $string_lang['MODIFIER'][$langue];
			TblCellule("<B><a href=\"bloc_note_modifier.php?LB_IDField=$i->LB_ID\">$mot</a></B>");
		}
		else if(est_autorise("MCS_ECRITURE"))
		{
			$mot = "########";
			TblCellule("<B><a href=\"\">$mot</a></B>");
		}
		if(est_autorise("MCS_ECRITURE"))
		{
			$mot="R";
			TblCellule("<B><a href=\"blocnote_repondre.php?LB_IDField=$i->LB_ID\">$mot</a></B>");
			TblFinLigne();
		}
	}
	TblFin();
?>
</form>
</body>
</html>