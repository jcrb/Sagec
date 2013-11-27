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
if(! $_SESSION['auto_sagec'])header("Location:../logout.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("./../../html.php");

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"./../../pma.css\" ./../../TYPE =\"text/css\"></HEAD>");

print("<head>");
print("<title>menu assu</title>");
print("<LINK REL=stylesheet HREF=\"./../../tr_css.css\" TYPE =\"text/css\">");
print("</head>");

//print("<fieldset >");//class=\"time_v\"
//print("<legend> Menu </legend>");
print("<body bgcolor=\"#cccccc\">");
print("<ul class=\"menu1\">");
	print("<li><a href=\"arh_middlesup.php?select=hopital\" target=\"middlesup\">Hôpital</a></li>");
	print("<li><a href=\"arh_middlesup.php?select=zone_proximite\" target=\"middlesup\">Zone de proximité</a></li>");
	print("<li><a href=\"arh_middlesup.php?select=territoire\" target=\"middlesup\">Territoire de santé</a></li>");
	print("<li><a href=\"arh_middlesup.php?select=departement\" target=\"middlesup\">Département</a></li>");
	print("<li><a href=\"arh_middlesup.php?select=region\" target=\"middlesup\">Région</a></li>");
	print("<li>----------</li>");
	print("<li><a href=\"./../../sagec67.php\" target=\"_sup\">Menu principal</a></li>");
print("</ul>");
print("</body>");
?>
