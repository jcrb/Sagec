<?php
// arh_utilitaire.php

$nb_zone = 12;
$nb_territoires = 4;
$zones = array('Altkirch','Colmar','Guebwiller','Haguenau','Molsheim-Schirmeck','Mulhouse','Obernai-Sélestat','Saint Louis','Saverne','Strasbourg','Thann','Wissembourg');
$territoire_sante = array('Haguenau','Strasbourg','Colmar','Mulhouse');
$departements = array('Bas-Rhin','Haut-Rhin');
define( "NEONAT", "1" );
define( "REANEONAT", "2" );
define( "REAPED", "3" );
define( "PED", "4" );
define( "REAMED", "5" );
define( "REACHIR", "6" );
define( "REAMIXTE", "7" );
define( "SI", "8" );
define( "MEDECINE", "9" );
define( "CHIRURGIE", "10" );
define( "GYNOBS", "11" );
define( "SAU", "12" );
define( "RFONC", "13" );
define( "SSUITE", "14" );

define( "HOPITAL", "1" );
define( "ZONE_PROXIMITE", "2" );
define( "TERRITOIRE_SANTE", "3" );
define( "DEPARTEMENT", "4" );
define( "REGION", "5" );

/**
* additionne 2 tableaux
*/
function sum_array($a,$b)
{
	$c = array();
	$d = array();
	$na = sizeof($a);
	$nb = sizeof($b);
	if($na > $nb)
	{
		$c = $a;
		$d = $b;
		$max = $nb;
	}
	else
	{
		$c = $b;
		$d = $a;
		$max = $na;
	}
	for($i = 0; $i < $max; $i++)
		$c[$i] += $d[$i];
	return $c;
}

function getTerritoire($type,$no)
{
	global $territoire_sante,$zones,$departements;
	switch($type){
		case TERRITOIRE_SANTE:
			$m = "Territoire de santé n°".$no." (".$territoire_sante[$no-1].")";
			break;
		case ZONE_PROXIMITE:
			$m = "Zone de proximité n°".$no." (".$zones[$no-1].")";
			break;
	}
	return $m;
}
/*
* \fn enumere_lits_specialite_dispo($territoire,$specialite,$date)
* Fait la liste des hôpitaux et des services d'un territoire donné et indique pour une date donnée
* le nombre de lits installés et disponibles ainsi que le ratio des 2 pour une spécialité donnée.
* @param $territoire n° du ou des territoires concernés (tableau)
* @param $specialite spécialité concernée
* @param $date1 date de départ, format unix
* @param $date2 date de fin, format unix
*/	
function enumere_lits_specialite_dispo($territoire,$specialite,$date1,$date2=0)
 {
 	global $connexion;
 	//$d1 = fDate2unix($date);
 	$d1 = $date1;
 	if($date2 == 0)
 		$d2 = $d1 + un_jour;
 	else $d2 = $date2;
 	
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
					//print($requete."<br>");
	$resultat = ExecRequete($requete,$connexion);
	
	while($rub=mysql_fetch_array($resultat))
	{
		print($rub['Hop_nom']." ".$rub['service_nom']." lits installés: ".$rub['lits_sp']." Lits disponibles: ".$rub['lits_dispo']." ratio: ".sprintf("%01.2f",$rub['lits_dispo']/$rub['lits_sp'])."<br>");
	}
	print("<br>");
}


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


function specialite()
{
	$msg .="<tr class=\"time_b\">";
		$msg .="<td rowspan=\"4\" valign=\"middle\">Pédiatrie</td>\n";
		$msg .="<td>Néonatalogie (avec ou sans SI</td>\n";
			$specialite = NEONAT;
			$zone = TERRITOIRE_SANTE;
			$num_zone = 2;
			//$rep = calculs($specialite,$date1,$zone,$num_zone);
			//$rep = calculs(NEONAT,$date1,DEPARTEMENT,67);
			$rep = calculs(NEONAT,$date1,ZONE_PROXIMITE,11);
		$msg .="<td align=\"center\">".$rep['tot_lits']."</td>\n";
		$msg .="<td align=\"center\">".$rep['installes']."</td>\n";
		$msg .="<td align=\"center\">".$rep['ratio_installes']."%</td>\n";
// Remplissage pour la pédiatrie
			$territoire = 2;
			
			// lits disponibles à $date1
			$rep = lits_specialite_dispo($territoire,$specialite,$date1);
			$lits_dispo1 = $rep['lits_dispo'];
		$msg .="<td align=\"center\">".$rep['lits_dispo']."</td>\n";
		$msg .="<td align=\"center\">".$rep['ratio_installes']."%</td>\n";
			$evolution = $rep['ratio_installes'];
			$op = 1;// moyenne
			$recul = 3;// nombre de jours en arrière
			$d2 = $date1;
			$d1 = $d2 - un_jour * $recul;
			print("d1 = ".uDate2Frenchdatetime($d1)."<br>");print("d2 = ".uDate2Frenchdatetime($d2)."<br>");
			// lits disponibles en moyenne ces 3 derniers jours
			$rep = lits_specialite_dispo($territoire,$specialite,$d1,$d2,$op,0);
			$evolution = $evolution-$rep['ratio_installes'];
		$msg .="<td align=\"center\">".$rep['lits_dispo']."</td>\n";
		$msg .="<td align=\"center\">".$evolution."%</td>\n";
			$repetition=3;
			// trois jours identiques
			$rep = lits_specialite_dispo($territoire,$specialite,$date1,0,$op,$repetition);
			$evolution = intval(100*($lits_dispo1/$rep['lits_dispo'] - 1)); 
		$msg .="<td align=\"center\">".$rep['lits_dispo']."</td>\n";
		$msg .="<td align=\"center\">".$evolution."%</td>\n";
	$msg .="</tr>\n";
	
	return $msg;
}
?>