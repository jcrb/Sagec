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
//	programme: 		biotox_menu.php	
//	date de cr�ation: 	31/01/2004	
//	auteur:			jcb
//	description:
//	version:		1.0
//	maj le:			31/01/2004
// 
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION["langue"];

include("../utilitaires/table.php");
include("../html.php");
require '../utilitaires/globals_string_lang.php';

print("<html>");
print("<head>");
print("<title> Menu Biotox </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM NAME=\"biotox_menu\">");
// TITRE
TblDebut(0,"100%");
	TblDebutLigne();
	TblCellule(Image('../images/SAMU.jpeg',50,50));
	//TblCellule("<B>Syst�me d'Aide � la Gestion d'Ev�nements Catastrophiques</B>",1,1,"TITRE");
	//$titre = $string_lang['SAGEC67'][$langue];
	TblCellule("<B> SAGEC - BIOTOX</B>",1,1,"TITRE");
	TblCellule("SAMU 67",1,1);
	TblFinLigne();
TblFin();
//print("<hr>");// barre horizontale	
TblDebut(0,"100%",0);
$_style = "A2";
	TblDebutLigne("$_style");
		$mot = strToUpper($string_lang['CARTOGRAPHIE'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"../carte_lecteur.php\"><B>$mot</B></a>");
		TblCellule("<div align=\"center\"><a href=\"../biotox/biotox_main.php\"><B>BIOTOX</B></a>");
		//$mot = strToUpper($string_lang['INTERVENANTS'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"stock_frameset.php\"><B>MAJ du mat�riel</B></a>");
		//$mot = strToUpper($string_lang['VECTEURS'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"biotox_inventaire.php\"><B>Etat des stocks</B>");
		//TblCellule("<div align=\"center\"><a href=\"test.php\"><B>Test</B>");
		$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"../sagec67.php\"><B>$mot</B>");
	TblFinLigne();
	TblDebutLigne();
		print("<hr>");// barre horizontale
	TblFinLigne();
TblFin();
print("<hr>");// barre horizontale
print("</body>");
print("</html>");
?>
