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
//	programme: 		programme mail_reglage.php	
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

print("<form name=\"\" method=\"get\" action=\"mail_reglage.php\">");

print("<table>");
print("<tr>");
	print("<td align=\"right\">heure</td>");
	print("<td align=\"left\"><input type=\"text\" name=\"heure\" value=\"17\" size=\"5\"></td>");
print("</tr>");
print("<tr>");
	print("<td align=\"right\">minutes</td>");
	print("<td align=\"left\"><input type=\"text\" name=\"minute\" value=\"0\" size=\"5\"></td>");
print("</tr>");
print("<tr>");
	print("<td align=\"right\">jour du mois (1-31)</td>");
	print("<td align=\"left\"><input type=\"text\" name=\"jour\" value=\"*\" size=\"5\"></td>");
print("</tr>");
print("<tr>");
	print("<td align=\"right\">mois (1-12)</td>");
	print("<td align=\"left\"><input type=\"text\" name=\"mois\" value=\"*\" size=\"5\"></td>");
print("</tr>");
print("<tr>");
	print("<td align=\"right\">jour de la semaine (dim=0)</td>");
	print("<td align=\"left\"><input type=\"text\" name=\"jour_semaine\" value=\"1-5\" size=\"5\"></td>");
print("</tr>");
print("<tr>");
	print("<td align=\"right\">adresse du script à activer</td>");
	//print("<td align=\"left\"><input type=\"text\" name=\"url\" value=\"http://sagec67.chru-strasbourg.fr/SAGEC67/administrateur/mail.php\" size=\"90\"></td>");
	print("<td align=\"left\"><input type=\"text\" name=\"url\" value=\"http://localhost/sagec3/info_lits/analyse_fichier.php\" size=\"90\"></td>");
	print("<tr>");
	print("<td align=\"right\">commentaire</td>");
	print("<td align=\"left\"><input type=\"text\" name=\"commentaire\" value=\"Mail DHOS\" size=\"30\"></td>");
print("</tr>");
print("<tr>");
	print("<td align=\"right\">&nbsp;</td>");
	print("<td align=\"left\"><input type=\"submit\" name=\"ok\" value=\"Valider\"></td>");
print("</tr>");
print("</tr>");
print("<table>");

if($_GET['ok'])
{
	$chpCommande = "wget --delete-after ".$_GET['url'];
	$rep = ajouteScriptSagec($_GET['heure'], $_GET['minute'], $_GET['jour'], $_GET['jour_semaine'], $_GET['mois'],$chpCommande ,$_GET['commentaire'] );
}

print("</form>");
print("</body>");
print("</html>");
?>
