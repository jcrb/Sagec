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
//	programme: 		arh_resultat.php
//	date de cr?ation: 	02/03/2005
//	auteur:			jcb
//	description:		Fonctionalit? permise ? l'administrateur
//	version:			1.2
//	maj le:			14/05/2005
//
//--------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include("../../html.php");
include("../../pma_connect.php");
include("../../pma_connexion.php");
include("../../pma_requete.php");
include("../../date.php");
include("arh_utilitaire.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

function entete($date,$type_secteur, $num_secteur)
{
	
	$date1 = fDate2unix($date); // $date1 = date de référence au format Unix
	//print("date: ".$date1."<br>");
	//$date_point = uDate2Frenchdatetime(heure_limite($date1,16));
	$msg = jour_de_la_semaine($date1)." ".$date." (Unix time: ".$date1.")<br>";
	$date_du_jour = $msg;
	$msg .= "<table width=\"100%\" class=\"time\" bgcolor=\"orange\">";
	$msg .= "<tr>";
		$msg .= "<TD>Région Alsace</td>\n";
		$msg .= "<TD>".getTerritoire($type_secteur, $num_secteur)."</td>\n";
		$msg .= "<TD>".$date_du_jour."</td>\n";
	$msg .= "</tr>\n";
	$msg .= "<tr>";
		$msg .= "<TD>Serveur ARH SAGEC</td>\n";
		$msg .= "<TD>SAMU67 - HUS</td>\n";
	$msg .= "</tr>\n";
	$msg .= "</table>";
	
	// entête du tableau de résultats
	
	$msg .= "<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">";
	$msg .="<tr class=\"tel\">";
		$msg .="<td rowspan=\"3\" valign=\"middle\">Groupe disciplines</td>\n";
		$msg .="<td rowspan=\"3\" valign=\"middle\">Disciplines</td>\n";
		$msg .="<td rowspan=\"3\" valign=\"middle\">Total lits installés au 31 décembre</td>\n";
		$msg .="<td colspan=\"2\" valign=\"middle\" align=\"center\">Réponses</td>\n";
		$msg .="<td rowspan=\"2\" colspan=\"2\" valign=\"middle\" align=\"center\">Lits disponibles</td>\n";
		$msg .="<td colspan=\"4\" valign=\"middle\" align=\"center\">Comparaison par rapport au</td>\n";
	$msg .="</tr>\n";
	$msg .="<tr class=\"tel\">";
		$msg .="<td rowspan=\"2\" valign=\"middle\">nombre de lits installés</td>\n";
		$msg .="<td rowspan=\"2\"valign=\"middle\">%</td>\n";
		$msg .="<td rowspan=\"2\" valign=\"middle\">nombre moyen des 3 derniers jours</td>\n";
		$msg .="<td rowspan=\"2\" valign=\"middle\">Evolution</td>\n";
		$msg .="<td rowspan=\"2\" valign=\"middle\">3 jours identiques</td>\n";
		$msg .="<td rowspan=\"2\" valign=\"middle\">Evolution</td>\n";
	$msg .="</tr>\n";
	$msg .="<tr class=\"tel\">";
		$msg .="<td valign=\"middle\">nombre</td>\n";
		$msg .="<td valign=\"middle\">%</td>\n";
	$msg .="</tr>\n";
	return $msg;
}

function discipline($date,$specialite,$type_secteur, $num_secteur)
{
	global $total_lits;
	
	$date1 = fDate2unix($date); // $date1 = date de référence au format Unix
			$rep = calculs($specialite,$date1,$type_secteur,$num_secteur);
			$msg .="<td align=\"center\">".$rep['tot_lits']."</td>\n";
			$msg .="<td align=\"center\">".$rep['installes']."</td>\n";
			$msg .="<td align=\"center\">".$rep['ratio_installes']."%</td>\n";
			$total_lits[0] = $rep['tot_lits'];
			$total_lits[1] = $rep['installes'];
			$total_lits[2] = $rep['ratio_installes'];
			// lits disponibles à $date1
			$rep = lits_specialite_dispo($type_secteur,$num_secteur,$specialite,$date1);
			//lits_specialite_dispo($type_secteur,$num_secteur,$specialite,$date1,$date2 = 0,$operation=0,$repetition=0)
			$lits_dispo1 = $rep['lits_dispo'];
			$msg .="<td align=\"center\">".$rep['lits_dispo']."</td>\n";
			$msg .="<td align=\"center\">".$rep['ratio_installes']."%</td>\n";
			$total_lits[3] = $rep['lits_dispo'];
			$total_lits[4] = $rep['ratio_installes'];

			$evolution = $rep['ratio_installes'];
			$op = 1;// moyenne
			$recul = 3;// nombre de jours en arrière
			$d2 = $date1;
			$d1 = $d2 - un_jour * $recul;
			//print("recul de 3 jours<br> d1 = ".uDate2Frenchdatetime($d1)."<br>");print("d2 = ".uDate2Frenchdatetime($d2)."<br>");
// lits disponibles en moyenne ces 3 derniers jours
   		$rep = lits_specialite_dispo($type_secteur,$num_secteur,$specialite,$d1,$d2,$op,0);
			$evolution = $evolution-$rep['ratio_installes'];
		$msg .="<td align=\"center\">".$rep['lits_dispo']."</td>\n";
		$msg .="<td align=\"center\">".$evolution."%</td>\n";
		$total_lits[5] = $rep['lits_dispo'];
		$total_lits[6] = $evolution;
		
			$repetition=3;
// trois jours identiques
			$rep = lits_specialite_dispo($type_secteur,$num_secteur,$specialite,$date1,0,$op,$repetition);
			$evolution = intval(100*($lits_dispo1/$rep['lits_dispo'] - 1)); 
		$msg .="<td align=\"center\">".$rep['lits_dispo']."</td>\n";
		$msg .="<td align=\"center\">".$evolution."%</td>\n";
		$total_lits[7] = $rep['lits_dispo'];
		$total_lits[8] = $evolution;
	
	return $msg;
}


/**
 * total des lits de spécialité installés au 32/12
 * @param $specialite
 * @param $date
 * @param $type_secteur: région, secteur sanitaire, zone de proximité, hôpital
 * @param identifiant du $type_secteur
 */
function calculs($specialite,$date,$type_secteur=0,$num_secteur=0)
{
	$rep = array();
	global $connexion;
	
	// total des lits de spécialité installés au 32/12
	$requete = "SELECT SUM(lits.lits_sp),SUM(lits.lits_installe)
 					FROM lits,service,hopital,adresse,ville
 					WHERE lits.service_ID = service.service_ID
 					AND service.service_discipline_ID IN ('$specialite')
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID";
		
	if($type_secteur==TERRITOIRE_SANTE)				
		$requete .= " AND ville.territoire_sante IN ('$num_secteur')";
	elseif($type_secteur==ZONE_PROXIMITE)
		$requete .= " AND ville.zone_proximite IN ('$num_secteur')";
	elseif($type_secteur==DEPARTEMENT)
		$requete .= " AND ville.departement_ID IN ('$num_secteur')";
		
	//print("<br> [1] ".$requete."<br>");
	
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	if($rub[0]) $rep['tot_lits'] = $rub[0];else $rep['tot_lits'] = 0;
	if($rub[1]) $rep['installes'] = $rub[1];else $rep['installes'] = 0;
	if($rub[0]==0)
		$rep['ratio_installes'] = 'NA';
	else
		$rep['ratio_installes'] = intval(0.5+100*$rub[1]/$rub[0]); 
	return $rep;
}


/**
* \fn lits_specialite_dispo($territoire,$specialite,$date)
* Fait la somme des lits installés et disponibles ainsi que le ratio des 2 pour une spécialité donnée
* pour des hôpitaux et des services d'un territoire donné et une date ou période donnée
* le nombre .
* @param $type_secteur territoire de santé, zone de proximité, etc.
* @param $num_secteur n° du ou des territoires concernés (tableau)
* @param $specialite spécialité concernée
* @param $date1 date de départ, format unix
* @param $date2 date de fin, format unix, facultative. Mettre 0 pour 1 seule journée
* @param $operation: par défaut fait la somme, ou la moyenne si 1
* @param $repetition = 0 => la calcul se fait pour la date ou période considérée, sinon le calcul
*        porte sur 3 périodes identiques antérieures.
* @return un tableau à 3 éléments: $rep['lits_dispo'],$rep['installes'],$rep['ratio_installes']
*/		
function lits_specialite_dispo($type_secteur,$num_secteur,$specialite,$date1,$date2 = 0,$operation=0,$repetition=0)
 {
 	global $connexion;
 	//$d1 = fDate2unix($date);
 	$d1 = $date1;
 	if($date2 == 0)
 		$d2 = $d1 + un_jour;
 	else $d2 = $date2;
 	//print("d1 = ".uDate2Frenchdatetime($d1)."<br>");print("d2 = ".uDate2Frenchdatetime($d2)."<br>");
 	
 	if($operation == 0)
		$requete = "SELECT SUM(lits_journal.lits_dispo), SUM(lits.lits_sp)";
	else
		$requete = "SELECT AVG(lits_journal.lits_dispo), AVG(lits.lits_sp)";
	
	if($repetition == 0)
	{	
		$requete .= " FROM lits_journal, lits,service,hopital,adresse,ville
 					WHERE lits_journal.service_ID = service.service_ID
 					AND lits.service_ID = service.service_ID
 					AND service.service_discipline_ID IN ($specialite)
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID";
					
					if($type_secteur==TERRITOIRE_SANTE)				
						$requete .= " AND ville.territoire_sante IN ('$num_secteur')";
					elseif($type_secteur==ZONE_PROXIMITE)
						$requete .= " AND ville.zone_proximite IN ('$num_secteur')";
					elseif($type_secteur==DEPARTEMENT)
						$requete .= " AND ville.departement_ID IN ('$num_secteur')";
						
					$requete .=" AND lits_journal.date BETWEEN '$d1' AND '$d2'";
	}
	else
	{
		$requete .= " FROM lits_journal, lits,service,hopital,adresse,ville
 					WHERE lits_journal.service_ID = service.service_ID
 					AND lits.service_ID = service.service_ID
 					AND service.service_discipline_ID IN ($specialite)
					AND service.Hop_ID = hopital.Hop_ID
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID";
					
					if($type_secteur==TERRITOIRE_SANTE)				
						$requete .= " AND ville.territoire_sante IN ('$num_secteur')";
					elseif($type_secteur==ZONE_PROXIMITE)
						$requete .= " AND ville.zone_proximite IN ('$num_secteur')";
					elseif($type_secteur==DEPARTEMENT)
						$requete .= " AND ville.departement_ID IN ('$num_secteur')";
					
				
				// n jours en arrière
				$d1 = $d1 - sept_jour;
				$d2 = $d2 - sept_jour;
				//print("d1 = ".uDate2Frenchdatetime($d1)."<br>");print("d2 = ".uDate2Frenchdatetime($d2)."<br>");
				$requete .= " AND ( lits_journal.date BETWEEN '$d1' AND '$d2' ";
				
				for($i = 0; $i < $repetition-1; $i++)
				{
					$d1 = $d1 - sept_jour;
					$d2 = $d2 - sept_jour;
					//print("d1 = ".uDate2Frenchdatetime($d1)."<br>");print("d2 = ".uDate2Frenchdatetime($d2)."<br>");
					$requete .= " OR lits_journal.date BETWEEN '$d1' AND '$d2' ";
				}  
				$requete .= ")";
	}
				                                               
	//print($requete."<br>");
	
	$resultat2 = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat2);
	//print("<i>Total des lits installés: ".$rub[1]." Lits disponibles: ".$rub[0]." ratio: ".sprintf("%01.2f", $rub[0]/$rub[1])."</i><br>");
	
	$rep['lits_dispo'] = $rub[0];//print("lit dispo: ".$rep['lits_dispo']."<br>");
	$rep['installes'] = $rub[1];
	if($rub[1]==0)
		$rep['ratio_installes'] = 'NA';
	else
		$rep['ratio_installes'] = intval(0.5+100*$rub[0]/$rub[1]);
	return $rep;
 }
