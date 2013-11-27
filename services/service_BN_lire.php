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
//	programme: 		blocnote_lire.php							//
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
$_style = "A2";
	TblDebutLigne("$_style");
		TblCellule("<B>n°</B>");
		$mot = $string_lang['DATE'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['EXPEDITEUR'][$langue];TblCellule("<B>$mot</B>");
		$mot = $string_lang['MESSAGE'][$langue];TblCellule("<B>$mot</B>");
	TblFinLigne();
	$_style = "A5";
	
	$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
	$requete="SELECT LBS_ID,LBS_Date,LBS_Expediteur,LBS_Message,nom
		FROM livrebord_service,utilisateurs
		WHERE LBS_Expediteur = ID_utilisateur
		AND livrebord_service.org_ID = '$_SESSION[organisation]'
		ORDER BY LBS_Date DESC";
	$result = ExecRequete($requete,$connect);
	while($i = LigneSuivante($result))
	{
		if($_style=="A5")$_style="A6";
		else $_style="A5";
		TblDebutLigne("$_style");
		TblCellule("$i->LBS_ID");
		TblCellule("$i->LBS_Date");
		TblCellule("$i->nom");
		TblCellule("$i->LBS_Message");
		TblFinLigne();
	}
	TblFin();
?>
