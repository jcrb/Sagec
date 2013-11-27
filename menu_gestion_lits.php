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
/**
*	programme: 		menu_gestion_lits.php
*	description:	en-tête gestion services, hôpitaux et UF
*	date de création: 	15/08/2003
*	@author:			jcb
*	@version:		$Id: menu_gestion_lits.php 32 2008-02-17 15:14:17Z jcb $
*	maj le:			16/02/2008
*/
//---------------------------------------------------------------------------------------------------------
//
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
include_once("utilitaires/table.php");
include_once("html.php");

function menu_lits($langue, $titre="SAGEC 67")
{
	require 'utilitaires/globals_string_lang.php';
	//$titre = $string_lang['GESTION_LITS'][$langue];
	$mot = strToUpper($string_lang['LITS'][$langue]."/".$string_lang['HOPITAL'][$langue]);
	$m1 = "<a href=\"lits_service.php\"><B>$mot</B></a>";
	$mot = strToUpper($string_lang['SYNOPTIQUE'][$langue]);
	$m2 = "<a href=\"lits_synoptique.php\"><B>$mot</B></a>";
	$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
	$m3 = "<a href=\"lits_disponibles.php\"><B>$mot</B>";
	$mot = strToUpper($string_lang['NOUVEAU'][$langue]);
	$m4 = "<a href=\"services.php?ttservice=0\"><B>$mot</B>";
	$mot = strToUpper($string_lang['HOPITAL'][$langue]);
	$m5 = "<a href=\"hop_maj.php\"><B>$mot</B>";
	$mot = strToUpper($string_lang['SERVICE_FERME'][$langue]);
	$m6 = "<a href=\"services/service_definitivement_ferme.php\"><B>CLOSED</B>";
	
	$menus= $m1;
	if($_SESSION['autorisation']==10)
		$menus .= " | ".$m6;
	$menus .= " | ".$m4." | ".$m5." | ".$m2." | ".$m3;

	entete_sagec2($titre,"center",$menus);
}

function menu_lits_simple($langue, $titre="SAGEC 67")
{
	require 'utilitaires/globals_string_lang.php';
	//$mot = strToUpper($string_lang['LITS'][$langue]."/".$string_lang['HOPITAL'][$langue]);
	//$m1 = "<a href=\"lits_service.php\"><B>$mot</B></a>";
	//$mot = strToUpper($string_lang['SYNOPTIQUE'][$langue]);
	//$m2 = "<a href=\"lits_synoptique.php\"><B>$mot</B></a>";
	$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
	$m3 = "<a href=\"sagec67.php\"><B>$mot</B>";
	//$mot = strToUpper($string_lang['NOUVEAU'][$langue]);
	//$m4 = "<a href=\"services.php?ttservice=0\"><B>$mot</B>";
	$menus= $m1." | ".$m4." | ".$m2." | ".$m3;

	entete_sagec2($titre,"center",$menus);
}

function menu_lits_table($langue, $titre="SAGEC 67")
{
	require 'utilitaires/globals_string_lang.php';
	$mot = strToUpper($string_lang['HOPITAUX'][$langue]);
	$m1 = "<a href=\"hopitaux_table.php\"><B>$mot</B></a>";
	$mot = strToUpper($string_lang['SERVICE'][$langue]);
	$m2 = "<a href=\"lits_service.php\"><B>$mot</B></a>";
	$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
	$m3 = "<a href=\"lits_disponibles.php\"><B>$mot</B>";
	$menus= $m1." | ".$m2." | ".$m3;
	entete_sagec2($titre,"center",$menus);
}

function menu_lits_maj($langue, $titre="SAGEC 67")
{
	require 'utilitaires/globals_string_lang.php';
	$mot = strToUpper($string_lang['HOPITAUX'][$langue]);
	$m1 = "<a href=\"hop_maj.php\"><B>$mot</B></a>";
	$mot = strToUpper($string_lang['SERVICE'][$langue]);
	$m2 = "<a href=\"service_maj.php\"><B>$mot</B></a>";
	$mot = strToUpper($string_lang['UF'][$langue]);
	$m4 = "<a href=\"uf/uf_maj.php\"><B>$mot</B></a>";
	$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
	$m3 = "<a href=\"lits_disponibles.php\"><B>$mot</B>";
	$menus= $m1." | ".$m2." | ".$m4." | ".$m3;
	entete_sagec2($titre,"center",$menus);
}

function MenuLits($langue) // obsolète
{
	require 'utilitaires/globals_string_lang.php';
	print("<html>");
	print("<head>");
	print("<title> Gestion des Lits </title>");
	print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
	print("</head>");

	// TITRE
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
		TblCellule("<div align=\"center\"><a href=\"lits_maj.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['LITS'][$langue]."/".$string_lang['HOPITAL'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"lits_service.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['SERVICE'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"service_table.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['LITS'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"lits_table.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['SYNOPTIQUE'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"lits_synoptique.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"sagec67.php\"><B>$mot</B>");
	TblFinLigne();
	TblFin();
	print("<hr>");// barre horizontale
	print("<div align=\"left\">");
	print("</div>");
	print("</body>");
	print("</html>");
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
?>
