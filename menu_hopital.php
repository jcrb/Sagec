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
//----------------------------------------- SAGEC --------------------------------------------------------
//																										 
//	programme: 			Menu_hopital.php																	 	
//	date de création: 	15/08/2003																		
//	auteur:				jcb																			
//	description:		Permet à un utilisateur autorisé, de mettre à jour les disponibilités d'un hopital
//	version:			1.0																				 
//	maj le:				14/12/2003																		
//						07/03/2004	rajout balises </DIV> manquantes
//																									
//---------------------------------------------------------------------------------------------------------
//
session_start();
include("utilitaires/table.php");
require 'utilitaires/globals_string_lang.php';
include("html.php");

function MenuHopital($langue)
{
	session_start();
	require 'utilitaires/globals_string_lang.php';
	print("<html>");
	print("<head>");
	print("<title> Gestion des Lits </title>");
	print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
	print("</head>");		
	
	print("<body>");
	// TITRE
	TblDebut(0,"100%");
	TblDebutLigne();
	TblCellule(Image('images/SAMU.jpeg',50,50));
	$mot = $string_lang['HOPITAL'][$langue]." ".$hopital;
	TblCellule("<B>$mot</B>",1,1,"TITRE");
	TblCellule("SAMU 67",1,1);
	TblFinLigne();
	TblFin();

	print("<hr>");// barre horizontale	
	TblDebut(0,"100%",0);
	$_style = "A2";
	TblDebutLigne("$_style");
		$mot = strToUpper($string_lang['HOPITAL'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"service_synoptique.php\"><B>$mot</B></a></DIV>");
		$mot = strToUpper($string_lang['PATIENTS'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"hopital_start.php\"><B>$mot</B></a></DIV>");
		$mot = strToUpper($string_lang['LITS'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"hopital_lits.php\"><B>$mot</B></a></DIV>");
		$mot = strToUpper($string_lang['PERSONNEL'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"hopital_start.php\"><B>$mot</B></a></DIV>");
		$mot = strToUpper($string_lang['ANTIDOTE'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"hopital_start.php\"><B>$mot</B></a></DIV>");
		$mot = strToUpper($string_lang['ANTIBIOTIQUE'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"hopital_start.php\"><B>$mot</B></DIV>");
		$mot = strToUpper($string_lang['FOURNITURES'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"hopital_start.php\"><B>$mot</B></DIV>");
		$mot = strToUpper($string_lang['QUITTER'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"logout.php\"><B>$mot</B></DIV>");
	TblFinLigne();
	TblFin();		
	print("<hr>");// barre horizontale
	print("<div align=\"left\">");
	print("</div>");
	print("</body>");
	print("</html>");
}
?>
