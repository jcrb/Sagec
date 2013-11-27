<?php
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//----------------------------------------- SAGEC --------------------------------------------------------
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//----------------------------------------- SAGEC --------------------------------------------------------
print("<html>");
print("<head>");
print("<title> Gestion des Lits </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<body>");
require("menu_gestion_lits.php");
//MenuLits($langue);

require 'utilitaires/globals_string_lang.php';
require_once ("html.php");
$titre = $string_lang['GESTION_LITS'][$langue];

	$mot = strToUpper($string_lang['LITS'][$langue]."/".$string_lang['HOPITAL'][$langue]);
	$m1 = "<a href=\"lits_service.php\"><B>$mot</B></a>";
	$mot = strToUpper($string_lang['SYNOPTIQUE'][$langue]);
	$m2 = "<a href=\"lits_synoptique.php\"><B>$mot</B></a>";
	$mot = strToUpper($string_lang['PLATEAU'][$langue]);
	$m6 = "<a href=\"hopital/menu_ror.php\"><B>$mot</B>";
	$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
	$m7 = "<a href=\"login2.php\"><B>$mot</B>";
	
	$menus= $m1." | ".$m2." | ".$m6." | ".$m7;
	
	$mot = strToUpper($string_lang['TABLES'][$langue]);
	$m3 = "<a href=\"lits_hopitaux_table.php\"><B>$mot</B>";
	$mot = strToUpper($string_lang['MAJ'][$langue]);
	$m4 = "<a href=\"lits_hopitaux_maj.php\"><B>$mot</B>";
	$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
	$m5 = "<a href=\"sagec67.php\"><B>$mot</B>";
	
	$menus= $m1." | ".$m2." | ".$m3." | ".$m4." | ".$m6." | ".$m5;
	entete_sagec2($titre,"center",$menus);

print("<div align=\"left\">");
print("</div>");
print("</body>");
print("</html>");
?>