//============================================ main =========================================================
$region = $_GET['region'];
$departement = $_GET['departement'];
$territoire = $_GET['territoire'];
$zone_proximite = $_GET['zone_proximite'];
$date1 =  $_GET['date1'];
$date2 =  $_GET['date2'];

print("<br>");
print("région: ".$region."<br>");
print("département: ".$departement."<br>");
print("territoire: ".$territoire."<br>");
print("zone de proximité: ".$zone_proximite."<br>");

if($territoire)
{
	print("Territoire de santé: ".$territoire_sante[$territoire-1]."<br>");
	$type_secteur = TERRITOIRE_SANTE;
	$num_secteur = $territoire;
}
elseif($zone_proximite)
{
	print("Zone de proximité: ".$zones[$zone_proximite-1]."<br>");
	$type_secteur = ZONE_PROXIMITE;
	$num_secteur = $zone_proximite;
}
elseif($departement)
{
	print("Département: ".$departements[$departement-1]."<br>");
	$type_secteur = DEPARTEMENT;
	$num_secteur = $departement;
}
else
{
	print("Région: Alsace<br>");
}
//============================================ main =========================================================
$date = "07/03/2006";
$type_secteur = TERRITOIRE_SANTE;
$num_secteur = 2;

$total_lits = array();
$total_lits_medecine = array();
$total_lits_ssr;

