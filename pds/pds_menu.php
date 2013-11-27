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
/**													
*	programme 			pds_menu.php
*	@date de création: 	05/11/2006
*	@author:			jcb
*	description:		menu du frameset PDS
*	@version:			1.0 - $ $
*	maj le:				05/11/2006
*	@package			Sagec
*/
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
	<li><a href="blocnote_pds_lire.php" target="middle"><?php echo('Informations PDS');?></a>
	<li><a href="blocnote_perso_lire.php" target="middle"><?php echo('Bloc-notes');?></a>
	<li><a href="tabgarde_lire.php" target="middle"><?php echo('Tableaux de gardes');?></a>
	<li><a href="geolocalisation.php" target="middle"><?php echo('Géolocalisation');?></a>
	<li><a href="" target="middle"><?php echo('Ecrire au Webmaster');?></a>
	<li><a href="pds_garde_accueil.php" target="middle"><?php echo('Tableau de garde');?></a>
	<li><a href="../logout.php" target="_top"><?php echo('Se déconnecter');?></a>
</ul>
<?
print("</form>");
print("</body>");
?>
