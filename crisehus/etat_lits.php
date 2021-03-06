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
/**												
*	programme: 		etat_lits.php							
*	date de cr�ation: 	18/08/2003							
*	auteur:			jcb									
*	description:		Lire le contenu du bloc-notes						
*				par ordre chronologique inverse						
*	@version:		$Id: etat_lits.php 36 2008-02-22 16:05:49Z jcb $									
*	maj le:			09/04/2004								
*/												
//--------------------------------------------------------------------------------------------------------
// la liste s'affiche par ordre cronologique inverse
// la liste est rafraichie toutes les 30 secondes
// le nom du r�dacteur apparait
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require("../html.php");
require("../date.php");

print("<FORM name=\"lits\" method=\"post\" action=\"etat_lits.php\">");

print("<table>");
	print("<tr>");
		print("<td><input type=\"checkbox\" name=\"hcl\"> HC</td>");
		print("<td><input type=\"checkbox\" name=\"htp\"> HTP</td>");
		print("<td><input type=\"checkbox\" name=\"ccom\"> CCOM</td>");
		print("<td><input type=\"checkbox\" name=\"nhc\"> NHC</td>");
		print("<td> sp�cialit�s<input type=\"text\" name=\"hc\"></td>");
		print("<td><input type=\"submit\" name=\"ok\" value=\"Afficher\"></td>");
	print("</tr>");
print("</table>");

if($_REQUEST['ok']=='Afficher')
{
	$structure ="'0'";
	$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
	if($_REQUEST['hcl']) $structure .= ",'2'";
	if($_REQUEST['htp']) $structure .= ",'1'";
	if($_REQUEST['ccom']) $structure .= ",'3'";

	$requete = "SELECT hop_nom, service_nom, lits_sp, lits_supp, lits_occ, lits_liberable, lits_dispo,date_maj,type_nom
					FROM hopital, service, lits, type_service
					WHERE hopital.Hop_ID IN ($structure)
					AND service.Hop_ID = hopital.Hop_ID
					AND lits.service_ID = service.service_ID
					AND service.type_ID = type_service.type_ID
					AND Priorite_Alerte < 9
					";

	$result = ExecRequete($requete,$connect);
	//print($requete);
	print("<table>");
		print("<tr>");
			print("<th>H�pital</th>");
			print("<th>Service</th>");
			print("<th>Specialite</th>");
			print("<th>Lits disponibles</th>");
			print("<th>Lits lib�rables</th>");
			print("<th>Lits install�s</th>");
			print("<th>Lits sup.</th>");
			print("<th>MAJ</th>");
		print("</tr>");
	while($rep=mySql_fetch_array($result))
	{
		print("<tr>");
			print("<td>".$rep['hop_nom']."</td>");
			print("<td>".$rep['service_nom']."</td>");
			print("<td>".$rep['type_nom']."</td>");
			print("<td align=\"center\">".$rep['lits_dispo']."</td>");
			print("<td align=\"center\">".$rep['lits_liberables']."</td>");
			print("<td align=\"center\">".$rep['lits_sp']."</td>");
			print("<td align=\"center\">".$rep['lits_supp']."</td>");
			print("<td align=\"right\">".uDate2Frenchdatetime($rep['date_maj'])."</td>");
		print("</tr>");
	}
	print("</table>");
	
	print("<br>");
	
	print("<table>");
		print("<tr>");
			print("<th>Sp�cialit�</th>");
			print("<th>lits disponibles</th>");
			print("<th>lits install�s</th>");
		print("</tr>");
	$requete = "SELECT  SUM(lits_dispo),SUM(lits_sp), type_nom
					FROM hopital, service, lits, type_service
					WHERE hopital.Hop_ID IN ($structure)
					AND service.Hop_ID = hopital.Hop_ID
					AND lits.service_ID = service.service_ID
					AND service.type_ID = type_service.type_ID
					GROUP BY type_nom
					";
	$result = ExecRequete($requete,$connect);
	while($rep=mySql_fetch_array($result))
	{
		print("<tr>");
			print("<td>".$rep['type_nom']."</td>");
			print("<td align=\"center\">".$rep[0]."</td>");
			print("<td align=\"center\">".$rep[1]."</td>");
		print("</tr>");
		//print($rep['type_nom']." ".$rep[0]." ".$rep[1]."<br>");
	}
	print("<table>");
}
print("</FORM>");

?>