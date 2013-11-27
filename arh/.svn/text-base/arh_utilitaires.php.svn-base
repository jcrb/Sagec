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
//
//	programme: 		arh_utilitaires.php
//	date de création: 	26/11/2005
//	auteur:			jcb
//	description:
//	version:		1.3
//	modifié le		2/12/2005
//
/**
 * Documents the class following
 * @package Sagec
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
/* heure_limite() renvoie sous la forme d'une date unix la valeur correspondant à un jour donné à une heure donnée
/* $jour un timestamp unix quelconque
/* $heure une heure entre 0 et 23 heures
*/
function heure_limite($jour,$heure)
{
	return round_u_date($jour) + $heure*3600;
}

/**
/* calcule les lists disponibles sur les 3 derniers jours pour une spécialité. Permet notamment de tracer une courbe
* @var $resultat tableau SQL dont chaque ligne contient 3 données:
* @var service_nom	nom du service
* @var lits_dispo 	nombre de lits disponibles
* @var date			date de la mesure
* @return $lits_dispo nombre de lits disponibles
*/
function lits_dispo_par_heure($resultat)
{
	global $DEBUG;
	while($rub=mysql_fetch_array($resultat))
	{
		$x = $service[$rub['service_nom']];
		$y = $rub['lits_dispo'];
		$d = $y - $x;
		$total_lits_dispo += $d;
		$lits_dispo[uDate2Frenchdatetime($rub['date'])] = $total_lits_dispo;
		$service[$rub['service_nom']] = $rub['lits_dispo'];
	}

	if($DEBUG)
	{
		while($element = each($lits_dispo))
		{
			print($element["key"]." - ".$element["value"]."<br>");
		}
	}
	return $lits_dispo;
}

