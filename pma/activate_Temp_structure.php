<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------
//
//	programme: 				activate_Temp_structure.php
//	date de création: 	08/08/2008
//	auteur:					jcb
//	description:		
//	version:					1.0
//	maj le:					
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
include_once("dbConnection.php");
include_once($backPathToRoot."login/init_security.php");

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../brules/brule.css\" TYPE =\"text/css\"></HEAD>");

print("<head>");
print("<title>menu assu</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM name=\"arh\" method=\"post\" ACTION=\"activate_Temp_structure.php\" target=\"middle\">");

/** analyse et enregistre */
if($_REQUEST['ok']=="enregistrer")
{
	$comma_separated = implode("','", $_REQUEST['ch']);
	// active les cases cochées
	$requete = "UPDATE temp_structure SET Ts_active = 'o' WHERE ts_ID IN('$comma_separated')";
	$resultat = ExecRequete($requete,$connexion);
	// désactive les cases non cochées 
	$requete = "UPDATE temp_structure SET Ts_active = '' WHERE ts_ID NOT IN('$comma_separated')";
	$resultat = ExecRequete($requete,$connexion);
}
/** main */
$requete = "SELECT Ts_ID,Ts_nom,Ts_localisation,Ts_active,local_type_code
				FROM temp_structure, local_type
				WHERE Ts_type = local_type_ID
				ORDER BY Ts_type,Ts_nom";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
	print("<tr>");
		print("<td>Nom</td>");
		print("<td>Type</td>");
		print("<td>Localisation</td>");
		print("<td>Activation</td>");
		print("<td>&nbsp;</td>");
		print("<td> enregistrer les modification <input type=\"submit\" name=\"ok\" value=\"enregistrer\"></td>");
	print("</tr>");
while($rub = MySql_Fetch_Array($resultat))
{
	print("<tr>");
		print("<td>".Security::db2str($rub[Ts_nom])."</td>");
		print("<td>$rub[local_type_code]</td>");
		print("<td>".Security::db2str($rub[Ts_localisation])."</td>");
		if($rub[Ts_active]=="o") $check = "checked";else $check="";
		print("<td align=\"center\"><input type=\"checkbox\" name=\"ch[]\" value=\"$rub[Ts_ID]\" $check></td>");//
		print("<td><a href=\"structure_temp.php?ts_IDField=$rub[Ts_ID]\">voir</a></td>");
	print("</tr>");
}
print("</table>");
?>