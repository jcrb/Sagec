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

function menu_intervenants($langue)
{
	include_once("utilitaires/table.php");
	include 'utilitaires/globals_string_lang.php';
	include("html.php");

	print("<html>");
	print("<head>");
	$mot=$string_lang['GESTION_INTERVENANT'][$langue];
	print("<title> $mot </title>");
	print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
	print("</head>");
	
	print("<body>");
	TblDebut(0,"100%");
		TblDebutLigne();
		$mot = "SAGEC 67 - ".$mot;
		TblCellule(Image('images/SAMU.jpeg',50,50));
		TblCellule("<B>$mot</B>",1,1,"TITRE");
		TblCellule("SAMU 67",1,1);
		TblFinLigne();
	TblFin();
	print("<hr>");// barre horizontale	
	TblDebut(0,"100%",0);
		$_style = "A2";
		TblDebutLigne("$_style");
			//$mot=strToUpper($string_lang['DEVELOPPEMENT_ENCOURS'][$langue]);
			//TblCellule("<div align=\"center\"><B>$mot...</B>");
			//$mot=strToUpper($string_lang['ORGANISME'][$langue]);
			//TblCellule("<div align=\"center\"><a href=\"organisme/organisme_maj.php\"><B>$mot</B></a>");
			TblCellule("<div align=\"center\"><a href=\"intervenants_arrive.php\"><B>Arrivées/Départs</B></a>");
			TblCellule("<div align=\"center\"><a href=\"intervenant_disponible.php\"><B>Personnel disponible</B></a>");
			TblCellule("<div align=\"center\"><a href=\"intervenants_badges.php\"><B>Badges</B></a>");
			$mot=strToUpper($string_lang['PERSONNEL'][$langue]);
			TblCellule("<div align=\"center\"><a href=\"intervenant_modifier.php\"><B>$mot</B></a>");
			$mot=strToUpper($string_lang['RAPPEL'][$langue]);
			TblCellule("<div align=\"center\"><a href=\"intervenants_selection.php\"><B>$mot</B></a>");
			TblCellule("<div align=\"center\"><a href=\"intervenants_synoptique.php\"><B>Synoptique</B></a>");
			TblCellule("<div align=\"center\"><a href=\"intervenants_org.php\"><B>Organisation</B></a>");
			TblCellule("<div align=\"center\"><a href=\"sagec67.php\"><B>Menu</B></a>");
		TblFinLigne();
	TblFin();
	print("<hr>");// barre horizontale
	print("<div align=\"left\">");
	print("</div>");
	print("</body>");
	print("</html>");
}
?>
