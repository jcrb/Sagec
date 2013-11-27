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
//----------------------------------------- SAGEC ---------------------------------------------
//
//	programme: 		intervenants_badges.php
//	date de création: 	18/08/2008
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			18/08/2008
//
//---------------------------------------------------------------------------------------------
/**
* Règles applicables à la saisie des victimes
* 
* Limiter le nombre d'hôpital à afficher
*/
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
$path="";
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require($path."pma_requete.php");
require($path."pma_connect.php");
require($path."pma_connexion.php");
$connexion = connexion(NOM,PASSE,BASE,SERVEUR);
?>

<head><meta http-equiv="content-type" content="ent="text; charset=ISO-8859-1" >
<script>
	
</script>
</head>

<body>
	<form name="selection" action="pdf/badges.php" method="post">
	<p>Sélectionner les personnes à badger, puis <input type="submit" name="VALIDER" value="VALIDER"></p>
<?php

$requete = "SELECT Pers_ID,Pers_Nom, Pers_Prenom,org_nom 
				FROM personnel,organisme
				WHERE personnel.org_ID = organisme.org_ID
				ORDER BY Pers_Nom";
$resultat = ExecRequete($requete,$connexion);
//$listeID = 1;//NE PAS MODIFIER
print("<table>");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td align=\"left\"><input type=\"checkbox\" name=\"ch[]\" value=\"$rub[Pers_ID]\" ></td>");
		print("<td>$rub[Pers_Nom]</td>");
		print("<td>$rub[Pers_Prenom]</td>");
		print("<td>$rub[org_nom]</td>");
	print("</tr>");
}
print("</table>");
?>
</form>
</body>