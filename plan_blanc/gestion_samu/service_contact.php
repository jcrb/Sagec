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
//	programme: 		service_contact.php
//	création: 		08/08/2009
//	auteur:			jcb
//	description:	Affiche la liste des hôpitaux à contacter
//	version:			1.0
//	maj le:			08/08/2009
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
$listeID = 4;//NE PAS MODIFIER

print("<p>Liste des services à contacter</p>");

// on récupère la liste des services actifs
$requete = "SELECT service_visible.service_ID,service_nom,Hop_nom,hopital.Hop_ID
				FROM service_visible,hopital,service
				WHERE service_visible.org_ID = '$_SESSION[organisation]'
				AND liste_ID = '$listeID'
				AND service_visible.Hop_ID = hopital.Hop_ID
				AND service.service_ID = service_visible.service_ID
				";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
while($rep = mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td bgcolor=\"#FFFF66\">".$rep[service_ID]."</td>");
		print("<td bgcolor=\"#FFFF99\">".$rep[Hop_nom]."</td>");
		print("<td bgcolor=\"#FFFF99\">".$rep[service_nom]."</td>");
		print("<td  bgcolor=\"#CCFF99\"><a href=\"service_renseignement.php?serviceID=$rep[service_ID]&servicenom=$rep[service_nom]&hopID=$rep[Hop_ID]\"> contact </a></td>");
	print("</tr>");
}
print("</table>");

?>