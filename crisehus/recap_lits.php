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
*	@version:		$Id: recap_lits.php 37 2008-02-27 06:46:04Z jcb $								
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

//print("<HTML><HEAD><TITLE>Liste des messages</TITLE>");
//<comment> rafraichissement automatique toutes les 30 secondes </comment>
//print("<meta http-equiv=\"refresh\" content=\"30\">");
//print("<LINK REL=stylesheet HREF=\"crise.css\" TYPE =\"text/css\"></HEAD>");

function affiche_resultat($hopital, $hop_nom)
{
	$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
	$requete = "SELECT  SUM(lits_dispo),SUM(lits_sp),SUM(lits_liberable), type_nom
					FROM hopital, service, lits, type_service
					WHERE hopital.Hop_ID IN ($hopital)
					AND service.Hop_ID = hopital.Hop_ID
					AND lits.service_ID = service.service_ID
					AND service.type_ID = type_service.type_ID
					GROUP BY type_nom
					";
	$result = ExecRequete($requete,$connect);
	$total = array();
	print("<table>");
		print("<tr>");
			print("<th colspan=\"4\">$hop_nom</th>");
		print("</tr>");
		print("<tr>");
			print("<th>Sp�cialit�</th>");
			print("<th>lits disponibles</th>");
			print("<th>lits lib�rables</th>");
			print("<th>lits install�s</th>");
		print("</tr>");
	while($rep=mySql_fetch_array($result))
	{
		print("<tr>");
			print("<td>".$rep['type_nom']."</td>");
			print("<td align=\"center\">".$rep[0]."</td>");$total[0]+=$rep[0];
			print("<td align=\"center\">".$rep[2]."</td>");$total[2]+=$rep[2];
			print("<td align=\"center\">".$rep[1]."</td>");$total[1]+=$rep[1];
		print("</tr>");
		//print($rep['type_nom']." ".$rep[0]." ".$rep[1]."<br>");
	}
	print("<tr>");
		print("<th>Total</th>");
		print("<th align=\"center\">".$total[0]."</th>");
		print("<th align=\"center\">".$total[2]."</th>");
		print("<th align=\"center\">".$total[1]."</th>");
	print("</tr>");
	print("</table>");
}

//print("<body>");
//print("<FORM name=\"recaplits\" method=\"post\" action=\"recap_lits.php\">");
print("<table width=\"100%\">");
	print("<tr>");
		print("<td>");
			affiche_resultat("'2'", "H�pital Civil");
		print("</td>");
		print("<td>");
			affiche_resultat("'1'", "H�pital de Hautepierre");
		print("</td>");
	print("</tr>");
	print("<tr>");
		print("<td>");
			affiche_resultat("'3'", "CCOM");
		print("</td>");
		print("<td>");
			affiche_resultat("'1','2','3'", "Totalit� des lits");
		print("</td>");	
	print("</tr>");
print("</table>");

//print("</FORM>");
//print("</body>");

?>