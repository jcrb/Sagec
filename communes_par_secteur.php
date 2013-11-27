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
//																										 //
//	programme: 			communes_par_secteur.php																	 	 //
//	date de création: 	26/11/2003																		 //
//	auteur:				jcb																				 //
//	description:		Affiche la liste des communes d'un secteur ambulances privées								 											 //
//	version:			1.0																				 //
//	maj le:				26/11/2003																		 //
//																										 //
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION["langue"];

require("moyens_commune_menu.php");

//$langue = "FR";
MenuCommunes($langue);
print("<FORM name =\"Lits\"  ACTION=\"communes_par_secteur.php\">");

print("<input type=\"radio\" name=\"zone\" value=\"pds\" checked> secteur PDS ");
print("<input type=\"radio\" name=\"zone\" value=\"apa\" > secteur ADRU ");
print("<INPUT TYPE=\"SUBMIT\" VALUE=\"Valider\" NAME=\"ok\" SIZE = \"30\" ");
print("<br>");
include("communes_secteurs.php");
print("</FORM>");
?>
