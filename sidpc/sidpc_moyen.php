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
//	programme: 				crise.php
//	@date de création: 	12/08/2008
//	@author:					jcb
//	description:
//	@version:				1.0
//	maj le:			
// @version $Id$
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_apa'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
require("../pma_requete.php");
require("../pma_connect.php");
require("../pma_connexion.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

//======================= En Tête ====================================
print("<HTML><HEAD>");
print("<TITLE>a</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</HEAD>");
//====================== Corps =======================================
print("<BODY>");
print("<FORM NAME=\"\" ACTION=\"\" METHOD=\"POST\">");

/** liste des moyens engagés */

print("<fieldset><legend>Moyens engagés</legend>");
$requete = "SELECT Vec_ID,Vec_nom,org_nom,ts_nom
				FROM vecteur,organisme,temp_structure
				WHERE Vec_Engage = 'o'
				AND organisme.org_ID = vecteur.org_ID
				AND ts_ID = localisation_ID
				ORDER BY localisation_ID,Vec_Type,Org_nom
				";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
while($rub = MySql_Fetch_Array($resultat))
{
	print("<tr>");
		print("<td>".$rub['org_nom']."</td>");
		print("<td>".$rub['Vec_nom']."</td>");
	print("</tr>");
}
print("</table>");
print("</fieldset>");

/** liste des moyens disponibles */

print("<fieldset><legend>Moyens disponibles</legend>");
$requete = "SELECT Vec_ID,Vec_nom,org_nom
				FROM vecteur,organisme
				WHERE Vec_Etat = 2
				AND Vec_Engage <> 'o'
				AND organisme.org_ID = vecteur.org_ID
				ORDER BY Vec_Type,Org_nom
				";
$resultat = ExecRequete($requete,$connexion);

print("<table>");
while($rub = MySql_Fetch_Array($resultat))
{
	print("<tr>");
		print("<td>".$rub['org_nom']."</td>");
		print("<td>".$rub['Vec_nom']."</td>");
	print("</tr>");
}
print("</table>");
print("</fieldset>");

print("</FORM>");
print("</BODY>");
print("</HTML>");
?>