/**
* calcule les lits dispobibles sur les 3 derniers jours, nouvelle version
* @var $resultat contient la liste des des services retenus classés par service et pour chaque service par date 
* croisssante. Le chiffre retenu est le dernier nombre de lits disponibles avant 16 heures.
* @return nombre de lits disponibles
*/
function calcule_lits_disponibles2($resultat)
{
	$un_jour = 60*60*24;
	global $DEBUG;
	while($rub=mysql_fetch_array($resultat))
	{
		if($DEBUG) print("service lu: ".uDate2Frenchdatetime($rub['date']).' '.$rub['service_nom'].' = '.$rub['lits_dispo'].' lits<br>');

		if(!$heure_limite)// premier passage
		{
			$heure_limite = heure_limite($rub['date'],16); //$jour_courant + 16*60*60;//16 heures
			if($rub['date']<=$heure_limite)
			{
				$service_courant=$rub['service_nom'];
				$lits_disponibles = $rub['lits_dispo'];
				$heure_courante = $rub['date'];
			}
		}
		else
		{
			if($rub['service_nom'] == $service_courant)// c'est le même service
			{
				if($heure_limite - $rub['date']>0)// date-heure courante < date-heure de référence
				{ // si oui alors il s'agit un nouvel enregistrement concernant le même jour
					$lits_disponibles = $rub['lits_dispo'];
					$heure_courante = $rub['date'];
				}
				else // si non c'est qu'on a changé de jour
				{
					$lits_dispo3 += $lits_disponibles; // on mémorise la dernière entrée valide
					//print("[1]Pris en compte ".uDate2Frenchdatetime($heure_courante).' '.$service_courant.' '.$lits_disponibles.' lits<br>');
					// on réajuste les variables de référence
					$heure_limite = heure_limite($rub['date'],16);
					$lits_disponibles = 0;
					if($rub['date']<=$heure_limite)
					{
						$lits_disponibles = $rub['lits_dispo'];
						$heure_courante = $rub['date'];
					}
				}
			}
			else // c'est au autre service
			{
				// on mémorise la dernière entrée
				$lits_dispo3 += $lits_disponibles;
				//print("[2]Pris en compte ".uDate2Frenchdatetime($heure_courante).' '.$service_courant.' '.$lits_disponibles.' lits<br>');
				// on réajuste les variables de référence
				$service_courant=$rub['service_nom'];
				$heure_limite = heure_limite($rub['date'],16);
				$lits_disponibles = 0;
				if($rub['date']<=$heure_limite)
				{
					$lits_disponibles = $rub['lits_dispo'];
					$heure_courante = $rub['date'];
				}
			}
		}
	}
	// on mémorise la dernière entrée
	if($rub['date']<=$heure_limite)
	{
		$lits_dispo3 += $lits_disponibles;
		//print("[3]Pris en compte ".uDate2Frenchdatetime($heure_courante).' '.$service_courant.' '.$lits_disponibles.' lits<br><br>');
	}
	return $lits_dispo3;
}
/**
/* calcule les lits dispobibles sur les 3 derniers jours
*/
function calcule_lits_disponibles($resultat)
{
	$un_jour = 60*60*24;
	global $DEBUG;
	// départ, lecture de la première ligne de résulat
	$rub=mysql_fetch_array($resultat);
	$service_courant=$rub['service_nom'];
	$lits_disponibles = $rub['lits_dispo'];
	$jour_courant = round_u_date($rub['date']);
	$heure_limite = heure_limite($rub['date'],16); //$jour_courant + 16*60*60;//16 heures
	$heure_courante = $rub['date'];

	if($DEBUG){
		print("Départ ".uDate2Frenchdatetime($jour_courant)."<br>");
		print("heure limite ".uDate2Frenchdatetime($heure_limite)."<br>");
		print("service lu: ".uDate2Frenchdatetime($rub['date']).' '.$rub['service_nom'].' '.$rub['lits_dispo'].'<br>');
		print("<br>");
	}
	while($rub=mysql_fetch_array($resultat)){
		if($DEBUG) print("service lu: ".uDate2Frenchdatetime($rub['date']).' '.$rub['service_nom'].' '.$rub['lits_dispo'].'<br>');
		if($rub['service_nom'] != $service_courant)
		{
			$lits_dispo3 += $lits_disponibles;
			if($DEBUG) print("[1]Pris en compte ".uDate2Frenchdatetime($heure_courante).' '.$service_courant.' '.$lits_disponibles.'<br>'.'<br>');
			$service_courant=$rub['service_nom'];
			$heure_courante = $rub['date'];
			$heure_limite = $rub['date']%$un_jour + 16*60*60;//16 heures
			$lits_disponibles = $rub['lits_dispo'];
			$jour_courant = round_u_date($rub['date']);// rajout
		}
		elseif(round_u_date($rub['date']) !=$jour_courant)
		{
			$lits_dispo3 += $lits_disponibles;
			if($DEBUG)print("[2]Pris en compte ".uDate2Frenchdatetime($heure_courante).' '.$service_courant.' '.$lits_disponibles.'<br>');
			if($DEBUG)print(round_u_date($rub['date'])." ".$jour_courant.'<br>');
			$jour_courant = round_u_date($rub['date']);
			$heure_limite = $jour_courant + 16*60*60;//16 heures
			if($DEBUG) print("heure limite ".uDate2Frenchdatetime($heure_limite)."<br>");
			$lits_disponibles = $rub['lits_dispo'];
			$heure_courante = $rub['date'];
			$nb_de_jour++;
		}
		else{
			if($rub['date'] > $heure_limite)
			{
				$lits_dispo3 += $lits_disponibles;
				if($DEBUG) print("[3]Pris en compte ".uDate2Frenchdatetime($heure_courante).' '.$service_courant.' '.$lits_disponibles.'<br>');
				$heure_courante = $rub['date'];
				$lits_disponibles = 0;
			}
			else
			{
			$heure_courante = $rub['date'];
			$lits_disponibles = $rub['lits_dispo'];
			if($DEBUG) print("[4]En attente: ".uDate2Frenchdatetime($heure_courante).' '.$service_courant.' '.$lits_disponibles."<br>");
			}
		}
		//$lits_dispo3 += $rub['lits_dispo'];
		//$d = $rub['date']%$un_jour;// partie de jour
		//$e = $rub['date']-$d;//jour entier
		//print( uDate2Frenchdatetime($rub['date']).' '.$rub['service_nom'].' '.$rub['lits_dispo'].'<br>');
	}
	return $lits_dispo3;
}
/*
/* Extrait les données et effectue les calculs de base
/* $specialite = n° de la spécialité tell qu'on la trouve dans la table "specialite". Pris en compte uniquement si type=0
/* date: date re référence pour les calculs
/* $type = type_ID tel qu'on le trouve dans la table type_service. S'il vaut 0 (valeur par défaut, c'est $pecialité et la table correspondante
/* qui est utilisée
*/
function calculs($specialite,$date1,$type=0)
{
	// ATTENTION IL FAUDRA RAJOUTER UNE SELECTION SUR LA REGION POUR N'AVOIR QUE L'ALASACE
	global $connexion;
	global $total_lits_installes;
	global $total_lits_installes2;
	global $total_lits_dispo;
	global $total_lits_dispo3;
	global $total_m_lits_dispo;
	global $DEBUG;
	global $total_litsmed_installes;
	global $total_litsmed_installes2;
	global $total_litsmed_dispo;
	global $total_litsmed_dispo3;
	global $total_m_litsmed_dispo;
	global $msg;
	// initialisation
	$lits_installes=$lits_installes2=$lits_dispo=$reponse=$lits_dispo3=0;
	//$date2=fDatetime2unix("20/08/2005 00:00:00");
	$date2 = $date1 + 24*3600;
	// lits installés au 31 décembre
	if($type==0)
		$requete="SELECT lits_sp
			FROM lits,service
			WHERE specialite_ID='$specialite'
			AND lits.service_ID=service.service_ID";
	else{
		$requete="SELECT lits_sp
			FROM lits,service
			WHERE type_ID='$type'
			AND lits.service_ID=service.service_ID";
		if($DEBUG)print("Type = ".$type."<br>");
	}
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat)){
		$lits_installes += $rub['lits_sp'];
	}
	//=========================================  lits disponibles =============================================================
	if($DEBUG)print("Lits disponibles<br>");
	if($type==0)
		$requete="SELECT lits_journal.lits_dispo,lits_sp,service_nom,date
			FROM lits_journal,service, lits
			WHERE specialite_ID='$specialite'
			AND lits_journal.service_ID=service.service_ID
			AND lits.service_ID=service.service_ID
			AND lits_journal.date BETWEEN '$date1' AND '$date2'ORDER BY service_nom, date";
	else
		$requete="SELECT lits_journal.lits_dispo,lits_sp,service_nom,date
			FROM lits_journal,service, lits
			WHERE type_ID='$type'
			AND lits_journal.service_ID=service.service_ID
			AND lits.service_ID=service.service_ID
			AND lits_journal.date BETWEEN '$date1' AND '$date2'ORDER BY service_nom, date";
	$resultat = ExecRequete($requete,$connexion);
	// pb car on peut avoir plusieurs résultats un jour donné pour le même hopital si plusieurs mises à jour ont été faites
	// il faut repérer les doublons et ne garder que l'enregistrement le plus proche de 16h, sans le dépasser
	$rub=mysql_fetch_array($resultat);
	$service_courant = $rub['service_nom'];
	$lits_ouverts = $rub['lits_sp'];
	$lits_disponibles = $rub['lits_dispo'];
	if($DEBUG)
		print("services: ".$rub['service_nom'].' '.$rub['lits_dispo'].' '.$rub['lits_sp'].' '.uDate2Frenchdatetime($rub['date']).'<br>');

	$heure_limite = heure_limite($date1,16);
	while($rub=mysql_fetch_array($resultat))
	{
		if($DEBUG) print("services: ".$rub['service_nom'].' '.$rub['lits_dispo'].' '.$rub['lits_sp'].' '.uDate2Frenchdatetime($rub['date']).'<br>');
		if($rub['service_nom'] != $service_courant)// c'est un autre service => on enregistre les valeurs courantes
		{
			$lits_installes2 += $lits_ouverts;
			$lits_dispo += $lits_disponibles;
			if($DEBUG) print("[1]pris en compte: ".$service_courant.' '.$lits_disponibles.' '.$lits_ouverts.'<br>');
			// mise à jour des valeurs courantes
			$service_courant = $rub['service_nom'];
			$lits_ouverts = $rub['lits_sp'];
			$lits_disponibles = $rub['lits_dispo'];
		}
		else // c'est un enregistrement concernant le même service. Si heure < heure_limite, on le garde
		{
			if($rub['date']< $heure_limite)
			{
				$lits_disponibles = $rub['lits_dispo'];
			}
			else // on mémorise la dernière valeur
			{
				$lits_installes2 += $lits_ouverts;
				$lits_dispo += $lits_disponibles;
				if($DEBUG) print("[2]pris en compte: ".$service_courant.' '.$lits_disponibles.' '.$lits_ouverts.'<br>');
				// mise à 0 des paramètres pour éviter tout double compte
				$lits_ouverts = 0;
				$lits_disponibles = 0;
			}
		}
	}
	// prise en compte du dernier
	$lits_installes2 += $lits_ouverts;
	$lits_dispo += $lits_disponibles;
	if($DEBUG) print("[3]pris en compte: ".$service_courant.' '.$lits_disponibles.' '.$lits_ouverts.'<br>');

	if($lits_installes>0)
		$reponse = intval(0.5+100*$lits_installes2/$lits_installes);
	else $reponse = 'na';
	if($lits_installes2>0)
		$prop = intval(0.5+100*$lits_dispo/$lits_installes2);
	else $prop = 'na';
	if($DEBUG)print("-----------------------------------------------------------------------------------<br>");

	//=================================================  3 derniers jours  ================================================================
	$date0 = $date2 - 24*60*60; //print('date 0: '.uDate2Frenchdatetime($date0).'<br>');
	$date2 = $date0 - 2*24*60*60;
	$date2=$date2-date("H",$date2)*3600;// ajustement lié à l'heure d'hiver: on retire le nb d'heures (exprimées en secondes) en exès
