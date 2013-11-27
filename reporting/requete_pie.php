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
//---------------------------------------------------------------------------------------------------------
/**
* 	
*	@programme 		requete_pie.php
*	@date de création: 	01/03/2007
*	@author jcb
*	@version $Id$
*	@update le 01/03/2007
*	@version 1.0
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../date.php");
//date_default_timezone_set ('Europe/Paris');

/** interroge la base de données 
* @param $date1: borne inf.intervalle de temps
* @param $date2: borne sup.intervalle de temps
* @param $type: type de spécialité
* @param $region: aire géographique concernée
* @return un tableau totalisant les lits vides et occupés
*/
function getData($date1,$date2,$type,$region)
{
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	$requete = "SELECT lits_dispo, lits_sp,service_nom
				FROM lits, service, hopital, adresse, ville
				WHERE lits.service_ID = service.service_ID
				AND service.Type_ID = 4
				AND service.Hop_ID = hopital.Hop_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID = '67'
				AND lits.date_maj BETWEEN '$date1' AND '$date2'
			  ";
		
	$requete = "SELECT lits_dispo, lits_sp,service_nom
				FROM lits,service
				WHERE lits.date_maj BETWEEN '$date1' AND '$date2'
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = '$type'
				";
				
	$requete = "SELECT lits_journal.lits_dispo, lits.lits_sp,service_nom
					FROM lits_journal,lits,service, hopital, adresse, ville
					WHERE lits_journal.date BETWEEN '$date1' AND '$date2'
					AND lits_journal.service_ID = lits.service_ID
					AND lits.service_ID = service.service_ID
					AND service.Type_ID = '$type'
				AND service.Hop_ID = hopital.Hop_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID = '67'
					";
				
		//print($requete."<br>");
	$resultat = ExecRequete($requete,$connexion);
	$dispo = 0;
	$total = 0;
	while($rub=mysql_fetch_array($resultat))
	{
		$dispo += $rub['lits_dispo'];
		$total += $rub['lits_sp'];
		//print($rub['service_nom'].": ".$rub['lits_dispo']." sur ".$rub['lits_sp']."<br>");
	}
	$values = array($dispo,$total);
	return $values;
}

function miniTableau($values)
{
	print("<table>");
	print("<tr>");
		print("<td>lits disponibles</td>");
		print("<td>$values[0]</td>");
	print("</tr>");
	print("<tr>");
		print("<td>lits occupés</td>");
		print("<td>$values[1]</td>");
	print("</tr>");
	print("</table>");
}

$date1 = today()-un_jour;
$date2 = $date1 + un_jour;
$the_date = "Tableau de bord - ".jour_de_la_semaine($date1)." le ".date("d",$date1)." ".mois_courant($date1)." ".date("Y",$date1);
$values = array();

print("<table width=\"100%\">");
	print("<tr>");
		print("<td><img src=\"../images/arh2.png\" alt=\"ARH Alsace\"></td>");
		print("<td><H2>$the_date</H2></td>");
		print("<td><img src=\"../images/SAGEC_Alsace.png\" alt=\"SAGEC 67\"></td>");
	print("</tr>");
print("</table>");

print("<table>");
	print("<tr>");
		$type = 4;
		$values = getData($date1,$date2,$type);
		$data = serialize($values);
		$titre = "Places USIC Alsace";	
		print("<td><img src=\"pie_artichow2.php?values=$data&titre=$titre\" alt=\"image\" /></td>");
		$type = 2;
		$values2 = getData($date1,$date2,$type);
		$data = serialize($values2);
		$titre = "Places Réanimation adulte Alsace";	
		print("<td><img src=\"pie_artichow2.php?values=$data&titre=$titre\" alt=\"image\" /></td>");
	print("</tr>");
	print("<tr>");
		$type = 7;
		$values2 = getData($date1,$date2,$type);
		$data = serialize($values2);
		$titre = "Places de médecine Alsace";	
		print("<td><img src=\"pie_artichow2.php?values=$data&titre=$titre\" alt=\"image\" /></td>");
		$type = 8;
		$values2 = getData($date1,$date2,$type);
		$data = serialize($values2);
		$titre = "Places de Chirurgie Alsace";	
		print("<td><img src=\"pie_artichow2.php?values=$data&titre=$titre\" alt=\"image\" /></td>");
	print("</tr>");
		print("<tr>");
		$type = 9;
		$values = getData($date1,$date2,$type);
		$data = serialize($values);
		$titre = "Places en Pédiatrie Alsace";	
		print("<td><img src=\"pie_artichow2.php?values=$data&titre=$titre\" alt=\"image\" /></td>");
		$type = 19;
		$values2 = getData($date1,$date2,$type);
		$data = serialize($values2);
		$titre = "Places en Gynéco-Obstétrique Alsace";	
		print("<td><img src=\"pie_artichow2.php?values=$data&titre=$titre\" alt=\"image\" /></td>");
	print("</tr>");
print("</table>");

?>
