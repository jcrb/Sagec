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
//----------------------------------------- SAGEC --------------------------------------------------------
//													//
//	programme: 		vecteur_menu.php							//
//	date de création: 	18/08/2003								//
//	auteur:			jcb									//
//	description:											//
//	version:		1.0									//
//	maj le:			24/08/2003								//
//													//
//---------------------------------------------------------------------------------------------------------
include("utilitaires/table.php");
include("html.php");

function MenuVecteurs($langue,$chemin="")
{
require 'utilitaires/globals_string_lang.php';
print("<html>");
print("<head>");
print("<title> Gestion des vecteurs </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");		

// TITRE
TblDebut(0,"100%");
	TblDebutLigne();
	TblCellule(Image($chemin.'images/SAMU.jpeg',50,50));
	$mot=$string_lang['GESTION_VECTEURS'][$langue];
	TblCellule("<B>$mot</B>",1,1,"TITRE");
	TblCellule("SAMU 67",1,1);
	TblFinLigne();
TblFin();

print("<hr>");// barre horizontale	
TblDebut(0,"100%",0);
$_style = "A2";
	TblDebutLigne("$_style");
		$mot = StrToUpper($string_lang['LISTE'][$langue]);
		$destination= $chemin."vecteur_liste.php";
		TblCellule("<div align=\"center\"><a href=\"$destination\"><B>$mot</B></a>");
		$mot = StrToUpper($string_lang['SELECTION'][$langue]);
		$destination= $chemin."vecteurs_selection.php";
		TblCellule("<div align=\"center\"><a href=\"$destination\"><B>$mot</B></a>");
		$mot = StrToUpper($string_lang['MOYENS_DISPONIBLES'][$langue]);
		$destination= $chemin."vecteur_dispo.php";
		TblCellule("<div align=\"center\"><a href=\"$destination\"><B>$mot</B></a>");
		$mot = StrToUpper($string_lang['MOYENS_ENGAGES'][$langue]);
		$destination= $chemin."vecteur/vecteur_engages.php";
		TblCellule("<div align=\"center\"><a href=\"$destination\"><B>$mot</B></a>");// vecteur_engages.php
		$mot = StrToUpper($string_lang['MAJ'][$langue]);
		$destination= $chemin."vecteurs_maj.php";
		TblCellule("<div align=\"center\"><a href=\"$destination\"><B>$mot</B></a>");

		$mot = StrToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
		$destination= $chemin."sagec67.php";
		TblCellule("<div align=\"center\"><a href=\"$destination\"><B>$mot</B>");
	TblFinLigne();
TblFin();		
print("<hr>");// barre horizontale
print("<div align=\"left\">");
print("</div>");
print("</body>");
print("</html>");
}
?>
