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
//	programme: 		hopitaux_contact.php
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
include_once($backPathToRoot."login/init_security.php");

$listeID = 4;//NE PAS MODIFIER

print("<p>Liste des hôpitaux à contacter</p>");
print("<p><a href=\"hopitaux_affiche.php\">Modifier la liste</a></p>");

// on récupère la liste des hôpitaux actifs
$requete = "SELECT hopital_visible.Hop_ID,Hop_nom
				FROM hopital_visible,hopital
				WHERE hopital_visible.org_ID = '$_SESSION[organisation]'
				AND liste_ID = '$listeID'
				AND hopital_visible.Hop_ID = hopital.Hop_ID
				";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
while($rep = mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td bgcolor=\"#FFFF66\">".$rep[Hop_ID]."</td>");
		print("<td bgcolor=\"#FFFF99\">".Security::db2str($rep[Hop_nom])."</td>");
		print("<td  bgcolor=\"#CCFF99\"><a href=\"hopital_renseignement.php?hopID=$rep[Hop_ID]&hopnom=$rep[Hop_nom]\"> contact </a></td>");
	print("</tr>");
}
print("</table>");

?>