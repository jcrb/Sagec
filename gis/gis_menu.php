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
//	programme: 		gis_menu.php
//	date de cr?ation: 	19/08/2005
//	auteur:			jcb
//	description:
//	version:			1.1
//	maj le:			19/08/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
$langue = $_SESSION['langue'];

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

print("<head>");
print("<title>menu assu</title>");
print("<LINK REL=stylesheet HREF=\"tr_css.css\" TYPE =\"text/css\">");
print("</head>");


//print("<fieldset >");//class=\"time_v\"
//print("<legend> Menu </legend>");
print("<body bgcolor=\"#cccccc\">");
//print("<form name=\"dossier\" target=\"left\" method=\"get\">");

print("<ul class=\"menu1\">");
	print("<li><a href=\"ville/ville_frameset.php\" target=\"middle\">Villes</a></li>");
	print("<li><a href=\"zone.php\" target=\"middle\">Zones</a></li>");
	print("<li><a href=\"pays.php\" target=\"middle\">Pays</a></li>");
	print("<li><a href=\"../carto2/distance.php\" target=\"middle\">Distances</a></li>");
print("</ul>");
//print("<form>");
print("</body>");
?>
