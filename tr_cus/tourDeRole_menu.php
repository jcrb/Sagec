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
//
//	programme: 		tourDeRole_menu.php
//	date de cr?ation: 	5/10/2004
//	auteur:			jcb
//	description:
//	version:			1.1
//	maj le:			07/11/2004
//
//---------------------------------------------------------------------------------------------//
print("<head>");
print("<title>menu assu</title>");
print("<LINK REL=stylesheet HREF=\"tr_css.css\" TYPE =\"text/css\">");
print("</head>");

//print("<fieldset >");//class=\"time_v\"
//print("<legend> Menu </legend>");
print("<body bgcolor=\"#cccccc\">");
print("<ul class=\"menu1\">");
	print("<li><a href=\"../samu_menu.php\" target=\"_TOP\">RETOUR</a></li>");
	print("<li><a href=\"tourDeRole_affiche.php\" target=\"bottom\">récapitulatif</a></li>");
	print("<li><a href=\"tourDeRole_modifie.php\" target=\"bottom\">modifier</a></li>");
	print("<li><a href=\"transmission_dass.php\" target=\"bottom\">Transmettre à la DASS</a></li>");
	print("<li><a href=\"garde_frameset.php\" target=\"bottom\">Gardes CUS</a></li>");
	print("<li><a href=\"\">Effacer</a></li>");
print("</ul>");
print("</body>");
/*
print("<table width=\"100%\">");
print("<TR><TD><A HREF=\"../samu_menu.php\" target=\"_TOP\">Retour</A></TD></TR>");
print("<TR><TD><A HREF=\"tourDeRole_affiche.php\" target=\"bottom\">récapitulatif</A></TD></TR>");
print("<TR><TD><A HREF=\"tourDeRole_modifie.php\" target=\"bottom\">modifier</A></TD></TR>");
//------------------------------------------------------------------------------------------------
print("<TR><TD><A HREF=\"transmission_dass.php\" target=\"bottom\">Transmettre à la DASS</A></TD></TR>");
print("<TR><TD><A HREF=\"garde_frameset.php\" target=\"bottom\">Gardes CUS</A></TD></TR>");
print("<TR><TD><A HREF=\"#\" target=\"bottom\">Effacer</A></TD></TR>");
print("");
print("");
print("<table>");
*/
?>
