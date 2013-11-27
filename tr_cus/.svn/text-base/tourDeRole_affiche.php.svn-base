<?php
//----------------------------------------- SAGEC --------------------------------------------------------
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
//----------------------------------------- SAGEC ---------------------------------------------//
//
//	programme: 		tourDeRole_affiche.php
//	date de cr?ation: 	15/09/2004
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			11/04/2004
//
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");

print("<head>");
print("<title>DASS </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete = 	"SELECT date,dossier,dispo,org_nom
			FROM apa_tour_enregistre,organisme
			WHERE organisme.org_ID = apa_tour_enregistre.org_ID
			ORDER BY date DESC
			LIMIT 100";
$resultat = ExecRequete($requete,$connexion);
print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
while($rub=mysql_fetch_array($resultat))
{
	print("<TR>");
		print("<TD>$rub[date]</TD>");
		print("<TD align=\"right\">$rub[dossier]</TD>");
		print("<TD>$rub[org_nom]</TD>");
		if($rub[dispo]=='o')
			print("<TD>disponible</TD>");
		else
			print("<TD>indisponible</TD>");
	print("</TR>");
}
print("</table>");
?>
