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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		stat_connexion.php
//	date de création: 	10/08//2005
//	auteur:			jcb
//	description:		statistiques sur les connexions
//	version:			1.0
//	maj le:			10/08//2005
//
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$requete="SELECT DAYOFYEAR(connexion_date), count(connexion_ID) FROM connexion GROUP BY 1";
//$requete="SELECT DAY(connexion_date), count(connexion_ID) FROM connexion GROUP BY 1";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
print("<tr>");
	print("<td>date</td>");
	print("<td>connexions</td>");
print("</tr>");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td>".$rub[0]."</td>");
		print("<td>".$rub[1]."</td>");
	print("</tr>");
}
print("</table>");
?>