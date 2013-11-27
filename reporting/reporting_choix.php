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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		reporting_choix.php
//	date de création: 	29/07/2005
//	auteur:			jcb
//	description:		choix des éléments de reporting
//	version:			1.0
//	maj le:			29/07/2005
//
//--------------------------------------------------------------------------------------------------------
session_start();
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
include("../utilitaires/table.php");
include("../utilitairesHTML.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<Head>");
?>
	<script>
		function calendrier(f,e)
		{
			source="../mycalendar2.php?form="+f+"&elem="+e
			window.open(source,'calendrier','width=200','height=220');
		}
	</script>
<?
print("</Head>");
print("<body onload=\"document.reporting_choix.date1.focus()\">");
print("<form name=\"reporting_choix\" method=\"get\" action=\"reporting_graphe.php\">");
print("<div>Paramètres du reporting</div>");

print("<fieldset>");
print("<legend>Période</legend>");
print("<table>");
	print("<tr>");
	print("<td>Date de début</td>");
	print("<td>");
	print("<input type=\"text\" name=\"date1\" value=\"\">");
	print("<input type=\"button\" name=\"calendar\" value=\"...\" onclick=\"calendrier('reporting_choix','date1')\">");
	print("</td>");
	print("</tr>");
	// date 2
	print("<tr>");
	print("<td>Date de fin</td>");
	print("<td>");
	print("<input type=\"text\" name=\"date2\" value=\"\">");
	print("<input type=\"button\" name=\"calendar\" value=\"...\" onclick=\"calendrier('reporting_choix','date2')\">");
	print("</td>");
	print("</tr>");
	// action
	print("<tr>");
		print("<td>&nbsp;</td>");
		print("<td><input type=\"submit\" name=\"ok\" value=\"Afficher\"></td>");
	print("</tr>");
print("</table>");
print("</fieldset>");

print("<fieldset>");
print("<legend>Services</legend>");
print("<table>");
print("<tr>");
print("<td><input type=\"radio\" name=\"service\" value=\"1\" checked> par type de service<td>");
print("<td>");
	SelectTypeService($connexion,$item_select,$langue,$onChange="");
print("<td>");
print("</tr>");
print("<tr>");
print("<td><input type=\"radio\" name=\"service\" value=\"2\"> par service<td>");
print("<td>");
	SelectTousService($connexion,$item_select,$langue,'5');
print("</td>");
print("<td>");
	print("<i>Pour sélectionner plusieurs services, maintenir la touche Ctrl enfoncée</i>");
print("</td>");
print("</tr>");
print("</table>");
print("</fieldset>");

print("<fieldset>");
print("<legend>Secteur</legend>");
print("<table>");
print("<tr>");
print("<td>Départements</td>");
print("<td>");
	SelectDepartement($connexion,$item_select,$langue,7);
print("<td>");
print("<td>");
	print("<i>Pour sélectionner plusieurs services, maintenir la touche Ctrl enfoncée</i>");
print("</td>");
print("</tr>");
print("</table>");
print("</fieldset>");

print("</form>");
print("</body>");

?>