//print('date 2: '.uDate2Frenchdatetime($date2).'<br>');

	if($type==0)
		$requete="SELECT lits_dispo,date,service_nom
			FROM lits_journal,service
			WHERE specialite_ID='$specialite'
			AND lits_journal.service_ID=service.service_ID
			AND lits_journal.date BETWEEN '$date2' AND '$date0' ORDER BY service_nom,date";
	else
		$requete="SELECT lits_dispo,date,service_nom
			FROM lits_journal,service
			WHERE type_ID='$type'
			AND lits_journal.service_ID=service.service_ID
			AND lits_journal.date BETWEEN '$date2' AND '$date0' ORDER BY service_nom,date";
	//print($requete.'<br>');

	$resultat = ExecRequete($requete,$connexion);
	$lits_dispo3 = calcule_lits_disponibles2($resultat);

	$lits_dispo3 = intval(0.5+$lits_dispo3/3);//lits moyens
	if($lits_dispo3 != 0)
	{
		$prop3 = intval(0.5+100*$lits_dispo/$lits_dispo3)-100;
	}
	else{
		$prop3 = "na";
		//$lits_dispo3 = "na";
	}
	// petit essai pour tracer une éventuelle courbe
	if($type==0)
		$requete="SELECT lits_dispo,date,service_nom
			FROM lits_journal,service
			WHERE specialite_ID='$specialite'
			AND lits_journal.service_ID=service.service_ID
			AND lits_journal.date BETWEEN '$date2' AND '$date0' ORDER BY date";
	else
		$requete="SELECT lits_dispo,date,service_nom
			FROM lits_journal,service
			WHERE type_ID='$type'
			AND lits_journal.service_ID=service.service_ID
			AND lits_journal.date BETWEEN '$date2' AND '$date0' ORDER BY date";
	$resultat = ExecRequete($requete,$connexion);
	lits_dispo_par_heure($resultat);
	//================================================  3 jours équivalents  ============================================================
	//$sept_jour = 7*24*3600;
	if($DEBUG)print("Jours sélectionnés<br>");

	global $date3;
	global $date4;
	global $date5;

	$date3 = $date1 - sept_jour;if($DEBUG)print(uDate2Frenchdatetime($date3)."<br>");
	$date4 = $date3 - sept_jour;if($DEBUG)print(uDate2Frenchdatetime($date4)."<br>");
	$date5 = $date4 - sept_jour;if($DEBUG)print(uDate2Frenchdatetime($date5)."<br>");

	if($type==0)
		$requete="SELECT lits_dispo,date,service_nom
			FROM lits_journal,service
			WHERE specialite_ID='$specialite'
			AND lits_journal.service_ID=service.service_ID
			AND (lits_journal.date BETWEEN '$date3' AND ('$date3'+24*3600)
			OR lits_journal.date BETWEEN '$date4' AND ('$date4'+24*3600)
			OR lits_journal.date BETWEEN '$date5' AND ('$date5'+24*3600))
			ORDER BY service_nom,date";
	else
		$requete="SELECT lits_dispo,date,service_nom
			FROM lits_journal,service
			WHERE type_ID='$type'
			AND lits_journal.service_ID=service.service_ID
			AND (lits_journal.date BETWEEN '$date3' AND ('$date3'+24*3600)
			OR lits_journal.date BETWEEN '$date4' AND ('$date4'+24*3600)
			OR lits_journal.date BETWEEN '$date5' AND ('$date5'+24*3600))
			ORDER BY service_nom,date";
	$resultat = ExecRequete($requete,$connexion);
	$m_lits_dispo = calcule_lits_disponibles2($resultat);

	if($DEBUG){
	$resultat = ExecRequete($requete,$connexion);
		while($rub=mysql_fetch_array($resultat)){
			print($rub['service_nom']." ".uDate2Frenchdatetime($rub['date'])." ".$rub['lits_dispo']."<br>");
		}
	}

	if($m_lits_dispo != 0)
	{
 		$m_lits_dispo = intval(0.5+$m_lits_dispo/3);
		$m_prop3 = intval(0.5+100*$lits_dispo/$m_lits_dispo)-100;
	}
	else{
		$m_prop3 = "na";
		$m_lits_dispo = "na";
	}

	// affichage en ligne
	$msg .="<td align=\"center\">$lits_installes</td>\n";
	$msg .="<td align=\"center\">$lits_installes2</td>\n";
	$msg .="<td align=\"center\">$reponse%</td>\n";
	$msg .="<td align=\"center\">$lits_dispo</td>\n";
	$msg .="<td align=\"center\">$prop%</td>\n";
	$msg .="<td align=\"center\">$lits_dispo3</td>\n";
	$msg .="<td align=\"center\">$prop3%</td>\n";
	$msg .="<td align=\"center\">$m_lits_dispo</td>\n";
	$msg .="<td align=\"center\">$m_prop3%</td>\n";

	// mémorisation des totaux
	$total_lits_installes += $lits_installes;
	$total_lits_installes2 += $lits_installes2;
	$total_lits_dispo += $lits_dispo;
	$total_lits_dispo3 += $lits_dispo3;
	$total_m_lits_dispo += $m_lits_dispo;

	// total médecine
	if($specialite <12 || $type==7 || $type==9)
	{
		$total_litsmed_installes += $lits_installes;
		$total_litsmed_installes2 += $lits_installes2;
		$total_litsmed_dispo += $lits_dispo;
		$total_litsmed_dispo3 += $lits_dispo3;
		$total_m_litsmed_dispo += $m_lits_dispo;
	}
}


