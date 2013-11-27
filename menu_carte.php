<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
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
//
//----------------------------------------- SAGEC ---------------------------------------------//
//																							   //
//	programme: 			menu_carte.php															   //
//	date de création: 	31/01/2004															   //
//	auteur:				jcb																	   //
//	description:		affichage de la carte des secteurs									 								   //
//	version:			1.0																	   //
//	maj le:				31/01/2004										   //
//																							   //  
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
require("biotox_utilitaires.php");

print("<FORM NAME=\"xx\" TARGET =\"centre\" ACTION=\"biotox_image.php?\">");

print("<TABLE>");
print("<TR>");
print("<TD>");
print("Choisir un matériel:");
print("</TD>");
print("</TR>");

print("<TR>");
	print("<TD>");
		$connexion = connexion(NOM,PASSE,BASE,SERVEUR);
		// Liste déroulante du matériel
		liste_materiel($connexion);
	print("</TD>");
print("</TR>");

print("<TR>");
	print("<TD>");
		print("<INPUT TYPE=\"SUBMIT\" NAME=\"OK\" VALUE=\"Validez\">");
	print("</TD>");
print("</TR>");

print("<TR>");
	print("<TD>");
			print("<A HREF=\"materiel/biotox_menu.php\" TARGET=\"_TOP\">Retourner au menu principal</A>");
	print("</TD>");
print("</TR>");

print("</TABLE>");
print("</FORM>");
?>
