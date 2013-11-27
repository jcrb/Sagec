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
//
//----------------------------------------- SAGEC ---------------------------------------------//
//												//
//	programme: 		sagec67.php							//
//	date de cr?ation: 	18/08/2003							//
//	auteur:			jcb								//
//	description:										//
//	version:		1.0								//
//	maj le:			26/12/2003	menu_administrateur
//				7/03/2004	supression de l'affichage de la langue		//
//												//
//---------------------------------------------------------------------------------------------//
print("<html>");
print("<head>");
print("<title> Gestion des tâches </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY>");
print("<FORM name =\"soustaches\"  ACTION=\"../sagec67.php\" METHOD=\"post\" TARGET=\"_TOP\">");
print("sous-tâches associées:");

print("<TABLE 100%>");
	print("<TR>");
		print("<TD>Qui</TD>");
		print("<TD>Quoi</TD>");
		print("<TD>modifier</TD>");
		print("<TD>supprimer</TD>");
	print("</TR>");
print("</TABLE>");
print("</FORM>");
print("</BODY>");
print("</html>");
?>