$msg = entete($date, $type_secteur, $num_secteur);
print("<br>");
print($msg);

print("<tr class=\"time_b\">");
	print("<td rowspan=\"4\" valign=\"middle\">Pédiatrie</td>\n");
		// Néonatalogie (avec ou sans SI)
		print("<td>Néonatalogie (avec ou sans SI</td>\n");
		$specialite = NEONAT;
		$msg = discipline($date,$specialite,$type_secteur, $num_secteur);
		$total_lits_medecine = $total_lits;
		print($msg);
print("</tr>\n");
print("<tr class=\"time_b\">");
		print("<td>Réanimation néonatale</td>\n");
		$specialite = REANEONAT;
		$msg = discipline($date,$specialite,$type_secteur, $num_secteur);
		$total_lits_medecine = sum_array($total_lits_medecine,$total_lits);
		print($msg);
print("</tr>\n");
print("<tr class=\"time_b\">");
		print("<td>Réanimation pédiatrique</td>\n");
		$specialite = REAPED;
		$msg = discipline($date,$specialite,$type_secteur, $num_secteur);
		$total_lits_medecine = sum_array($total_lits_medecine,$total_lits);
		print($msg);
print("</tr>\n");
print("<tr class=\"time_b\">");
		print("<td>Autres disciplines de pédiatrie</td>\n");
		$specialite = PED;
		$msg = discipline($date,$specialite,$type_secteur, $num_secteur);
		$total_lits_medecine = sum_array($total_lits_medecine,$total_lits);
		print($msg);
