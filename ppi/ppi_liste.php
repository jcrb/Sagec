<?php
/**
//----------------------------------------- SAGEC -------------------------------
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
//
//----------------------------------------- SAGEC --------------------------------
/**
//	programme: 				ppi_liste.php
//	date de création: 	14/08/2008
//	@author:					jcb
//	description:
//	@version:				1.0
//	maj le:					14/08/2008
//--------------------------------------------------------------------------------
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
$backpath = "../";
include_once($backpath."dbConnection.php");
include_once($backpath."login/init_security.php");

// ENTETE
print("<html>");
print("<head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\">");
print("<title> Liste des PPI </title>");
print("<meta name=\"author\" content=\"JCB\">");
print("<LINK REL=stylesheet HREF=\"../ppi/ppi.css\" TYPE =\"text/css\">");
print("</head>");

$requete = "SELECT * FROM ppi";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
$ligne_i=0;
while($rub=mysql_fetch_array($resultat))
{
	//print("<tr echo ($ligne_i++ % 2 == 1) ? 'class=\"impaire\"' :'class=\"paire\"' >");
	?>
	<tr <?php echo($ligne_i++ % 2 == 1) ? ' class="impaire"' : ' class="paire"' ; ?> >
	<?php
		print("<td>$rub[ppi_ID]</td>");
		print("<td>".Security::db2str($rub[ppi_nom])."</td>");
		print("<td>".Security::db2str($rub[ppi_activite])."</td>");
		print("<td>$rub[ppi_date]</td>");
		print("<td><a href=\"ppi_structures_actives.php?id=$rub[ppi_ID]&nom=$rub[ppi_nom]\"> voir</a></td>");
		print("<td><a href=\"ppi_nouveau.php?id=$rub[ppi_ID]\"> modifier</a></td>");
		print("<td><a href=\"ppi_structure_activation.php?id=$rub[ppi_ID]&action=activer\"> activer</a></td>");
		print("<td><a href=\"ppi_structure_activation.php?id=$rub[ppi_ID]&action=desactiver\"> désactiver</a></td>");
		print("<td><a href=\"ppi_synthese.php?id=$rub[ppi_ID]\"> synthèse</a></td>");
	print("</tr>");
}
print("</table>");
?>