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
//
//	tabgarde_lire.php													
//	auteur:			jcb									
//	description:		Lire le contenu du bloc-notes						
//				par ordre chronologique inverse						
//	version:		1.2									
//	maj le:											
/**													
*	programme 			tabgarde_lire.php
*	@date de création: 	05/11/2006
*	@author:			jcb
*	description:		affiche le tableau de garde général
*	@version:			1.0 - $ $
*	maj le:				05/11/2006
*	@package			Sagec
*   @todo	à terminer
*/													
//--------------------------------------------------------------------------------------------------------
// la liste s'affiche par ordre cronologique inverse
// la liste est rafraichie toutes les 30 secondes
// le nom du rédacteur apparait
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require("../html.php");

print("<HTML><HEAD><TITLE>Liste des messages</TITLE>");
//<comment> rafraichissement automatique toutes les 30 secondes </comment>
print("<meta http-equiv=\"refresh\" content=\"30\">");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

print("<BODY>");
print("<p>Tableaux de garde des Hôpitaux et de la PDS<p>");
print("<table border=\"1\" cellspacing=\"0\">");
print("<tr>");
	print("<td>&nbsp;</td>");
	print("<td>USIC</td>");
	print("<td>Médecine</td>");
	print("<td>AVC</td>");
	print("<td>Chirurgie</td>");
	print("<td>Traumato</td>");
	print("<td>Main</td>");
	print("<td>Réa Med</td>");
	print("<td>Réa Chir</td>");
print("</tr>");
print("<tr>");
	print("<td>STRASBOURG</td>");
	print("<td></td>");
	print("<td></td>");
	print("<td></td>");
	print("<td></td>");
print("</tr>");
print("<tr>");
	print("<td>HAGUENAU</td>");
	print("<td>USIC Haguenau</td>");
	print("<td></td>");
	print("<td></td>");
	print("<td></td>");
	print("<td></td>");
	print("<td>Clinique St François</td>");
print("</tr>");
print("<tr>");
	print("<td>SAVERNE</td>");
	print("<td>USIC Haguenau</td>");
	print("<td></td>");
	print("<td></td>");
	print("<td></td>");
print("</tr>");
print("<tr>");
	print("<td>WISSEMBOURG</td>");
	print("<td>USIC Haguenau</td>");
	print("<td></td>");
	print("<td></td>");
	print("<td></td>");
print("</tr>");
print("<tr>");
	print("<td>SELESTAT</td>");
	print("<td>St Joseph Colmar</td>");
	print("<td></td>");
	print("<td></td>");
	print("<td></td>");
print("</tr>");
print("</table>");
print("</BODY>");
print("</HTML>");
?>