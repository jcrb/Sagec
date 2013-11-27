<?php
//----------------------------------------- SAGEC --------------------------------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//----------------------------------------- SAGEC --------------------------------------------------------
//																										 //
//	programme: 			moyens_commune_menu.php																	 	 //
//	date de création: 	05/10/2003																		 //
//	auteur:				jcb																				 //
//	description:											 											 //
//	version:			1.0																				 //
//	maj le:				05/10/2003																		 //
//																										 //
//---------------------------------------------------------------------------------------------------------
include("utilitaires/table.php");
include("html.php");

function MenuCommunes($langue)
{
require 'utilitaires/globals_string_lang.php';
print("<html>");
print("<head>");
print("<title> Gestion des moyens d'une commune' </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

// TITRE
/*
TblDebut(0,"100%");
	TblDebutLigne();
	TblCellule(Image('images/SAMU.jpeg',50,50));
	//$mot=$string_lang['GESTION_VECTEURS'][$langue];
	$mot="Gestion des moyens d'une commune";
	TblCellule("<B>$mot</B>",1,1,"TITRE");
	TblCellule("SAMU 67",1,1);
	TblFinLigne();
TblFin();
*/
print("<hr>");// barre horizontale
TblDebut(0,"100%",0);
$_style = "A2";
	TblDebutLigne("$_style");
		//$mot = StrToUpper($string_lang['LISTE'][$langue]);
		$mot = strToUpper($string_lang['COMMUNE'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"moyens_commune.php\"><B>$mot</B></a>");
		$mot = StrToUpper($string_lang['CARTOGRAPHIE'][$langue]);
		//TblCellule("<div align=\"center\"><a href=\"apa_zone.php\"><B>$mot</B></a>");
		TblCellule("<div align=\"center\"><a href=\"carte_secteurs.php?back=moyens_commune.php&secteur_ID=10\"><B>$mot</B></a>");
		$mot = StrToUpper("Secteurs");
		TblCellule("<div align=\"center\"><a href=\"secteurs_synoptique.php\"><B>$mot</B></a>");
		$mot = StrToUpper("Commune/secteur");
		TblCellule("<div align=\"center\"><a href=\"communes_par_secteur.php\"><B>$mot</B></a>");
		$mot = StrToUpper("Administrer les tables");
		TblCellule("<div align=\"center\"><a href=\"commune/commune_test.php\"><B>$mot</B></a>");
		/*
		$mot = StrToUpper($string_lang['MOYENS_ENGAGES'][$langue]);
		//vecteur_engage.php
		$mot = StrToUpper($string_lang['MAJ'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"vecteurs_maj.php\"><B>$mot</B></a>");
		*/
		$mot = StrToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"samu_menu.php\"><B>$mot</B>");
	TblFinLigne();
TblFin();
print("<hr>");// barre horizontale
print("<div align=\"left\">");
print("</div>");
print("</body>");
print("</html>");
}
?>
