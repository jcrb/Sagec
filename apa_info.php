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
/**
*	apa_info.php
*	@version $Id: apa_info.php 44 2008-04-16 06:55:34Z jcb $
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_apa'])header("Location:langue.php");

include("utilitaires/table.php");
require("html.php");
entete_sagec("Transporteurs Sanitaires Privés");

//include("html.php");
print("<HTML><HEAD><TITLE>Liste des vecteurs</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\"></HEAD>");

print("<H2>Informations</H2>");
print("<hr>");// barre horizontale
$back = "apa_info.php";
TblDebut(0,"100%");
	TblDebutLigne();
		TblCellule("<a href = \"apa_commune.php\">Liste des communes par secteur</a><br>");
		//TblCellule("<a href=\"carte_secteurs.php?back=$back&secteur_ID=10\">Cartographie</a>");
		TblCellule("<a href=\"offre_soins/index.php\">Cartographie</a>");
		TblCellule("<a href = \"en_construction.php\">Calendrier des formations</a><br>");
		TblCellule("<a href = \"apa_doc.php?back=$back\">Documentation</a><br>");
		$mot = "Retour";
		TblCellule("<a href = \"apa_menu.php\" class=\"time_r\">$mot</a>");
	TblFinLigne();
TblFin();
print("<hr>");// barre horizontale
?>
