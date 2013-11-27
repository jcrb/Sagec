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
//	programme: 		medecin_menu.php
//	date de cr�ation: 	08/12/2005
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
	<li><a href="med_new_dispo.php" target="middle"><?php echo('Nouvelle disponibilit�');?></a>
	<li><a href="med_liste_dispo.php" target="middle"><?php echo('Lire / modifier les disponibilit�s');?></a>
	<li><a href="med_territoire.php" target="middle"><?php echo('D�finir mon territoire');?></a>
	<li><a href="med_affiche_territoire.php" target="middle"><?php echo('Afficher mon territoire');?></a>
	<li><a href="med_carto.php" target="middle"><?php echo('Cartographie');?></a>
	<li><a href="med_carto_generale.php" target="middle"><?php echo('Cartographie g�n�rale');?></a>
	<li><a href="agenda.php" target="middle"><?php echo('Agenda');?></a>
	
	<li><a href="liste_medecins.php" target="middle"><?php echo('Liste m�decins');?></a>
	<li><a href="med_maj.php" target="middle"><?php echo('nouveau');?></a>
</ul>
<?
print("</form>");
print("</body>");
?>
