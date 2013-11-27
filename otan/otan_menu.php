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
//	programme: 		sdis_menu.php
//	date de création: 	08/12/2005
//	auteur:			jcb
//	description:		
//	version:		1.0
//	maj le:			08/12/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require '../utilitaires/globals_string_lang.php';
$langue = $_SESSION['langue'];
$backPathToRoot = "../";

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../brules/brule.css\" TYPE =\"text/css\"></HEAD>");

print("<head>");
print("<title>menu assu</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM name=\"arh\" method=\"get\" ACTION=\"arh_data_samu.php\" target=\"middle\">");
//$string_lang[$langue]["INTROCUCTION"];
?>
<ul id=menu>
	<li><a href="../administrateur/sauvegarde.php" target="middle"><?php echo('Crise');?></a>
	<li><a href="../blocnote_lire.php" target="middle"><?php echo('Main courante SAMU');?></a>
	<li><a href="../services/service_BN_lire.php" target="middle"><?php echo('Main courante ARH');?></a> 
	<li><a href="../ppi/ppi_dow/ppi_dow.php?id=34&nom=OTAN" target="middle"><?php echo('<b>OTAN</b>');?></a>
	<li><a href="../apa.php" target="middle"><?php echo('Moyens');?></a>
	<li><a href="../intervenants_org.php" target="middle"><?php echo('Organisation');?></a>
	<li><a href="../liste_victime.php" target="middle"><?php echo('Victimes');?></a>
	<li><a href="../documents.php" target="middle"><?php echo('Documents');?></a>
	<li><a href="../logout.php" target="_parent"><?php echo('Quitter la session');?></a>
</ul>
<?
print("</form>");
print("</body>");
?>
