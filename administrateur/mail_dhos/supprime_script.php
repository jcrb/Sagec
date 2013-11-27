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
//	programme: 		supprime_script.php	
//	date de création: 	04/12/2005	
//	auteur:			jcb
//	description:
//	version:		1.0
//	maj le:			04/12/2005
// 
//---------------------------------------------------------------------------------------------//
// 
require("../../veille_sanitaire/cron/utilitaire_cron.php");

print("<html>");
print("<header>");
print("</header>");
print("<body>");

print("<form name=\"\" method=\"get\" action=\"supprime_script.php\">");

print("<table>");
print("<tr>");
	print("<td align=\"right\">n° de la règle à supprimer: </td>");
	print("<td align=\"left\"><input type=\"text\" name=\"id\" value=\"\" size=\"5\"></td>");
print("</tr>");
print("<tr>");
	print("<td align=\"right\">&nbsp;</td>");
	print("<td align=\"left\"><input type=\"submit\" name=\"ok\" value=\"Valider\"></td>");
print("</tr>");
print("<table>");

affiche_crontable();
print("<br>");

if($_GET['ok'])
{
	retireScript($_GET['id']);
}

print("</form>");
print("</body>");
print("</html>");
?>