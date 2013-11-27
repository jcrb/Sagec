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
//----------------------------------------- SAGEC --------------------------------------------------------
/**
 * programme: 		arh_test.php
 * @package Sagec
 * @author	JCB
 * @version 1.0
 * @ date création: 24/03/2007
 */
//---------------------------------------------------------------------------------------------------------
//
include("../html.php");
include("../pma_connect.php");
include("../pma_connexion.php");
include("../pma_requete.php");
include("../date.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

/**
 * Sélectionner les hôpitaux d'un territoire de santé
 * @param n° du territoire
 */
function select_hop_territoire($territoire)
{
	global $connexion;
	$requete = "SELECT Hop_nom,Hop_ID
					FROM hopital, adresse, ville
					WHERE hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND ville.territoire_sante IN ($territoire)";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print($rub['Hop_nom']."<br>");
	}
}

/**
 * Sélectionner les hôpitaux d'une zone de proximité
 */
function select_hop_zone($zone)
{
	global $connexion;
	$requete = "SELECT Hop_nom,Hop_ID
					FROM hopital, adresse, ville
					WHERE hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND ville.zone_proximite IN($zone)";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print($rub['Hop_nom']."<br>");
	}
}
/**
 * récupère les services de pédiatrie d'un territoire
 * @param $zone n° de la zone
 * @return nom de la zone
 */
function getZoneNom($zone)
{
	global $connexion;
	$requete = "SELECT z_proximite_nom FROM zone_proximite WHERE z_proximite_ID = '$zone'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	return $rub['z_proximite_nom'];
}

/**
 * récupère les services de pédiatrie d'un territoire
 * @param $territoire n° du territoire
 * @param $specialite n° correspondant à la spécialité. 
 * 		Il peut s'agir d'une suite de n° séparés par une virgule. 
 * 		Chaque n° doit être encadré par des apostrophes
 * @return nom des services
 */
function get_specialite($territoire,$specialite)
{
	global $connexion;
	$requete = "SELECT service_nom, Hop_nom
					FROM service, hopital, adresse, ville
					WHERE service.specialite_ID IN ($specialite)
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND ville.territoire_sante IN ($territoire)";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print($rub['Hop_nom']." ".$rub['service_nom']."<br>");
	}
}

/**
 *
 */
 function lits_specialite($territoire,$specialite)
 {
 	global $connexion;
 	$requete = "SELECT service_nom, Hop_nom, lits_sp
 					FROM lits,service,hopital,adresse,ville
 					WHERE lits.service_ID = service.service_ID
 					AND service.specialite_ID IN ($specialite)
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND ville.territoire_sante IN ($territoire)";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print($rub['Hop_nom']." ".$rub['service_nom']." ".$rub['lits_sp']."<br>");
	}
	
	 	$requete = "SELECT SUM(lits_sp)
 					FROM lits,service,hopital,adresse,ville
 					WHERE lits.service_ID = service.service_ID
 					AND service.specialite_ID IN ($specialite)
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND ville.territoire_sante IN ($territoire)";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	print("<i>Total des lits installés: ".$rub[0]."</i><br>");
 }
 
 /**
 *	@param $date = date du jour au format jj/mm/aaaa
 */
 function lits_specialite_dispo($territoire,$specialite,$date)
 {
 	global $connexion;
 	$d1 = fDate2unix($date);
 	$d2 = $d1 + un_jour;
 	$requete = "SELECT service_nom, Hop_nom,lits_journal.lits_dispo, lits.lits_sp
 					FROM lits_journal, lits,service,hopital,adresse,ville
 					WHERE lits_journal.service_ID = service.service_ID
 					AND lits.service_ID = service.service_ID
 					AND service.specialite_ID IN ($specialite)
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND ville.territoire_sante IN ($territoire)
					AND lits_journal.date BETWEEN '$d1' AND '$d2'
					";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print($rub['Hop_nom']." ".$rub['service_nom']." lits installés: ".$rub['lits_sp']." Lits disponibles: ".$rub['lits_dispo']." ratio: ".sprintf("%01.2f",$rub['lits_dispo']/$rub['lits_sp'])."<br>");
	}
	
	$requete = "SELECT SUM(lits_journal.lits_dispo), SUM(lits.lits_sp)
 					FROM lits_journal, lits,service,hopital,adresse,ville
 					WHERE lits_journal.service_ID = service.service_ID
 					AND lits.service_ID = service.service_ID
 					AND service.specialite_ID IN ($specialite)
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND ville.territoire_sante IN ($territoire)
					AND lits_journal.date BETWEEN '$d1' AND '$d2'
					";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	print("<i>Total des lits installés: ".$rub[1]." Lits disponibles: ".$rub[0]." ratio: ".sprintf("%01.2f", $rub[0]/$rub[1])."</i><br>");
 }

