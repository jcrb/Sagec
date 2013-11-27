<?php
session_start();
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
//																										 //
//	programme: 			Gestion_des_intervenants.php																	 	 //
//	date de création: 	08/10/2003																		 //
//	auteur:				jcb																				 //
//	description:			
//														 											 //
//	version:			1.0																				 //
//	maj le:				08/10/2003																		 //
//																										 //
//---------------------------------------------------------------------------------------------------------
include("utilitaires/table.php");
include("html.php");
require 'utilitaires/globals_string_lang.php';

print("<html>");
	print("<head>");
	print("<title> Gestion des Intervenants </title>");
	print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
	print("</head>");
	// TITRE
	TblDebut(0,"100%");
		TblDebutLigne();
		TblCellule(Image('SAMU.jpeg',50,50));
		TblCellule("<B>SAGEC 67 - GESTION DES INTERVENANTS</B>",1,1,"TITRE");
		TblCellule("SAMU 67",1,1);
		TblFinLigne();
	TblFin();
	print("<hr>");// barre horizontale	
	TblDebut(0,"100%",0);
		$_style = "A2";
		TblDebutLigne("$_style");
			TblCellule("<div align=\"center\"><B>Développement en cours...</B>");
			TblCellule("<div align=\"center\"><a href=\"organisme_maj.php\"><B>Organisme</B></a>");
			TblCellule("<div align=\"center\"><a href=\"Intervenant_maj.php\"><B>Personnel</B></a>");
			TblCellule("<div align=\"center\"><a href=\"Intervenants_selection.php\"><B>RAPPEL</B></a>");
			TblCellule("<div align=\"center\"><a href=\"SAGEC67.php\"><B>Menu</B></a>");
		TblFinLigne();
	TblFin();
	print("<hr>");// barre horizontale
	print("<div align=\"left\">");
	print("</div>");
	print("</body>");
	print("</html>");

?>
