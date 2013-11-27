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
//----------------------------------------- SAGEC --------------------------------------------------------
//																										 
//	programme: 			utilisateurs_menu.php																	 	
//	date de création: 	26/12/2003																		
//	auteur:				jcb																			
//	description:		Fonctionalité permise à l'administrateur
//	version:			1.0																				 
//	maj le:				26/12/2003																		
//																										
//---------------------------------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

include("utilitaires/table.php");
require 'utilitaires/globals_string_lang.php';
include("html.php");
require 'utilitaires/globals_string_lang.php';
	
// ENTETE
	print("<html>");
	print("<head>");
	print("<title> Gestion des utilisateurs </title>");
	print("<meta name=\"author\" content=\"JCB\">");
	print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
	print("</head>");
// CORPS
	print("<BODY>");
	print("<FORM ACTION =\"utilisateurs_menu.php\" METHOD=\"POST\">");
	TblDebut(0,"100%");
	TblDebutLigne();
	TblCellule(Image('images/SAMU.jpeg',50,50));
	$mot = strToUpper($string_lang['GESTION_UTILISATEUR'][$langue]);
	TblCellule("<B>$mot</B>",1,1,"TITRE");
	TblCellule("SAMU 67",1,1);
	TblFinLigne();
	TblFin();

	print("<hr>");// barre horizontale	
	TblDebut(0,"100%",0);
	$_style = "A2";
	TblDebutLigne("$_style");
		$mot = strToUpper($string_lang['LISTE'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"utilisateurs_liste.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['NOUVEAU'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"utilisateurs_ajout.php\"><B>$mot</B></a>");
		$mot = "Gestion des droits";
		TblCellule("<div align=\"center\"><a href=\"autorisations/gestion_droits.php\"><B>$mot</B>");
		$mot = strToUpper($string_lang['QUITTER'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"administrateur_menu.php\"><B>$mot</B>");
	TblFinLigne();
	TblFin();		
	print("<hr>");// barre horizontale
	print("<div align=\"left\">");
	print("</div>");
	
		
print("</form>");
print("</body>");
print("</html>");

?>
