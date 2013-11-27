<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------
//
//	programme: 		graphe_data.php
//	date de création: 	28/03/2005
//	auteur:			jcb
//	description:		Graphe de tendance de l'activité du SAMU
//	version:			1.2
//	maj le:			9/06/2005
//
//--------------------------------------------------------------------------------

print("<form name=\"graphe_data\" method=\"get\" action=\"graphe_veille_samu2.php\">");
print("<fieldset>");
print("<legend> Période </legend>");
print("<table>");
print("<tr>");
	print("<td>date de début</td>");
	$hier = date("j/m/Y",mktime(0,0,0,date('m'),date('j')-31,date('Y')));
	print("<td><input type=\"text\" name=\"date1\" value=\"$hier\"></td>");
print("</tr>");
print("<tr>");
	print("<td>date de fin</td>");
	$hier = date("j/m/Y",mktime(0,0,0,date('m'),date('j')-1,date('Y')));
	print("<td><input type=\"text\" name=\"date2\" value=\"$hier\"></td>");
print("</tr>");
print("</table>");
print("</fieldset>");

print("<fieldset>");
print("<legend> Service </legend>");
print("<table>");
print("<tr><td><input type=\"checkbox\" name=\"samu67\" checked> SAMU67</td></tr>");
print("<tr><td><input type=\"checkbox\" name=\"samu68\" > SAMU68</td></tr>");
print("</table>");
print("</fieldset>");

print("<fieldset>");
print("<legend> Données </legend>");
print("<table>");
print("<tr><td><input type=\"checkbox\" name=\"affaire\" checked> affaires</td>");
print("<td><input type=\"checkbox\" name=\"assu\"> ASSU</td></tr>");
print("<tr><td><input type=\"checkbox\" name=\"primaire\"> primaires</td>");
print("<td><input type=\"checkbox\" name=\"vsav\"> VSAV</td></tr>");
print("<tr><td><input type=\"checkbox\" name=\"secondaire\"> secondaires</td>");
print("<td><input type=\"checkbox\" name=\"cons\"> Conseils</td></tr>");
print("<tr><td><input type=\"checkbox\" name=\"neonat\"> Néonatalogie</td>");
print("<td><input type=\"checkbox\" name=\"med\"> Médecins</td></tr>");
print("<tr><td><input type=\"checkbox\" name=\"tiih\"> TIIH</td></tr>");
print("</table>");
print("</fieldset>");

print("<fieldset>");
print("<legend> Statistiques </legend>");
print("<table>");
print("<tr><td><input type=\"checkbox\" name=\"valeur\" checked>Valeurs</td></tr>");
print("<tr><td><input type=\"checkbox\" name=\"moyenne\">moyenne</td></tr>");
print("<tr><td><input type=\"checkbox\" name=\"moyenne_lisse\">moyenne lissée sur <input type=\"text\"name=\"jour\"size=\"3\"value=\"7\"> jours</td></tr>");
print("<tr><td><input type=\"checkbox\" name=\"ecart_type\">écart-type</td></tr>");

print("<tr><td><input type=\"submit\" name=\"ok\" value=\"valider\"></td></tr>");
print("<table>");
print("</fieldset>");

print("</form>");
?>
