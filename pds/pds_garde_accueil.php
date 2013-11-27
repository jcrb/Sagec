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
*	programme 			pds_garde_accueil.php
*	@date de création: 	05/11/2006
*	@author:			jcb
*	description:		docummentation commune à la PDS
*	@version:			1.0 - $ $
*	maj le:				05/11/2006
*	@package			Sagec
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require("../html.php");
require("../utilitairesHTML.php");

print("<HTML><HEAD><TITLE>Liste des messages</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
print("<form name=\"pds_garde\" method = \"GET\" action=\"pds_garde_saisie.php\">");

print("<table>");
	print("<tr>");
		print("<td align=\"right\">secteur de PDS: </td>");
		print("<td>");SelectSecteurPds($connexion,$item_select);print("</td>");
	print("</tr>");
	print("<tr>");
		print("<td align=\"right\">date de début: </td>");
		print("<TD><input TYPE=\"text\" VALUE=\"jj/mm/aaaa\" NAME=\"date1\" SIZE = \"10\"><input type='button' value='...' onClick=\"window.open('../calendrier/mycalendar.php?form=pds_garde&elem=date1','Calendrier','width=200,height=220')\"></TD>");
	print("</tr>");
	print("<tr>");
		print("<td align=\"right\">date de fin: </td>");
		print("<TD><input TYPE=\"text\" VALUE=\"jj/mm/aaaa\" NAME=\"date2\" SIZE = \"10\"><input type='button' value='...' onClick=\"window.open('../calendrier/mycalendar.php?form=pds_garde&elem=date2','Calendrier','width=200,height=220')\"></TD>");
	print("</tr>");
	print("<tr>");
		print("<td align=\"right\">&nbsp</td>");
		print("<td><input type=\"submit\" name=\"ok\" value=\"valider\"></td>");
	print("</tr>");
print("</table>");
print("</form>");
?>