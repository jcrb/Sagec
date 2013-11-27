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
//	programme: 				ppi_synthese.php
//	date de création: 	10/12/2009
//	@author:					jcb
//	description:
//	@version:				1.0
//	maj le:					10/12/2009
//--------------------------------------------------------------------------------
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backpath = "../";
include_once($backpath."dbConnection.php");
include_once($backpath."login/init_security.php");

$ppi = $_REQUEST[id];
/**
*	header
*/
?>
<html>
	<head>
		<meta http-equiv="content-type" content=""text/htm; charset=ISO-8859-15" >
		<link rel="shortcut icon" href="../images/sagec67.ico" />
		<TITLE>PPI Synthèse</TITLE>
		<LINK REL=stylesheet HREF="../pma.css" TYPE ="text/css">
		<link href="../../css/imp.css" rel="stylesheet" media="print" type="text/css" />
	</head>
	<body>
		<form name="synthese">
<?php
/**
*	caractéristiques générales
*/
$requete = "SELECT * FROM ppi WHERE ppi_ID = '$ppi'";
$resultat = ExecRequete($requete,$connexion);
$rub=mysql_fetch_array($resultat);
print("<h1>".Security::db2str($rub[ppi_nom])."</h1><br>");
print("<table class=\"A3\" border=\"1\" cellspacing=\"0\">");
	print("<tr>");
		print("<td>Identifiant</td>");
		print("<td>$rub[ppi_ID]</td>");
	print("</tr>");
	print("<tr>");
		print("<td>Activité</td>");
		print("<td>".Security::db2str($rub[ppi_activite])."</td>");
	print("</tr>");
	print("<tr>");
		print("<td>Mise à jour</td>");
		print("<td>$rub[ppi_date]</td>");
	print("</tr>");
	print("<tr>");
		print("<td>Adresse</td>");
		print("<td>".Security::db2str($rub[adresse_ID])."</td>");
	print("</tr>");
	print("<tr>");
		print("<td>Latitude</td>");
		print("<td>$rub[center_lat]</td>");
	print("</tr>");
	print("<tr>");
		print("<td>Longitude</td>");
		print("<td>$rub[center_lng]</td>");
	print("</tr>");
print("</table>");

print("<p>Stockages</p>");
$requete = "SELECT * 
				FROM stockage_industriel,stockage_conteneur,produitsChimiques
				WHERE ppi_ID = '$ppi'
				AND stocki_type = stockage_conteneur_ID
				AND produit_ID = chem_ID
				";
$resultat = ExecRequete($requete,$connexion);
print("<table  border=\"1\" cellspacing=\"0\">");
print("<tr>");
	print("<th>&nbsp;</th>");
	print("<th>nom</th>");
	print("<th>conteneur</th>");
	print("<th>diamètre (m)</th>");
	print("<th>hauteur</th>");
	print("<th>Quantité (m3)</th>");
	print("<th>produit</th>");
	print("<th>no</th>");
	print("<th>UN</th>");
	print("<th>CAS</th>");
	print("<th>R1</th>");
	print("<th>R2</th>");
	print("<th>R3</th>");
print("</tr>");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td>Stock</td>");
		print("<td>".Security::db2str($rub[stocki_nom])."</td>");
		print("<td>".$rub[stockage_conteneur_nom]."</td>");
		print("<td>$rub[stocki_diametre]</td>");
		print("<td>$rub[stocki_hauteur]</td>");
		print("<td>$rub[stocki_qte]</td>");
		print("<td>".Security::db2str($rub[chem_nom])."</td>");
		print("<td>$rub[chem_no]</td>");
		print("<td>$rub[chem_un]</td>");
		print("<td>$rub[chem_cas]</td>");
		print("<td>$rub[stocki_rayon1]</td>");
		print("<td>$rub[stocki_rayon2]</td>");
		print("<td>$rub[stocki_rayon3]</td>");
	print("</tr>");
}
print("</table>");

print("<p>Structures temporaires</p>");
$requete = "SELECT *
				FROM temp_structure AS a,ppi_structures_actives AS b,local_type AS c
				WHERE b.ppi_ID = '$ppi'
				AND b.ts_ID = a.ts_ID
				AND a.ts_type = c.local_type_ID
				ORDER BY ts_type
				";
$resultat = ExecRequete($requete,$connexion);
print("<table border=\"1\" cellspacing=\"0\">");
print("<tr>");
	print("<th>&nbsp;</th>");
	print("<th>nom</th>");
	print("<th>type</th>");
	print("<th>localisation</th>");
	print("<th>contact</th>");
	print("<th>latitude</th>");
	print("<th>longitude</th>");
	print("<th>parent</th>");
print("</tr>");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td>$rub[ts_ID]</td>");
		print("<td>".Security::db2str($rub[ts_nom])."</td>");
		print("<td>$rub[local_type_nom]</td>");
		print("<td>".Security::db2str($rub[ts_localisation])."</td>");
		print("<td>".Security::db2str($rub[ts_contact])."</td>");
		print("<td>$rub[ts_lat]</td>");
		print("<td>$rub[ts_long]</td>");
		print("<td>$rub[ts_parent_ID]</td>");
	print("</tr>");
}
print("</table>");
?>
</form>
</body>
</html>