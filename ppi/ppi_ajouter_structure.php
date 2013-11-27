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
//	programme: 				ppi_ajouter_structure.php
//	date de création: 	14/08/2008
//	@author:					jcb
//	description:			Associe des structures temporaires à un PPI
//	@version:				1.0
//	maj le:					14/08/2008
//--------------------------------------------------------------------------------
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
$backPathToRoot = "../";
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");

// r�cup�re le ppi 
$ppi_id = $_REQUEST['id'];

print("<head>");
print("<title>Associe PPI Structure temporaire</title>");
print("<LINK REL=stylesheet HREF=\"ppi.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM name=\"arh\" method=\"post\" ACTION=\"ppi_ajouter_structure.php?id=$ppi_id\" target=\"bottom\">");

/** 
*	analyse et enregistre 
*/
if($_REQUEST['ok']=="enregistrer")
{
	//$comma_separated = "'".implode("','", $_REQUEST['ch'])."'";
	// active les cases cochées
	$requete = "DELETE FROM ppi_structures_actives WHERE ppi_ID = '$ppi_id'";
	ExecRequete($requete,$connexion);
	// désactive les cases non cochées 
	for($i=0;$i<count($_REQUEST['ch']);$i++)
	{
		$j = $_REQUEST['ch'][$i];
		$requete = "INSERT ppi_structures_actives VALUES('','$ppi_id','$j')";
		ExecRequete($requete,$connexion);
	}
}

/** 
*	main 
*/
$requete = "SELECT Ts_ID,Ts_nom,Ts_localisation,Ts_active,local_type_code
				FROM temp_structure, local_type
				WHERE Ts_type = local_type_ID
				ORDER BY Ts_type";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
	print("<tr>");
		print("<td>Nom</td>");
		print("<td>Type</td>");
		print("<td>Localisation</td>");
		print("<td>Liaison</td>");
		print("<td>&nbsp;</td>");
		print("<td> enregistrer les modification <input type=\"submit\" name=\"ok\" value=\"enregistrer\"></td>");
	print("</tr>");
while($rub = MySql_Fetch_Array($resultat))
{
	?>
	<tr <?= ($ligne_i++ % 2 == 1) ? ' class="impaire"' : ' class="paire"' ; ?>>
	<?php
		print("<td>".Security::db2str($rub[Ts_nom])."</td>");
		print("<td>$rub[local_type_code]</td>");
		print("<td>".Security::db2str($rub[Ts_localisation])."</td>");
		
		// recherche si la structure est déjà associée au PPI 
		$requete = "SELECT ppi_ts_ID FROM ppi_structures_actives WHERE ppi_ID = '$ppi_id' AND ts_ID = '$rub[Ts_ID]'";
		$resultat2 = ExecRequete($requete,$connexion);
		$ts = MySql_Fetch_Array($resultat2);
		if($ts['ppi_ts_ID']) $check = "checked";else $check="";
		
		print("<td align=\"center\"><input type=\"checkbox\" name=\"ch[]\" value=\"$rub[Ts_ID]\" $check></td>");//
		print("<td><a href=\"../pma/structure_temp.php?ts_IDField=$rub[Ts_ID]\">voir</a></td>");
	print("</tr>");
}
print("</table>");
?>