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
//	programme: 		arh_middlesup.php
//	date de cr?ation: 	02/03/2005
//	auteur:			jcb
//	description:		Fonctionalit? permise ? l'administrateur
//	version:			1.2
//	maj le:			14/05/2005
//
//--------------------------------------------------------------------------------
//
include("../../date.php");
include ("arh_utilitaire.php");

print("<form name=\"\" method=\"get\" action=\"arh_resultat.php\" target=\"middle\">");
$select=$_GET['select'];
//print($select);
switch($select)
{
	case region:
		print("Analyse par région: <br>");
		print("<select name=\"region\" size=\"1\">");
			print("<option value=\"0\">-- Sélectionner une région --</option>");
			print("<option value=\"1\">Alsace</option>");
		print("</select>");
		break;
	case departement:
		print("Analyse par département: <br>");
		print("<select name=\"departement\" size=\"1\">");
			print("<option value=\"0\">-- Sélectionner un département --</option>");
			print("<option value=\"1\">67</option>");
			print("<option value=\"2\">68</option>");
		print("</select>");
		break;
	case territoire:
		print("Analyse par territoire de santé: <br>");
		print("<select name=\"territoire\" size=\"1\">");
			print("<option value=\"0\">-- Sélectionner un territoire --</option>");
			print("<option value=\"1\">1.Haguenau</option>");
			print("<option value=\"2\">2.Strasbourg</option>");
			print("<option value=\"3\">3.Colmar</option>");
			print("<option value=\"4\">4.Mulhouse</option>");
		print("</select>");
		break;
	case zone_proximite:
		print("Analyse par zone de proximité: <br>");
		print("<select name=\"zone_proximite\" size=\"1\">");
			print("<option value=\"0\">-- Sélectionner une zone --</option>");
			for($i=0;$i<$nb_zone;$i++)
			{
				$j = $i+1;
				print("<option value=\"$j\">$zones[$i]</option>");
			}
		print("</select>");
		break;
}
$j = aujourdhui();
print(" date1:<input type=\"text\" name=\"date1\" value=\"$j\" size=\"8\">");
print(" date2:<input type=\"text\" name=\"date2\" value=\"$j\" size=\"8\">");
print("<input type=\"submit\" name =\"valider\" value=\"valider\">");
print("</form>");
?>