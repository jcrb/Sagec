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
//	programme: 		brule_menu.php
//	date de création: 	20/11/2005
//	auteur:			jcb
//	description:		Fonctionalit? permise ? l'administrateur
//	version:			1.0
//	maj le:			20/11/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require '../utilitaires/globals_string_lang.php';
$langue = $_SESSION['langue'];

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"brule.css\" TYPE =\"text/css\"></HEAD>");

print("<head>");
print("<title>menu assu</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM name=\"arh\" method=\"get\" ACTION=\"arh_data_samu.php\" target=\"middle\">");
//$string_lang[$langue]["INTROCUCTION"];
?>
<ul id=menu>
	<li><a href="brule_intro.php" target="middle"><?php echo($string_lang['INTRODUCTION'][$langue]);?></a>
	<li><a href="brule_liste.php" target="middle"><?php echo($string_lang['LISTE_SERVICE'][$langue]);?></a>
	<li><a href="brule_cherche.php?rayon=500" target="middle"><?php echo($string_lang['CHERCHER'][$langue]);?></a>
	<li><a href="brule_carto.php" target="_BLANK"><?php echo($string_lang['CARTOGRAPHIE'][$langue]);?></a>
</ul>
<?
print("</form>");
print("</body>");
?>