function tableau_compact($date) //$date = date du jour analysé
{

	global $total_lits_dispo;
	global $total_m_lits_dispo;
	global $total_m_lits_dispo3;
	global $total_lits_installes2;
	global $total_lits_installes;

	global $total_litsmed_installes;
	global $total_litsmed_installes2;
	global $total_litsmed_dispo;
	global $total_litsmed_dispo3;
	global $total_lits_dispo3;
	global $total_m_litsmed_dispo;

	global $date3;
	global $date4;
	global $date5;

	global $msg;

	$date1 = fDatetime2unix($date); // $date1 = date de référence au format Unix
	$date_point = uDate2Frenchdatetime(heure_limite($date1,16));
	$msg = jour_de_la_semaine($date1)." ".$date_point."<br>";

	$msg .= "<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">";
	$msg .="<tr class=\"tel\">";
		$msg .="<td rowspan=\"3\" valign=\"middle\">Groupe disciplines</td>\n";
		$msg .="<td rowspan=\"3\" valign=\"middle\">Disciplines</td>\n";
		$msg .="<td rowspan=\"3\" valign=\"middle\">Total lits installés dans la région au 31 décembre</td>\n";
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

	$msg .="<tr class=\"time_b\">";
		$msg .="<td rowspan=\"4\" valign=\"middle\">Pédiatrie</td>\n";
		$msg .="<td>Néonatalogie (avec ou sans SI</td>\n";
		calculs('1',$date1);
	$msg .="</tr>\n";
	$msg .="<tr class=\"time_b\">";
		$msg .="<td>Réanimation néonatale</td>\n";
		calculs('2',$date1);
	$msg .="</tr>\n";
	$msg .="<tr class=\"time_b\">";
		$msg .="<td>Réanimation pédiatrique ou mixte</td>\n";
		calculs('',$date1,'3');
	$msg .="</tr>\n";
	$msg .="<tr class=\"time_b\">";
		$msg .="<td>Autres disciplines de pédiatrie</td>\n";
		calculs('',$date1,'9');
	$msg .="</tr>\n";
	// Réanimations adultes
	// lits installés
	$msg .="<tr class=\"time_b\">";
		$msg .="<td rowspan=\"4\" valign=\"middle\">Réanimation adulte</td>\n";
		$msg .="<td>Réanimation médicale</td>\n";
		calculs('6',$date1);
	$msg .="</tr>\n";
	$msg .="<tr class=\"time_b\">";
		$msg .="<td>Réanimation chirurgicale</td>\n";
		calculs('7',$date1);
	$msg .="</tr>\n";
	$msg .="<tr class=\"time_b\">";
		$msg .="<td>Réanimation médico-chirurgicale ou mixte</td>\n";
		calculs('8',$date1);
	$msg .="</tr>\n";
	$msg .="<tr class=\"time_b\">";
		$msg .="<td>Soins intensifs</td>\n";
		calculs('11',$date1);
	$msg .="</tr>\n";
	// autres disciplines médicales
	$msg .="<tr class=\"time_b\">";
		$msg .="<td>Autres disciplines médicales</td>\n";
		$msg .="<td>Médecine</td>\n";
		calculs('',$date1,'7');
	$msg .="</tr>\n";
	// sous total médecine
	$msg .="<tr class=\"tel\">";
		$msg .="<td colspan=\"2\">Total médecine</td>\n";
		$msg .="<td align=\"center\">$total_litsmed_installes</td>\n";
		$msg .="<td align=\"center\">$total_litsmed_installes2</td>\n";
		$calcul = intval(0.5+100*$total_litsmed_installes2/$total_litsmed_installes);
		$msg .="<td align=\"center\">$calcul%</td>\n";
		$msg .="<td align=\"center\">$total_litsmed_dispo</td>\n";
		$calcul = intval(0.5+100*$total_litsmed_dispo/$total_litsmed_installes2);
		$msg .="<td align=\"center\">$calcul%</td>\n";
		$msg .="<td align=\"center\">$total_litsmed_dispo3</td>\n";
		$calcul = intval(0.5+100*$total_litsmed_dispo/$total_litsmed_dispo3-100);
		$msg .="<td align=\"center\">$calcul%</td>\n";
		$msg .="<td align=\"center\">$total_m_litsmed_dispo</td>\n";
		$calcul = intval(0.5+100*$total_litsmed_dispo/$total_m_litsmed_dispo-100);
		$msg .="<td align=\"center\">$calcul%</td>\n";
	$msg .="</tr>\n";
	// Chirurgie
	$msg .="<tr class=\"time_b\">";
		$msg .="<td colspan=\"2\">Chirurgie</td>\n";
		calculs('',$date1,'8');
	$msg .="</tr>\n";
	// Gynéco
	$msg .="<tr class=\"time_b\">";
		$msg .="<td colspan=\"2\">Gynécologie Obstétrique</td>\n";
		calculs('',$date1,'19');
	$msg .="</tr>\n";
	// urgences
	$msg .="<tr class=\"time_b\">";
		$msg .="<td colspan=\"2\">Zone de surveillance de très courte durée</td>\n";
		calculs('',$date1,'1');
	$msg .="</tr>\n";
	// SSR
	$msg .="<tr class=\"time_b\">";
		$msg .="<td rowspan=\"3\" valign=\"middle\">Soins de suite ou de réadaptation</td>\n";
		$msg .="<td>Rédaptation fonctionelle</td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
	$msg .="</tr>\n";
	$msg .="<tr class=\"time_b\">";
		$msg .="<td>Soins de suite</td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
		$msg .="<td align=\"center\"> xxx </td>\n";
	$msg .="</tr>\n";
	$msg .="<tr class=\"time_b\">";
		$msg .="<td>Total SSR</td>\n";
		calculs('',$date1,'15');
	$msg .="</tr>\n";
	// TOTAL général
	$msg .="<tr class=\"tel\">";
		$msg .="<td colspan=\"2\">TOTAL</td>\n";
		$msg .="<td align=\"center\">$total_lits_installes</td>\n";
		$msg .="<td align=\"center\">$total_lits_installes2</td>\n";
		$calcul = intval(0.5+100*$total_lits_installes2/$total_lits_installes);
		$msg .="<td align=\"center\">$calcul%</td>\n";
		$msg .="<td align=\"center\">$total_lits_dispo</td>\n";
		$calcul = intval(0.5+100*$total_lits_dispo/$total_lits_installes2);
		$msg .="<td align=\"center\">$calcul%</td>\n";
		$msg .="<td align=\"center\">$total_lits_dispo3</td>\n";
		$calcul = intval(0.5+100*$total_lits_dispo/$total_lits_dispo3-100);
		$msg .="<td align=\"center\">$calcul%</td>\n";
		$msg .="<td align=\"center\">$total_m_lits_dispo</td>\n";
		$calcul = intval(0.5+100*$total_lits_dispo/$total_m_lits_dispo-100);
		$msg .="<td align=\"center\">$calcul%</td>\n";
	$msg .="</tr>\n";
	$msg .="</table>";

	$msg .="<br><p class=\"time_b\">";
	$msg .="Comparaison faite avec les 3 jours identiques suivants:<br>";
	$msg .=jour_de_la_semaine($date3)." ".uDate2French($date3)."<br>";
	$msg .=jour_de_la_semaine($date4)." ".uDate2French($date4)."<br>";
	$msg .=jour_de_la_semaine($date5)." ".uDate2French($date5)."</p>";

	return $msg;
}

