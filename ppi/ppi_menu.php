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
//	programme: 				ppi_menu.php
//	date de création: 	29/10/2008 
//	auteur:					jcb
//	description:		
//	version:					1.0
//	maj le:					29/10/2008 
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backpath = "../";
require($backpath."html.php");
require $backpath.'utilitaires/globals_string_lang.php';
include_once($backpath."dbConnection.php");
include_once($backpath."login/init_security.php");
$langue = $_SESSION['langue'];

print("<HTML><HEAD>");
print("<title>menu PPI</title>");
print("<LINK REL=\"stylesheet\" HREF=\"ppi.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM name=\"arh\" method=\"get\" ACTION=\"arh_data_samu.php\" target=\"middle\">");
//$string_lang[$langue]["INTROCUCTION"];
?>
<ul id="menu">
	<li><a href="../blocnote/blocnote_lire.php" target="middle"><?php echo('Main courante');?></a>
	<li><a href="../intervenants_org.php" target="middle"><?php echo('Organisation');?></a>
	<li><a href="../pma/pma_frameset.php?back=../ppi/ppi_frameset.php" target="middle"><?php echo('Structures');?></a>
</ul>
<ul id="menu_ppi">
<?php
	$requete = "SELECT ppi_ID,ppi_nom,ppi_dossier FROM ppi ORDER BY ppi_ID";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		if(!$rub['ppi_dossier']) $rub['ppi_dossier'] = "ppi_dow/ppi_dow.php";
		$dest = $rub['ppi_dossier']."?id=".$rub['ppi_ID']."&nom=".$rub['ppi_nom'];
		print("<li><a href=\"$dest\" target=\"middle\">".Security::db2str($rub['ppi_nom'])."</a>");
	}
?>
</ul>
<?
print("</form>");
print("</body>");
print("</html>");
?>
