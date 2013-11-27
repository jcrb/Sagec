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
//
//	programme: 		menu_sagec.php
//	date de création: 	15/08/2003
//	auteur:			jcb
//	description:		Regroupe l'ensemble des menus de sagec
//	version:			1.0
//	maj le:			31/08/2003
//
//---------------------------------------------------------------------------------------------------------
//
include("utilitaires/table.php");
include("html.php");

//===================================== Générique =========================================================

function menu_head($titre)
{
	require 'utilitaires/globals_string_lang.php';
	TblDebut(0,"100%");
	TblDebutLigne();
	TblCellule(Image('images/SAMU.jpeg',50,50));
	TblCellule("<B>$titre</B>",1,1,"TITRE");
	TblCellule("SAMU 67",1,1);
	TblFinLigne();
	TblFin();
	print("<hr>");// barre horizontale
}
//===================================== LITS ==============================================================
function MenuLits($langue)
{
	require 'utilitaires/globals_string_lang.php';
	//print("<html>");
	//print("<head>");
	//print("<title> Gestion des Lits </title>");
	//print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
	//print("</head>");

	// TITRE
	$mot = $string_lang['GESTION_LITS'][$langue];
	menu_head($mot);

	TblDebut(0,"100%",0);
	$_style = "A2";
	TblDebutLigne("$_style");
		//$mot = strToUpper($string_lang['HOPITAUX'][$langue]);
		//TblCellule("<div align=\"center\"><a href=\"lits_maj.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['LITS'][$langue]."/".$string_lang['HOPITAL'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"lits_service.php\"><B>$mot</B></a>");
		//$mot = strToUpper($string_lang['SERVICE'][$langue]);
		//TblCellule("<div align=\"center\"><a href=\"service_table.php\"><B>$mot</B></a>");
		//$mot = strToUpper($string_lang['LITS'][$langue]);
		//TblCellule("<div align=\"center\"><a href=\"lits_table.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['SYNOPTIQUE'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"lits_synoptique.php\"><B>$mot</B></a>");

		//$mot = strToUpper($string_lang['SYNOPTIQUE'][$langue]);
		$mot = "Mises à jour";
		TblCellule("<div align=\"center\"><a href=\"gestion_des_lits.php\"><B>$mot</B></a>");

		$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"sagec67.php\"><B>$mot</B>");
	TblFinLigne();
	TblFin();
	print("<hr>");// barre horizontale
	//print("<div align=\"left\">");
	//print("</div>");
	//print("</body>");
	//print("</html>");
}

function gestion_des_lits($langue)
{
	require 'utilitaires/globals_string_lang.php';
	$mot = $string_lang['GESTION_LITS'][$langue];
	menu_head($mot);
	TblDebut(0,"100%",0);
	$_style = "A2";
	TblDebutLigne("$_style");
	$mot = strToUpper($string_lang['HOPITAUX'][$langue]);
	TblCellule("<div align=\"center\"><a href=\"lits_maj.php\"><B>$mot</B></a>");
	$mot = strToUpper($string_lang['SERVICE'][$langue]);
	TblCellule("<div align=\"center\"><a href=\"service_table.php\"><B>$mot</B></a>");
	$mot = strToUpper($string_lang['LITS'][$langue]);
	TblCellule("<div align=\"center\"><a href=\"lits_table.php\"><B>$mot</B></a>");
	$mot = strToUpper($string_lang['SYNOPTIQUE'][$langue]);
	$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
	TblCellule("<div align=\"center\"><a href=\"lits_disponibles.php\"><B>$mot</B>");
	TblFinLigne();
	TblFin();
	print("<hr>");// barre horizontale
}

function menu_maj_des_lits($langue)
{
	require 'utilitaires/globals_string_lang.php';
	print("<html>");
	print("<head>");
	print("<title> Mise à jour des Lits </title>");
	print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
	print("</head>");
	
	TblDebut(0,"100%");
	TblDebutLigne();
	TblCellule(Image('images/SAMU.jpeg',50,50));
	$mot = $string_lang['GESTION_LITS'][$langue];
	TblCellule("<B>$mot</B>",1,1,"TITRE");
	TblCellule("SAMU 67",1,1);
	TblFinLigne();
	TblFin();

	print("<hr>");// barre horizontale
	TblDebut(0,"100%",0);
	$_style = "A2";
	TblDebutLigne("$_style");
		$mot = strToUpper($string_lang['HOPITAUX'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"hop_maj.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['SERVICE'][$langue]." (".$mot = $string_lang['MAJ'][$langue].")");
		TblCellule("<div align=\"center\"><a href=\"service_maj.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"gestion_des_lits.php\"><B>$mot</B>");
	TblFinLigne();
	TblFin();
	print("<hr>");// barre horizontale
	print("<div align=\"left\">");
	print("</div>");
	print("</body>");
	print("</html>");
}
//================================================ SAMU ========================================================
function menu_regulation($langue)
{
	require 'utilitaires/globals_string_lang.php';
	print("<hr>");// barre horizontale
	TblDebut(0,"100%",0);
	$_style = "A2";
	TblDebutLigne("$_style");
		//$mot = strToUpper($string_lang['HOPITAUX'][$langue]);
		$mot="ASSU CUS";
		TblCellule("<div align=\"center\"><a href=\"tr_cus/tourDeRole_frameset.php\"><B>$mot</B></a>");
		$mot="COMMUNES";
		TblCellule("<div align=\"center\"><a href=\"moyens_commune.php\"><B>$mot</B></a>");
		$mot="TOXIQUES";
		TblCellule("<div align=\"center\"><a href=\"chimie/recherche_produit.php\"><B>$mot</B></a>");
		$mot="CARTOGRAPHIE";
		TblCellule("<div align=\"center\"><a href=\"carto2/carto_frameset.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"sagec67.php\"><B>Menu</B>");
	TblFinLigne();
	TblFin();
}
?>