function entete()
{
	$msg = "<table width=\"100%\" class=\"time\" bgcolor=\"orange\">";
	$msg .= "<tr>";
		$msg .= "<TD>Région Alsace</td>\n";
		$msg .= "<TD>Personne chargée du dossier: <a href=\"mailto:thiriond@arh42.com\">Mme Dominique Thirion</a></td>\n";
		$msg .= "<TD>tel: 03 90 22 98 22</td>\n";
	$msg .= "</tr>\n";
	$msg .= "<tr>";
		$msg .= "<TD>Serveur ARH SAGEC</td>\n";
		$msg .= "<TD>SAMU67 - HUS</td>\n";
	$msg .= "</tr>\n";
	$msg .= "</table>";
	return $msg;
}

function samu_urgences($date)
{
	global $connexion;
	$date1 = fDate2unix($date);
	$date2 = $date1 - 3*un_jour;// 3 jours)
	print(jour_de_la_semaine($date1)." ".$date."<br>");
	$requete="SELECT date,nb_affaires,nb_primaires, nb_secondaires FROM veille_samu WHERE date BETWEEN '$date2' AND '$date1' ORDER BY date DESC";
	$resultat = ExecRequete($requete,$connexion);
	$num_rows = mysql_num_rows($resultat);

	// jour 0
	$rub1=mysql_fetch_array($resultat);// samu 1
	//print(uDate2French($rub1[date])." ".$rub1['nb_affaires']." ".$rub1['nb_primaires']." ".$rub1['nb_secondaires']."<br>");
	$rub2=mysql_fetch_array($resultat);// samu 2
	//print(uDate2French($rub2[date])." ".$rub2['nb_affaires']." ".$rub2['nb_primaires']." ".$rub2['nb_secondaires']."<br>");
	$nb_affaires = $rub1['nb_affaires']+$rub2['nb_affaires'];
	$nb_interventions = $rub1['nb_primaires']+$rub2['nb_primaires']+$rub1['nb_secondaires']+$rub2['nb_secondaires'];
	$somme_affaires = 0;
	$somme_interventions = 0;
	//
	while($rub1=mysql_fetch_array($resultat)){
		$rub2=mysql_fetch_array($resultat);
		$somme_affaires += $rub1['nb_affaires']+$rub2['nb_affaires'];
		$somme_interventions += $rub1['nb_primaires']+$rub2['nb_primaires']+$rub1['nb_secondaires']+$rub2['nb_secondaires'];
		$i++;
		//print(uDate2French($rub1[date])." ".$rub1['nb_affaires']." ".$rub1['nb_primaires']." ".$rub1['nb_secondaires']."<br>");
		//print(uDate2French($rub2[date])." ".$rub2['nb_affaires']." ".$rub2['nb_primaires']." ".$rub2['nb_secondaires']."<br>");
	}
	$somme_affaires = intval(0.5+$somme_affaires/3);
	$somme_interventions = intval(0.5+$somme_interventions/3);
//==================================================================================================
	// comparaison avec 3 dates identiques
	$date3 = $date1 - sept_jour;
	$date3=$date3-date("H",$date3)*3600;// ajustement lié à l'heure d'hiver: on retire le nb d'heures (exprimées en secondes) en exès
	$date4 = $date3 - sept_jour;
	$date5 = $date4 - sept_jour;
	$requete="SELECT date,nb_affaires,nb_primaires, nb_secondaires FROM veille_samu WHERE date IN('$date3','$date4','$date5') ORDER BY date DESC";
	//print($requete.'<br>');
	$resultat = ExecRequete($requete,$connexion);
	while($rub1=mysql_fetch_array($resultat)){	// SAmu 67
		$rub2=mysql_fetch_array($resultat);	// puis Samu 68 => a revoir pour prendre en compte plusieurs SAMU
		$somme_affaires2 += $rub1['nb_affaires']+$rub2['nb_affaires'];
		$somme_interventions2 += $rub1['nb_primaires']+$rub2['nb_primaires']+$rub1['nb_secondaires']+$rub2['nb_secondaires'];
		$i++;
		//print(uDate2Frenchdatetime($rub1[date])." ".$rub1['nb_affaires']." ".$rub1['nb_primaires']." ".$rub1['nb_secondaires']."<br>");
		//print(uDate2Frenchdatetime($rub2[date])." ".$rub2['nb_affaires']." ".$rub2['nb_primaires']." ".$rub2['nb_secondaires']."<br>");
	}
	$somme_affaires2 = intval(0.5+$somme_affaires2/3);
	$somme_interventions2 = intval(0.5+$somme_interventions2/3);
//==================================================================================================
	$msg ="<br> Activité des services d'urgence le ";
	$msg .=jour_de_la_semaine($date1)." ".uDate2French($date1)."<br>";
	$msg .="<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\">";
	$msg .="<tr class=\"tel\">";
	$msg .="<td>&nbsp;</td>\n";
	$msg .="<td>nombre</td>\n";
	$msg .="<td>nombre moyen des 3 derniers jours</td>\n";
	$msg .="<td>évolution</td>\n";
	$msg .="<td>3 jours identiques</td>\n";
	$msg .="<td>évolution</td>\n";
	$msg .="</tr>\n";
	$msg .="<tr class=\"time_b\">";
	$msg .="<td>nombre d'affaires traitées par le SAMU</td>\n";
	$msg .="<td align=\"right\">$nb_affaires</td>\n";
	$msg .="<td align=\"right\">$somme_affaires</td>\n";
	$evolution=intval(0.5+($nb_affaires/$somme_affaires-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
	$msg .="<td align=\"right\">$somme_affaires2</td>\n";
	if($somme_interventions2==0)$evolution='erreur';
	else $evolution=intval(0.5+($nb_affaires/$somme_affaires2-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
	$msg .="</tr>\n";
	$msg .="<tr class=\"time_b\">";
	$msg .="<td>nombre d'interventions SMUR</td>\n";
	$msg .="<td align=\"right\">$nb_interventions</td>\n";
	$msg .="<td align=\"right\">$somme_interventions</td>\n";
	$evolution=intval(0.5+($nb_interventions/$somme_interventions-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
	$msg .="<td align=\"right\">$somme_interventions2</td>\n";
	if($somme_interventions2==0)$evolution='erreur';
	else $evolution=intval(0.5+($nb_interventions/$somme_interventions2-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
	$msg .="</tr>\n";

	// on continue avec les SAU
	//print("activité des SAU.<br>");
	$requete="SELECT * FROM veille_sau WHERE date = '$date1'";
	//print("requete SAU: ".$requete."<br>".uDate2Frenchdatetime($date1).'<br>');
	$resultat = ExecRequete($requete,$connexion);
	$n = 0;// nb de services ayant répondu ce jour là
	while($rub1=mysql_fetch_array($resultat))
	{
		$n++;
		$nb_1an += $rub1[inf_1_an];
		$bn_75ans += $rub1[sup_75_an];
		$nb_entre += $rub1[entre1_75];
		$nb_hosp += $rub1[hospitalise];
		$nb_uhcd += $rub1[uhcd];
		$nb_transferts += $rub1[transfert];
		//print($rub1[date].'<br>');
	}
	$nb_passages = $nb_1an+$bn_75ans+$nb_entre;
	// moyenne des 3 jours précédants
	$date1 = $date1 - un_jour;
	$requete="SELECT * FROM veille_sau WHERE date BETWEEN '$date2' AND '$date1' ORDER BY date DESC";
	$resultat = ExecRequete($requete,$connexion);
	while($rub1=mysql_fetch_array($resultat))
	{
		$moyenne_nb_1an += $rub1[inf_1_an];
		$moyenne_bn_75ans += $rub1[sup_75_an];
		$moyenne_nb_entre += $rub1[entre1_75];
		$moyenne_nb_hosp += $rub1[hospitalise];
		$moyenne_nb_uhcd += $rub1[uhcd];
		$moyenne_nb_transferts += $rub1[transfert];
		//print($rub1[date].'<br>');
	}
	$moyenne_nb_passages = intval(0.5+($moyenne_nb_1an+$moyenne_bn_75ans+$moyenne_nb_entre)/3);
	$moyenne_nb_1an = intval(0.5+$moyenne_nb_1an/3);
	$moyenne_nb_uhcd = intval(0.5+$moyenne_nb_uhcd/3);
	$moyenne_bn_75ans = intval(0.5+$moyenne_bn_75ans/3);
	$moyenne_nb_entre = intval(0.5+$moyenne_nb_entre/3);
	$moyenne_nb_hosp = intval(0.5+$moyenne_nb_hosp/3);
	$moyenne_nb_transferts = intval(0.5+$moyenne_nb_transferts/3);
	// moyenne de 3 jours équivalents
	$requete="SELECT * FROM veille_sau WHERE date IN('$date3','$date4','$date5') ORDER BY date DESC";
	$resultat = ExecRequete($requete,$connexion);
	while($rub1=mysql_fetch_array($resultat))
	{
		$m_nb_1an += $rub1[inf_1_an];
		$m_bn_75ans += $rub1[sup_75_an];
		$m_nb_entre += $rub1[entre1_75];
		$m_nb_hosp += $rub1[hospitalise];
		$m_nb_uhcd += $rub1[uhcd];
		$m_nb_transferts += $rub1[transfert];
	}
	$m_nb_passages = intval(0.5+($m_nb_1an+$m_bn_75ans+$m_nb_entre)/3);
	$m_nb_1an = intval(0.5+$m_nb_1an/3);
	$m_nb_uhcd = intval(0.5+$m_nb_uhcd/3);
	$m_bn_75ans = intval(0.5+$m_bn_75ans/3);
	$m_nb_entre = intval(0.5+$m_nb_entre/3);
	$m_nb_hosp = intval(0.5+$m_nb_hosp/3);
	$m_nb_transferts = intval(0.5+$m_nb_transferts/3);
//================================== Affichage ==================================================
	$msg .="<tr class=\"time_n2\">";
	$msg .="<td>nombre total de passages aux urgences</td>\n";
	$msg .="<td align=\"right\">$nb_passages</td>\n";
	$msg .="<td align=\"right\">$moyenne_nb_passages</td>\n";
	if($moyenne_nb_passages==0)$evolution='erreur';
	else $evolution=intval(0.5+($nb_passages/$moyenne_nb_passages-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
	$msg .="<td align=\"right\">$m_nb_passages</td>\n";
	if($moyenne_nb_passages==0)$evolution='erreur';
	else $evolution=intval(0.5+($nb_passages/$m_nb_passages-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
$msg .="</tr>\n";
$msg .="<tr class=\"time_n2\">";
	$msg .="<td>nombre de passages enfants de moins de 1 an</td>\n";
	$msg .="<td align=\"right\">$nb_1an</td>\n";
	$msg .="<td align=\"right\">$moyenne_nb_1an</td>\n";
	$evolution=intval(0.5+($nb_1an/$moyenne_nb_1an-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
	$msg .="<td align=\"right\">$m_nb_1an</td>\n";
	$evolution=intval(0.5+($nb_1an/$m_nb_1an-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
$msg .="</tr>\n";
$msg .="<tr class=\"time_n2\">";
	$msg .="<td>nombre de passages de plus de 75 ans</td>\n";
	$msg .="<td align=\"right\">$bn_75ans</td>\n";
	$msg .="<td align=\"right\">$moyenne_bn_75ans</td>\n";
	$evolution=intval(0.5+($bn_75ans/$moyenne_bn_75ans-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
	$msg .="<td align=\"right\">$m_bn_75ans</td>\n";
	$evolution=intval(0.5+($bn_75ans/$m_bn_75ans-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
$msg .="<tr class=\"time_n2\">";
	$msg .="<td>nombre de passages entre 1 et 75 ans</td>\n";
	$msg .="<td align=\"right\">$nb_entre</td>\n";
	$msg .="<td align=\"right\">$moyenne_nb_entre</td>\n";
	$evolution=intval(0.5+($nb_entre/$moyenne_nb_entre-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
	$msg .="<td align=\"right\">$m_nb_entre</td>\n";
	$evolution=intval(0.5+($nb_entre/$m_nb_entre-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
$msg .="</tr>\n";
$msg .="<tr class=\"time_n2\">";
	$msg .="<td>nombre d'hospitalisations hors ZSTCD</td>\n";
	$msg .="<td align=\"right\">$nb_hosp</td>\n";
	$msg .="<td align=\"right\">$moyenne_nb_hosp</td>\n";
	$evolution=intval(0.5+($nb_hosp/$moyenne_nb_hosp-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
	$msg .="<td align=\"right\">$m_nb_hosp</td>\n";
	$evolution=intval(0.5+($nb_hosp/$m_nb_hosp-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
$msg .="</tr>\n";
$msg .="<tr class=\"time_n2\">";
	$msg .="<td>nombre d'hospitalisations en ZSTCD</td>\n";
	$msg .="<td align=\"right\">$nb_uhcd</td>\n";
	$msg .="<td align=\"right\">$moyenne_nb_uhcd</td>\n";
	$evolution=intval(0.5+($nb_uhcd/$moyenne_nb_uhcd-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
	$msg .="<td align=\"right\">$m_nb_uhcd</td>\n";
	$evolution=intval(0.5+($nb_uhcd/$m_nb_uhcd-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
$msg .="</tr>\n";
$msg .="<tr class=\"time_n2\">";
	$msg .="<td>nombre de transferts</td>\n";
	$msg .="<td align=\"right\">$nb_transferts</td>\n";
	$msg .="<td align=\"right\">$moyenne_nb_transferts</td>\n";
	$evolution=intval(0.5+($nb_transferts/$moyenne_nb_transferts-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
	$msg .="<td align=\"right\">$m_nb_transferts</td>\n";
	$evolution=intval(0.5+($nb_transferts/$m_nb_transferts-1)*100)." %";
	$msg .="<td align=\"right\">$evolution</td>\n";
$msg .="</tr>\n";
$msg .="</table>";

$msg .="<br>";
$msg .="Nombre de services d'urgence ayant répondu: ".$n."<br>";
$sau = 19;
$msg .="Nombre de services d'urgence autorisés: ".$sau."<br>";
$msg .="Pourcentage de réponse: ".intval(0.5+($n/$sau)*100)." %<br>";
$msg .="Comparaison faite avec les 3 jours identiques suivants:<br>";
$msg .=jour_de_la_semaine($date3)." ".uDate2French($date3)."<br>";
$msg .=jour_de_la_semaine($date4)." ".uDate2French($date4)."<br>";
$msg .=jour_de_la_semaine($date5)." ".uDate2French($date5)."<br>";

return $msg;
}
?>