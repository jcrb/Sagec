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
/**
//	programme: lits_par_specialite.php	
//	date de crÃ©ation: 	
//	@author:			jcb
//	description:		
//	@version $Id$
//	maj le:			
* 	@package Sagec
*/
//-----------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("../pma_connect.php");
require_once("../pma_connexion.php");
require_once("../pma_requete.php");
require_once("../date.php");
require_once("../utilitairesHTML.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<form name=\"specialite\"method=\"post\">");
print("<table>");
	print("<tr>");
		print("<td>Spécialité</td>");
		print("<td>");
			select_specialite($connexion,$item_select,$langue,$change="");// ID_specialite
				$item_select = 2;
			SelectTypeService($connexion,$item_select,$langue);// type_s
		print("</td>"); // return D_specialite
		print("<td>&nbsp;</td>");
	print("</tr>");
	print("<tr>");
		print("<td>Territoire</td>");
		print("<td> </td>");
		print("<td>&nbsp;</td>");
	print("</tr>");
	print("<tr>");
		print("<td>date 1</td>");
		$du = date("j/m/Y",date("U")-60*24*60*60);
		print("<td><input type=\"text\" name=\"date1\" value=\"$du\"></td>");
		print("<td></td>");
	print("</tr>");
	print("<tr>");
		print("<td>date2</td>");
		$au = date("j/m/Y");
		print("<td><input type=\"text\" name=\"date2\" value=\"$au\"></td>");
	print("<td><input type=\"submit\" name=\"ok\" value=\"affiche\"</td>");
	print("</tr>");
print("</table>");

if($_REQUEST['ok'])
{
	$date1 = fDate2unix($_REQUEST[date1]);
	$date2 = fDate2unix($_REQUEST[date2]);
	$requete="SELECT DATE_FORMAT(FROM_UNIXTIME(date),'%e/%m/%Y'),date,SUM(lits_dispo),lits_journal.service_ID
					FROM lits_journal,service
					WHERE date BETWEEN '$date1' AND '$date2'
					AND lits_journal.service_ID = service.service_ID
					AND service.type_ID = '$_REQUEST[type_s]'
					GROUP BY 1
					ORDER BY 2
					";
			
	// print($requete."<br>");
	$resultat = ExecRequete($requete,$connexion);
	$n = 0; // nb de lignes générées
	$f=fopen('data.txt',"w+");
	print("<table border=\"1\" cellspacing=\"0\">");
	print("<tr><td>Date</td><td>nombre</td></tr>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<tr>");
			print("<td>$rub[0]</td><td align=\"middle\">$rub[2]</td>");
			$param = $rub[0]."\t".$rub[2]."\n";
			fwrite($f,$param);
			$n++;
		print("</tr>");
	}
	fclose($f);
	print("</table>");
	//$data = file('data.txt');// attention la ligne 0 contient les intitulés des colonnes
	//print_r($data);
}
$file = "data.txt";
print("<a href=\"veille_specialite_graphe.php?service=$service&recul=50&file=$file\">Graphe</a><br>");
?> 
