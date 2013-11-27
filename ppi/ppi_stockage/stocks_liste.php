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
//	programme: 				stocks_liste.php
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
$backPathToRoot = "../../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");

// ENTETE
print("<html>");
print("<head>
<meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\">");
print("<title> Liste des Stockages industriels </title>");
print("<meta name=\"author\" content=\"JCB\">");
print("<LINK REL=stylesheet HREF=\"../ppi.css\" TYPE =\"text/css\">");
print("</head>");

$requete = "SELECT stocki_ID,stocki_nom,ppi_nom
				FROM stockage_industriel,ppi
				WHERE ppi.ppi_ID = stockage_industriel.ppi_ID
				ORDER BY ppi_nom,stocki_nom
				";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
$ligne_i=0;
while($rub=mysql_fetch_array($resultat))
{
	//print("<tr echo ($ligne_i++ % 2 == 1) ? 'class=\"impaire\"' :'class=\"paire\"' >");
	?>
	<tr <?= ($ligne_i++ % 2 == 1) ? ' class="impaire"' : ' class="paire"' ; ?>>
	<?php
		print("<td>$rub[stocki_ID]</td>");
		print("<td>".Security::db2str($rub[ppi_nom])."</td>");
		print("<td>".Security::db2str($rub[stocki_nom])."</td>");
		print("<td><a href=\"ppi_stock.php?id=$rub[stocki_ID]\"> voir</a></td>");
	print("</tr>");
}
print("</table>");
?>