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
//	programme: 		samu_menu.php
//	date de création: 	08/08/2009
//	auteur:			jcb
//	description:		
//	version:		1.0
//	maj le:			08/08/2009
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../../";
require($backPathToRoot."html.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
$langue = $_SESSION['langue'];


print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"brule.css\" TYPE =\"text/css\"></HEAD>");

print("<head>");
print("<title>menu samu</title>");
print("<LINK REL=stylesheet HREF=\"../../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM name=\"arh\" method=\"get\" ACTION=\"\" target=\"middle\">");
//$string_lang[$langue]["INTROCUCTION"];
?>
<ul id=menu>
	<li><a href="surge.php" target="middle"><?php echo('Menu');?></a>
	<li><a href="../../blocnote/blocnote_lire.php?back=0" target="middle"><?php echo('Main courante');?></a>
	<li><a href="checklist.php" target="middle"><?php echo('Check-List');?></a>
	<li><a href="hopitaux_contact.php" target="middle"><?php echo('Hôpitaux');?></a>
	<li><a href="service_contact.php" target="middle"><?php echo('Services');?></a>
	<li><a href="service_synthese.php" target="middle"><?php echo('SYNTHESE');?></a>
	
	<li><a href="" target="middle"><?php echo('--------------');?></a>
	
	<li><a href="specialites_affiche.php" target="middle"><?php echo('Gestion des spécialités');?></a>
	<li><a href="../fiche_hopital.php" target="middle"><?php echo('Formulaire');?></a>
	<li><a href="hopitaux_affiche.php" target="middle"><?php echo('Sélection des Hôpitaux');?></a>
	<li><a href="services_affiche.php" target="middle"><?php echo('Sélection des Services');?></a>
	<li><a href="tache_nouvelle.php" target="middle"><?php echo('Nouvelle tâche');?></a>
	<li><a href="tache_reset.php" target="middle"><?php echo('Reset tâche');?></a>
	
	<li><a href="../../logout.php" target="_parent"><?php echo('Quitter la session');?></a>
	
</ul>
<?
print("</form>");
print("</body>");
?>
