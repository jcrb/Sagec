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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		gis_sup.php
//	date de création: 	19/08/05004
//	auteur:			jcb
//	description:		Affiche un entête
//	version:			1.0
//	maj le:			19/08/05004
//
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

print("<head>");
print("<title> SAGEC 67 </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");
//entete_sagec("SIG");
require '../utilitaires/globals_string_lang.php';
require_once ("../html.php");
//$titre = $string_lang['GESTION_LITS'][$langue];
$titre = "SIG";
$mot = strToUpper($string_lang['MENU_PRINCIPAL'][$langue]);
$m5 = "<a href=\"../sagec67.php\" target=\"_parent\"><B>$mot</B>";
//$menus= $m1." | ".$m2." | ".$m3." | ".$m4." | ".$m5;
$menus = $m5;
entete_sagec2($titre,"center",$menus,"./../");
?>
