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

include("utilitaires/table.php");
include("html.php");

function entete($member_id,$langue,$prefix="")
{
	require $prefix.'utilitaires/globals_string_lang.php';
	print("<html>");
	print("<head>");
	$mot=$string_lang['GESTION_VICTIMES'][$langue];
	print("<title> $mot </title>");
	print("<LINK REL=stylesheet HREF=\"".$prefix."pma.css\" TYPE =\"text/css\">");
	print("</head>");
	// TITRE
	TblDebut(0,"100%");
		TblDebutLigne();
		TblCellule(Image($prefix.'images/SAMU.jpeg',50,50));
		$mot=$string_lang['GESTION_VICTIMES'][$langue];
		TblCellule("<B> $mot </B>",1,1,"TITRE");
		TblCellule("SAMU 67",1,1);
		TblFinLigne();
	TblFin();
	print("<hr>");// barre horizontale	
	TblDebut(0,"100%",0);
		$_style = "A2";
		if($_SESSION['auto_sagec'])
		{
			$nouveau = strtoupper($string_lang['NOUVEAU'][$langue]);
			$modifier = strtoupper($string_lang['RECHERCHER'][$langue]);
		}
		$bilan = strtoupper($string_lang['SYNOPTIQUE'][$langue]);
		TblDebutLigne("$_style");
			if($member_id !="1")
				TblCellule("<div align=\"center\"><a href=\"".$prefix."nouveau.php\"><B>$nouveau</B></a>");
			if($member_id !="1")
				TblCellule("<div align=\"center\"><a href=\"".$prefix."victime_modifie.php\"><B>$modifier</B></a>");
			TblCellule("<div align=\"center\"><a href=\"".$prefix."bilan.php\"><B>$bilan</B></a>");
			$mot=strtoupper($string_lang['LISTE'][$langue]);
			TblCellule("<div align=\"center\"><a href=\"".$prefix."liste_victime.php?SID\"><B>$mot</B></a>");
			TblCellule("<div align=\"center\"><a href=\"".$prefix."hop_synoptique.php?SID\"><B>Destinations</B></a>");
			TblCellule("<div align=\"center\"><a href=\"".$prefix."victime/synoptique_victimes.php\"><B>S2</B></a>");
			
			if($_SESSION['auto_sagec'])
			{
				TblCellule("<div align=\"center\"><a href=\"".$prefix."pma/pma_frameset.php\"><B>PMA</B></a>");
				TblCellule("<div align=\"center\"><a href=\"".$prefix."victime/regles.php\"><B>Regles</B></a>");
				TblCellule("<div align=\"center\"><a href=\"".$prefix."sagec67.php\"><B>Menu</B></a>");
			}
		TblFinLigne();
	TblFin();
	print("<hr>");// barre horizontale
	print("<div align=\"left\">");
	print("</div>");
	print("</body>");
	print("</html>");
}

?>
