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
//	programme: 				ppi_structure_activation.php
//	date de création: 	14/08/2008
//	@author:					jcb
//	description:			Active toutes les structures temporaires associées à un PPI
//	@version:				1.0
//	maj le:					14/08/2008
//--------------------------------------------------------------------------------
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>8) header("Location:../logout.php");
$backpath = "../";
include_once($backpath."dbConnection.php");
include_once($backpath."login/init_security.php");
// récup_re le ppi 
$ppi_id = $_REQUEST['id'];
// action à entreprendre, activation ou désactivation
$action = $_REQUEST['action'];
$mysqldate = date( 'Y-m-d H:i:s', time());

$requete = "SELECT ts_ID FROM ppi_structures_actives WHERE ppi_ID = '$ppi_id'";
$resultat = ExecRequete($requete,$connexion);
if($action == "activer")
{
	while($rub=mysql_fetch_array($resultat))
	{
		$requete2 = "UPDATE temp_structure SET ts_active = 'o',ts_heure_activation='$mysqldate' WHERE ts_ID = '$rub[ts_ID]'";
		ExecRequete($requete2,$connexion);
	}
	$requete = "UPDATE ppi SET ppi_actif = 'o' WHERE ppi_ID = '$ppi_id'";
	ExecRequete($requete,$connexion);
}
else
{
	while($rub=mysql_fetch_array($resultat))
	{
		$requete2 = "UPDATE temp_structure SET ts_active = 'n',ts_heure_arret='$mysqldate' WHERE ts_ID = '$rub[ts_ID]'";
		ExecRequete($requete2,$connexion);
	}
	$requete = "UPDATE ppi SET ppi_actif = 'n' WHERE ppi_ID = '$ppi_id'";
	ExecRequete($requete,$connexion);
}
//print($requete);

// affichage du résultat
$requete = "SELECT ppi.ppi_ID,ppi_nom, ts_nom, temp_structure.ts_ID
				FROM ppi,temp_structure,ppi_structures_actives
				WHERE ppi.ppi_actif = 'o'
				AND ppi.ppi_ID = ppi_structures_actives.ppi_ID
				AND  temp_structure.ts_ID = ppi_structures_actives.ts_ID
				";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
	print("<tr>");
		print("<th>PPI actif(s)</th>");
		print("<th>Structure(s) active(s)</th>");
	print("</tr>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<tr>");
			print("<td>".Security::db2str($rub[ppi_nom])."</td>");
			print("<td>".Security::db2str($rub[ts_nom])."</td>");
		print("</tr>");
	} 
print("</table>");
?>