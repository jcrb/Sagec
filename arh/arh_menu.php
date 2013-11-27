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
//	programme: 		arh_menu.php
//	date de cr?ation: 	02/03/2005
//	auteur:			jcb
//	description:		Fonctionalit? permise ? l'administrateur
//	version:			1.2
//	maj le:			14/05/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

print("<head>");
print("<title>menu assu</title>");
print("<LINK REL=stylesheet HREF=\"tr_css.css\" TYPE =\"text/css\">");
print("<LINK REL=stylesheet HREF=\"arh.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM name=\"arh\" method=\"get\" ACTION=\"arh_data_samu.php\" target=\"middle\">");
print("<div>");
print("<fieldset>");
print("<legend> services </legend>");
print("<input type=\"radio\" name=\"service\" value=\"samu\" checked> SAMU<br>");
print("<input type=\"radio\" name=\"service\" value=\"sau\"> SAU<br>");
print("<input type=\"radio\" name=\"service\" value=\"hopital\"> Hôpital<br>");
print("<input type=\"radio\" name=\"service\" value=\"tous\"> Tous<br>");
print("</fieldset>");

$today = date("j/m/Y");
$date1 = date("j/m/Y",mktime(0,0,0,date('m'),date('j')-6,date('Y')));
print("<fieldset>");
print("<legend> période </legend>");
print("du <input type=\"text\" name=\"date1\" value=\"$date1\" size=\"10\"><br>");
print("au <input type=\"text\" name=\"date2\" value=\"$today\" size=\"10\">");
print("</fieldset>");
print("</div>");
//print("<fieldset >");//class=\"time_v\"
//print("<legend> Menu </legend>");
print("<br><input type=\"submit\" name=\"ok\" value=\"Afficher\"><br>");
print("<body bgcolor=\"#cccccc\">");
print("<br>");

print("<ul id=menu>");
print("<li><a href=\"quelle_date.php\" target=\"middle\">Compte rendu urgences</a>");
print("<li><a href=\"quelle_date2.php\" target=\"middle\">Compte rendu services</a>");
print("<li><a href=\"../veille_sanitaire/alerte/alerte_menu.php\" target=\"middle\">Alerte SAMU</a>");
print("<li><a href=\"../veille_sanitaire/alerte/alerte_sau.php\" target=\"middle\">Alerte SAU</a>");
print("</ul>");

print("</form>");
print("</body>");
?>
