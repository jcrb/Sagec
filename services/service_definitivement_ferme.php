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
//----------------------------------------- SAGEC --------------------------------------------------------
/**
*	programme: 		service_definitivement_ferme.php
*	@date de création: 	23/05/2008
*	@author:			jcb
*	description:	gestion des services définitivements fermés
*	@version:		1.1 
*	maj le:			
*	@package		Sagec
*/
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
if(!($_SESSION['auto_hopital']||$_SESSION['auto_service']||$_SESSION['auto_organisme']))header("Location:../logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$back = "../sagec3/lits_service.php";

print("<p>Liste des services définitivements fermés</p>");

$requete = "SELECT service_ID, service_nom FROM service WHERE Priorite_Alerte = 9";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
while($rep = mySql_Fetch_Array($resultat))
{
	print("<tr>");
		print("<td><a href=\"../services.php?ttservice=$rep[service_ID]&back=$back\">voir</a></td>");
		print("<td>$rep[service_nom]</td>");
	print("</tr>");
}
print("</table>");

?>