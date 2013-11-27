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
*	programme 			blocnote_pds_lire.php
*	@date de création: 	05/11/2006
*	@author:			jcb
*	description:		lit le contenu du bloc note commun à la PDS
*	@version:			1.0 - $ $
*	maj le:				05/11/2006
*	@package			Sagec
*/													
//--------------------------------------------------------------------------------------------------------
// la liste s'affiche par ordre cronologique inverse
// la liste est rafraichie toutes les 30 secondes
// le nom du rédacteur apparait
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require("../html.php");

print("<HTML><HEAD><TITLE>Liste des messages</TITLE>");
//<comment> rafraichissement automatique toutes les 30 secondes </comment>
print("<meta http-equiv=\"refresh\" content=\"30\">");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

TblDebut(0,"100%");
	TblDebutLigne("A1");
	$mot = "Blocnote commun de la PDS";
	TblCellule("<A HREF=\"pds_doc#1.php\">$mot</A>");
	TblCellule("<A HREF=\"blocnote_pds.php\"><b>Nouveau Message</b></A>");
	TblCellule("<A HREF=\"../samu_menu.php\"><b>Retour au menu</b></A>");
	TblFinLigne();
TblFin();

TblDebut(0,"100%");
$_style = "A2";
	TblDebutLigne("$_style");
		TblCellule("<B>n°</B>");
		$mot = $string_lang['DATE'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['EXPEDITEUR'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['MESSAGE'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['MODIFIER'][$langue];TblCellule("<B>$mot</B>");
	TblFinLigne();
	$_style = "A5";

	$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
	$requete="SELECT LB_ID,LB_Date,LB_Expediteur,LB_Message,nom
		FROM livrebord_pds,utilisateurs
		WHERE LB_Expediteur = ID_utilisateur
		ORDER BY LB_Date DESC";
	$result = ExecRequete($requete,$connect);
	$mot = $string_lang['MODIFIER'][$langue];
	while($i = LigneSuivante($result))
	{
		if($_style=="A7")$_style="A8";
		else $_style="A7";
		TblDebutLigne("$_style");
		TblCellule("$i->LB_ID");
		TblCellule("$i->LB_Date");
		TblCellule("$i->nom");
		TblCellule(stripslashes("$i->LB_Message"));
		if(($i->LB_Expediteur == $_SESSION["member_id"]) || ($_SESSION["autorisation"]>4))
		{
			$mot = $string_lang['MODIFIER'][$langue];
			TblCellule("<B><a href=\"blocnote_pds_modifier.php?LB_IDField=$i->LB_ID\">$mot</a></B>");
		}
		else
		{
			$mot = "########";
			TblCellule("<B><a href=\"\">$mot</a></B>");
		}
		TblFinLigne();
		
	}
	TblFin();
?>