print("</tr>\n");

print("<tr class=\"time_b\">");
	print("<td rowspan=\"4\" valign=\"middle\">Réanimation adulte</td>\n");
		print("<td>Réanimation médicale</td>\n");
		$specialite = REAMED;
		$msg = discipline($date,$specialite,$type_secteur, $num_secteur);
		$total_lits_medecine = sum_array($total_lits_medecine,$total_lits);
		print($msg);
print("</tr>\n");

print("<tr class=\"time_b\">");
		print("<td>Réanimation chirurgicale</td>\n");
		$msg = discipline($date,REACHIR,$type_secteur, $num_secteur);
		$total_lits_medecine = sum_array($total_lits_medecine,$total_lits);
		print($msg);
print("</tr>\n");
print("<tr class=\"time_b\">");
		print("<td>Réanimation poyvalente</td>\n");
		$msg = discipline($date,REAMIXTE,$type_secteur, $num_secteur);
		$total_lits_medecine = sum_array($total_lits_medecine,$total_lits);
		print($msg);
print("</tr>\n");
print("<tr class=\"time_b\">");
		print("<td>Soins intensifs</td>\n");
		$msg = discipline($date,SI,$type_secteur, $num_secteur);
		$total_lits_medecine = sum_array($total_lits_medecine,$total_lits);
		print($msg);