print("<form name=\"select\" method=\"get\" action=\"arh_test.php\">");
$nb_territoire = 5;
$nb_zone = 13;
$territoires= array("tous","1. Haguenau","2. Strasbourg","3. Colmar","4. Mulhouse");
$zproximite = array();
$requete = "SELECT * FROM zone_proximite ORDER BY territoire_ID";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
	$zproximite[$rub['z_proximite_ID']][$rub['territoire_ID']] = $rub['z_proximite_nom'];

print("<table with=\"100%\">");
	for($i = 1; $i < $nb_territoire; $i++)
	{
		print("<tr>");
			print("<td><input type=\"checkbox\" name=\"territoire[]\" value=\"$i\">$territoires[$i]</td>");
			for($j = 0; $j < $nb_zone; $j++)
			{
				if($zproximite[$j][$i])
				{
					print("<td><input type=\"checkbox\" name=\"zone[]\" value=\"$j\">".$zproximite[$j][$i]."</td>");
				}
			}
		print("</tr>");
	}
print("</table>");

print("Sélectionner par <select name=\"choix\" size=\"1\">");
	print("<option value=\"0\">Sélectionnez une zone géographique</option>");
	print("<option value=\"1\">Secteur de proximité</option>");
	print("<option value=\"2\">Territoire de santé</option>");
	print("<option value=\"3\">Département</option>");
	print("<option value=\"4\">Région</option>");
	print("<option value=\"5\">Hôpital</option>");
print("</select>");

print("<input type=\"submit\" name=\"ok\" value=\"OK\"><br>");

$territoire = $_GET['territoire'];
for($i = 0; $i < sizeof($territoire); $i++)
	print($territoire[$i]."<br>");
$t = implode(",", $territoire);
select_hop_territoire($t);

print("</form>");
 

/*
print("<b>Territoire de santé 1</b><br>");
select_hop_territoire(1);
print("<b>Territoire de santé 2</b><br>");
select_hop_territoire(2);
print("<b>Territoire de santé 3</b><br>");
select_hop_territoire(3);
print("<b>Territoire de santé 4</b><br>");
select_hop_territoire(4);

print("<br><br>");
for($i = 1; $i < $nb_zone; $i++)
{
	print("<b>".getZoneNom($i)."</b><br>");
	select_hop_zone($i);
}

$specialite = "'1','2','3','4','5'";
for($i = 1; $i < $nb_territoire; $i++)
{
	print("<br><b>services de pédiatrie du territoire ".$i."</b><br>");
	get_specialite($i,$specialite);
}

for($i = 1; $i < $nb_territoire; $i++)
{
	print("<br><b>Lits installés de pédiatrie du territoire ".$i."</b><br>");
	lits_specialite($i,$specialite);
}

$date = "10/01/2007";
for($i = 1; $i < $nb_territoire; $i++)
{
	print("<br><b>Lits installés de pédiatrie du territoire ".$i."</b><br>");
	lits_specialite_dispo($i,$specialite,$date);
}
*/


?>