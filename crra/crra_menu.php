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
//	date de crï¿½ation: 	08/12/2005
//	auteur:			jcb
//	description:
//	version:		1.0
//	maj le:			08/12/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//require("../html.php");
$langue = $_SESSION['langue'];

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"crra2.css\" TYPE =\"text/css\"></HEAD>");
print("</head>");

print("<FORM name=\"arh\" method=\"get\" ACTION=\"arh_data_samu.php\" target=\"middle\">");
?>
<ul id=menu>
	<li><a href="creer_tache.php" target="middle"><?php echo('Nouvelle tâche');?></a>
	<li><a href="lire_tache.php" target="middle"><?php echo('Liste des tâches');?></a>
	<li><a href="../sagec67.php" target="_parent"><?php echo('Retour au menu');?></a>
</ul>
<?
print("</form>");
print("</body>");
?>