print("</tr>\n");
print("<tr class=\"time_b\">");
		print("<td rowspan=\"1\" valign=\"middle\">Autres disciplines médicales</td>\n");
		print("<td>Médecine</td>\n");
		$msg = discipline($date,MEDECINE,$type_secteur, $num_secteur);
		$total_lits_medecine = sum_array($total_lits_medecine,$total_lits);
		print($msg);
print("</tr>\n");

// total disciplines médicales
print("<tr class=\"time_b\">");
		print("<td colspan=\"2\" valign=\"middle\">Total disciplines médicales</td>\n");
		print("<td align=\"center\">$total_lits_medecine[0]</td>\n");
		print("<td align=\"center\">$total_lits_medecine[1]</td>\n");
		print("<td align=\"center\">".intval(0.5+100*$total_lits_medecine[1]/$total_lits_medecine[0])."%</td>\n");
		print("<td align=\"center\">$total_lits_medecine[3]</td>\n");
		print("<td align=\"center\">".intval(0.5+100*$total_lits_medecine[3]/$total_lits_medecine[2])."%</td>\n");
		print("<td align=\"center\">$total_lits_medecine[5]</td>\n");
		print("<td align=\"center\">".intval(0.5+100*$total_lits_medecine[3]/$total_lits_medecine[5])."%</td>\n");
		print("<td align=\"center\">$total_lits_medecine[7]</td>\n");
		print("<td align=\"center\">".intval(0.5+100*$total_lits_medecine[3]/$total_lits_medecine[7])."%</td>\n");
print("</tr>\n");

print("<tr class=\"time_b\">");
		print("<td colspan=\"2\" >Chirurgie</td>\n");
		$msg = discipline($date,CHIRURGIE,$type_secteur, $num_secteur);
		print($msg);
print("</tr>\n");
print("<tr class=\"time_b\">");
		print("<td colspan=\"2\">Gynécologie-Obstétrique</td>\n");
		$msg = discipline($date,GYNOBS,$type_secteur, $num_secteur);
		print($msg);
print("</tr>\n");
print("<tr class=\"time_b\">");
		print("<td colspan=\"2\">Zone de surveillance de très courte durée</td>\n");
		$msg = discipline($date,SAU,$type_secteur, $num_secteur);
		print($msg);
print("</tr>\n");
print("<tr class=\"time_b\">");
		print("<td rowspan=\"3\" valign=\"middle\">Soins de suite ou de réadaptation</td>\n");
		print("<td>Réadaptation fonctionelle</td>\n");
		$msg = discipline($date,RFONC,$type_secteur, $num_secteur);
		print($msg);
print("</tr>\n");
print("<tr class=\"time_b\">");
		print("<td>Soins de suite</td>\n");
		$msg = discipline($date,SSUITE,$type_secteur, $num_secteur);
		print($msg);
print("</tr>\n");
print("<tr class=\"time_b\">");
		print("<td>Total SSR</td>\n");
print("</tr>\n");

print("<tr class=\"time_b\">");
		print("<td colspan=\"2\">TOTAL</td>\n");
		
print("</tr>\n");

print_r($total_lits_medecine);


?>