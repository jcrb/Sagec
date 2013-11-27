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
//												//
//	programme: 		service_pret_personnel.php						//
//	date de création: 	18/08/2003							//
//	auteur:			jcb								//
//	description:										//
//	version:		1.0								//
//	maj le:			26/12/2003
//												//
//---------------------------------------------------------------------------------------------//
session_start();
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
print("<title> menu service </title>");
print("<LINK REL=\"stylesheet\" HREF=\"service.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY>");

?>

<table width="100%" border="1" bordercolor="#660066">
  <!--DWLayoutTable-->
  <tr>
    <td width="21%"><div align="center"><img src="../images/Logo_SAGEC3.gif" width="156" height="79"></div></td>
    <td width="79%"><img src="../images/ConstructionWorker.gif" width="156" height="79"></td>
  </tr>
</table>
<p>&nbsp;</p>

<?php
print("Page en cours de construction...<BR>");
print("Objectif: mettre à disposition du personnel pour d'autres services.");
print("<br>");
print("<br>");
print("Page under construction...<BR>");
print("Objective: personnel being able to be lent to other services .");
print("<br>");
print("<br>");
print("Seite im Laufe des Baus...<BR>");
print("Personal, das anderen Diensten geliehen werden kann.");

$requete ="SELECT service_ID,service_nom
			FROM service
			WHERE service_ID = '$_SESSION[service]'
			";
$resultat = ExecRequete($requete,$connexion);
//print($requete);
$i = LigneSuivante($resultat);
print("<div class=\"navy10\">Service: $i->service_nom<br></div><br>");
print("<div CLASS=\"navy10\">Personnels pouvant être mis à disposition d'une autre structure</div><br>");
print("<table>");
	print("<tr>");
		print("<td> médecins</td>");
		print("<td><input type=\"text\" name=\"med\" value=\"\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td> Infirmier(e)</td>");
		print("<td><input type=\"text\" name=\"ide\" value=\"\"></td>");
	print("</tr>");
		print("<tr>");
		print("<td> Cadres de santé</td>");
		print("<td><input type=\"text\" name=\"cadre_sante\" value=\"\"></td>");
	print("</tr>");

	print("</tr>");
		print("<tr>");
		print("<td> &nbsp;</td>");
		print("<td><input type=\"submit\" name=\"ok\" value=\"valider\"></td>");
	print("</tr>");
print("</table>");
/*
print("Page en cours de construction...<BR>");
print("Objectif: recenser les personnels disponibles pour renforcer d'autres équipes en cas de catastrophe.");
print("<br>");
print("<br>");
print("Page under construction...<BR>");
print("Objective: List the available staffs to strengthen the other teams in case of disaster.");
print("<br>");
print("<br>");
print("Seite im Laufe des Baus...<BR>");
print("Die verfügbaren Personalien aufzählen, um andere Mannschaften im Falle der Katastrophe zu verstärken.");
*/
print("</BODY>");
print("</html>");
?>
