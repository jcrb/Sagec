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
//	programme: 		sidpc_menu.php
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
$backPathToRoot = "../";
$BackToRoot = $backPathToRoot;
require("../html.php");
require '../utilitaires/globals_string_lang.php';
require $backPathToRoot."autorisations/droits.php";
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
	<li><a href="../administrateur/sauvegarde.php" target="middle"><?php echo('Crise');?></a>
	<?php
		// Accès à la page de la main courante
		if (est_autorise("MCS_LECTURE")||est_autorise("MCS_ECRITURE")||est_autorise("MCS_MODIFICATION"))
		{ 
			$mot = "Main courante SAMU 67";
			?>
				<li><a href='../blocnote/blocnote_lire.php' target='middle'><?php echo $mot; ?></a></li>
			<?php
		}
	?>
	<li><a href="../services/service_bloc_note.php" target="middle"><?php echo('Main courante');?></a>
	<li><a href="sidpc_moyen.php" target="middle"><?php echo('Moyens');?></a>
	<li><a href="../intervenants_org.php" target="middle"><?php echo('Organisation');?></a>
	<li><a href="../liste_victime.php" target="middle"><?php echo('Victimes');?></a>
	<li><a href="liste_ppi.php" target="middle"><?php echo('Plans de secours');?></a>
	<li><a href="../documents.php" target="middle"><?php echo('Documents');?></a>
	<!--
		<li><a href="../new_password.php" target="middle"><?php echo('Changer de mot de passe');?></a>
	<li><a href="../logout.php" target="_parent"><?php echo('Quitter la session');?></a>
	-->
</ul>
<?
print("</form>");
print("</body>");
?>
