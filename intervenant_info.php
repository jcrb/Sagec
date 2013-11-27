<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
//---------------------------------------------------------------------------------------------------------
//
//	programme: 		intervenant_info
//	date de création: 	25/10/2004
//	auteur:			jcb
//	description:		coordonnées de base d'un intervenant
//	version:			1.0
//	maj le:			25/10/2004
//
//---------------------------------------------------------------------------------------------------------
// A FAIRE: améliorer la présentation du tableau
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");

print("<head>");
print("<title> annuaire </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$contact_ID = $_REQUEST['personne_id'];
$nature_contact = $_REQUEST['nature_contact'];
$nom_contact = $_REQUEST['nom'];

print("<h4>$nom_contact</h4>");

$requete = "SELECT contact_nom, valeur
			FROM contact
			WHERE nature_contact_ID = '$nature_contact'
			AND identifiant_contact = '$contact_ID'
			AND contact_lieu = '2'
			AND type_contact_ID IN ('1','2','3')
			";
$resultat = ExecRequete($requete,$connexion);

print("<table width=\"100\" class=\"tel\">");
print("<tr>");
		print("<td>poste</td>");
		print("<td>tel</td>");
	print("</tr>");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td>$rub[contact_nom]</td>");
		print("<td>$rub[valeur]</td>");
	print("</tr>");
}
print("</table>");
?>