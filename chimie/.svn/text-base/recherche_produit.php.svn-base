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
//													//
//	programme: 		cherche_produit.php							//
//	date de création: 	15/04/2004								//
//	auteur:			jcb									//
//	description:		Cherche un produit dans la base de données produitsChimiques		//
//	version:		1.0									//
//	maj le:			15/04/2004								//
//													//
//--------------------------------------------------------------------------------------------------------
// 
//--------------------------------------------------------------------------------------------------------
session_start();
$langue = $_SESSION['langue'];
if(! $_SESSION['auto_sagec'])header("Location:langue.php");

include("../utilitaires/table.php");
include("../html.php");
require '../utilitaires/globals_string_lang.php';

print("<html>");
print("<head>");
print("<title> Identifier un produit </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY>");
print("<FORM name =\"chimie\"  ACTION=\"./affiche_produit.php\" METHOD=\"post\" TARGET=\"_TOP\">");
entete_sagec("<H2>Identification d'un produit chimique</H2>");
print("<P>&nbsp;</P>");

print("<TABLE width=\"50%\" BORDER=\"1\" ALIGN=\"center\">");
	print("<TR>");
		print("<TD ROWSPAN=\"2\" ALIGN=\"center\"><IMG SRC = \"plaque_codes_danger.gif\"></TD>");
		print("<TD>code de danger</TD>");
		print("<TD><INPUT TYPE=\"input\" NAME=\"danger\" VALUE=\"0\" Div ALIGN=\"center\"><TD>");
	print("</TR>");

	print("<TR>");
		print("<TD>code produit (UN)</TD>");
		print("<TD><INPUT TYPE=\"input\" NAME=\"un\" VALUE=\"\"></TD>");
	print("</TR>");

	print("<TR>");
		print("<TD ALIGN=\"center\">Valider</TD>");
		print("<TD>&nbsp;</TD>");
		print("<TD ALIGN=\"center\"><INPUT TYPE=\"submit\" NAME=\"ok\" VALUE=\"valider\"></TD>");
	print("</TR>");
print("</TABLE>");
print("<P>&nbsp;</P>");

print("<IMG SRC = \"camion-1.gif\">");
print("<IMG SRC = \"camion-2.gif\">");
print("<IMG SRC = \"plaque_codes_danger.gif\">");

print("</FORM>");
print("</BODY>");
print("</html>");
?>
