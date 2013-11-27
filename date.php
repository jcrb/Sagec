<?php
/**
*	programme: 			date.php - module de manipulation de dates
*	@date de création: 	23/03/2005
*	@author:			jcb
*	description:		service à modifier
*	@version:			1.1 - $Id: date.php 34 2008-02-19 06:42:06Z jcb $
*	maj le:				03/09/2005
*	@package			Sagec
*/


/** Constantes*/
error_reporting(E_ERROR | E_PARSE);
define('un_jour' , '86400'); // 1 jour en secondes
define('sept_jour',7*un_jour);

/** nb de jpours écoulés depuis un jour donné de la semaine
  * date("w",time()) retourne le jour de la semaine courant sous la forme dimanche = 0, mardi = 2
  * date("w",time())-2 retourne le nb de jours écoulés depuis mardi
  * multiplié par le nb de secondes dans un jour
  * date unix actuelle - nb de secondes écoulées depuis le dernier mardi => date du dernier mardi
  * @data $jour = 0 pour dimanche
  * @return date Unix
  */
function last_weekday($jour)
{
	return (time()-(date("w",time())-$jour)*un_jour);
}


/**
  * lundi 3 février 2010 à 10:33
  * $date: timestamp unix
  */
function dateHeureComplete($date,$langue="FR")
{
	$p = "";
	if($langue == 'FR')
		$p .= jour_de_la_semaine($date,$langue)." ".jour_du_mois($date)." ".mois_courant($date,$langue)." ".annee_courante($date)." à ".date("H:i",$date);
	else if($langue == 'GE')
		$p .= jour_de_la_semaine($date,$langue).", den ".jour_du_mois($date).". ".mois_courant($date,$langue)." ".annee_courante($date)." um ".date("H:i",$date);
	else if($langue == 'UK')
		$p .= jour_de_la_semaine($date,$langue)." ".jour_du_mois($date)." ".mois_courant($date,$langue)." ".annee_courante($date)." at ".date("H:i",$date);
	return $p;
}
/**
  *	renvoie année courante sur 4 chiffres
  */
function annee_courante($date)
{
	return date("Y",$date);
}

/**
  *	renvoie le n° du jour courant
  */
function jour_du_mois($date)
{
	return date("d",$date);
}

/** retourne le jour de la semaine $date = date unix*/
function jour_de_la_semaine($date,$langue="FR")
{
	$semaine = array(array());
	$semaine['FR'][0] = 'Dimanche';
	$semaine['FR'][1] = 'Lundi';
	$semaine['FR'][2] = 'Mardi';
	$semaine['FR'][3] = 'Mercredi';
	$semaine['FR'][4] = 'Jeudi';
	$semaine['FR'][5] = 'Vendredi';
	$semaine['FR'][6] = 'Samedi';
	
	$semaine['GE'][0] = 'Donnerstag';
	$semaine['GE'][1] = 'Montag';
	$semaine['GE'][2] = 'Dienstag';
	$semaine['GE'][3] = 'Mittwoch';
	$semaine['GE'][4] = 'Donnerstag';
	$semaine['GE'][5] = 'Freitag';
	$semaine['GE'][6] = 'Samsatag';
	
	$semaine['UK'][0] = 'Sunday';
	$semaine['UK'][1] = 'Monday';
	$semaine['UK'][2] = 'Tuesday';
	$semaine['UK'][3] = 'Wednesday';
	$semaine['UK'][4] = 'Thursday';
	$semaine['UK'][5] = 'Fryday';
	$semaine['UK'][6] = 'Saturday';
	
	$type_jour = date("w",$date);// dimanche = 0
	return($semaine[$langue][$type_jour]);
}

/**
*	@param $d date au format mysql aaaa-mm-jj 
*	@return jour de la semaine
*/
function msql2jour_semaine($d)
{
	return jour_de_la_semaine(mysqlDateTime2unix($d));
}
/** 
*		retourne le mois en clair
*		@param $date  date unix
*/
function mois_courant($date,$langue='FR')
{
	$mois = array(array());
	
	$mois['FR'][0] = 'janvier';
	$mois['FR'][1] = 'février';
	$mois['FR'][2] = 'mars';
	$mois['FR'][3] = 'avril';
	$mois['FR'][4] = 'mai';
	$mois['FR'][5] = 'juin';
	$mois['FR'][6] = 'juillet';
	$mois['FR'][7] = 'août';
	$mois['FR'][8] = 'septembre';
	$mois['FR'][9] = 'octobre';
	$mois['FR'][10] = 'novembre';
	$mois['FR'][11] = 'décembre';
	
	$mois['GE'][0] = 'Januar';
	$mois['GE'][1] = 'Februar';
	$mois['GE'][2] = 'März';
	$mois['GE'][3] = 'April';
	$mois['GE'][4] = 'Mai';
	$mois['GE'][5] = 'Juni';
	$mois['GE'][6] = 'July';
	$mois['GE'][7] = 'August';
	$mois['GE'][8] = 'September';
	$mois['GE'][9] = 'Oktober';
	$mois['GE'][10] = 'November';
	$mois['GE'][11] = 'Dezember';
	
	$mois['UK'][0] = 'January';	           
	$mois['UK'][1] = 'February';
	$mois['UK'][2] = 'March';
	$mois['UK'][3] = 'April';
	$mois['UK'][4] = 'May';
	$mois['UK'][5] = 'June';
	$mois['UK'][6] = 'July';
	$mois['UK'][7] = 'August';
	$mois['UK'][8] = 'September';
	$mois['UK'][9] = 'October';
	$mois['UK'][10] = 'November';
	$mois['UK'][11] = 'December';
	
	$type_jour = date("n",$date);
	return($mois[$langue][$type_jour-1]);
}
/** retourne le jour de l'année 0 à 365
*	 @param $date date unix
*/
function jour_de_annee($date)
{
	return date("z",$date);
}
/** retourne le n° de la semaine
*@param $date date unix
*/
function semaine_courante($date)
{
	return date('W',$date);
}
/** Transforme une date au format français jj/mm/aaaa en timestamp unix */
function fDate2unix($d)
{
	$i=explode("/",$d);
	$u = mktime(0,0,0,date($i[1]),date($i[0]),date($i[2]));
	return $u;
}
/** 
*		Transforme une date au format français jj/mm/aaaa hh:mm:ss en timestamp unix
*/
function fDatetime2unix($d)
{
	$part=explode(" ",$d);
	$i=explode("/",$part[0]);
	$j=explode(":",$part[1]);
	if(!$j[2])$j[2]=0;
	$u = mktime(date($j[0]),date($j[1]),date($j[2]),date($i[1]),date($i[0]),date($i[2]));
	//print_r($i);print("<br>");print_r($j);print("<br>");print($u);print("<br>");
	return $u;
}
/** Transforme un timestamp unix en date française */
function uDate2French($u)
{
	return date("j/m/Y",$u);
}
/** Transforme un timestamp unix en date MYSQL */
function uDate2MySql($u)
{
	return date("Y-m-d",$u);
}
/** Transforme un timestamp unix en date MYSQL */
function uDateTime2MySql($u)
{
	return date("Y-m-d H:i:s",$u);
}
/** Transforme un timestamp unix en heure française */
function uDate2Frenchtime($u)
{
	return date("H:i:s",$u);
}
/** Transforme un timestamp unix en date:heure française */
function uDate2Frenchdatetime($u)
{
	return date("j/m/Y H:i:s",$u);
}
/** Transforme un timestamp unix en date française */
function uDatetime2French($u)
{
	return date("j/m/Y H:i:s",$u);
}
/** Arrondi une date unix en supprimant la partie horaire*/
function round_u_date($u)
{
	$d = uDate2French($u);
	return fDate2unix($d);
}
/** transforme une date jj/mm/aaaa en aaaa-mm-jj */
function fdate2usdate($d)
{
	$i=explode("/",$d);
	$date= trim($i[2])."-".$i[1]."-".$i[0];
	return $date;
}

/** transforme une date jj/mm/aaaa HH:mm/ss  en aaaa-mm-jj HH:mm:ss*/
function fdate2usdatetime($d)
{
	$a = explode(" ",$d);
	$heure = $a[1];
	$i=explode("/",$a[0]);
	$date= trim($i[2])."-".$i[1]."-".$i[0]." ".$heure;
	return $date;
}

/** transforme une date aaaa-mm-jj hh:mm:ss en jj/mm/aaaa hh:mm:ss */
function usdate2fdate($d)
{
	$i=explode(" ",$d);
	$d=explode("-",$i[0]);
	return $d[2]."/". $d[1]."/".$d[0].' '.$i[1];
}

/** transforme une date aaaa-mm-jj hh:mm:ss en timestamp unix */
function mysqlDateTime2u($d)
{
	$i=explode(" ",$d);
	$d=explode("-",$i[0]);
	$h=explode(":",$i[1]);
	$u = mktime(date($h[0]),date($h[1]),date($h[2]),date($d[1]),date($d[2]),date($d[0]));
	return $u;
}
/** transforme une date aaaa-mm-jj en timestamp unix */
function mysqlDateTime2unix($d)
{
	$dd=explode("-",$d);
	//$u = mktime(date(0,0,0,$dd[1]),date($dd[2]),date($dd[0],1));
	$u = mktime(0,0,0,$dd[1],$dd[2],$dd[0]);
	//print("date unix: ".$u."<br>");
	return $u;
}
/** retourne aujourd'hui à 0h en temps unix*/
function today()
{
	$j = time();
	$time = date("H:i:s",$j);
	$i=explode(":",$time);
	return $j-$i[0]*3600-$i[1]*60-$i[2];
}
/** retourne aujourd'hui en date romaine */
function aujourdhui()
{
	return date("d/m/Y");
}

/** retourne aujourd'hui en date romaine */
function maintenant()
{
	return date("d/m/Y H:i:s");
}

function ferie($mois , $an) 
{
// pour avoir tous les jours feries de l'annee,
// passez un tableau de mois (ferie(range(1,12), $an);
// pour les avoir sur plusieurs annees
// ferie(range(1,24), $an); ferie(range(36,12), $an);
	if (is_array($mois))
	{
		$retour = array();
		foreach ($mois as $m)
		{
			$r = ferie($m, $an);
			$retour[$m] = ferie($m, $an);
		}
		return $retour;
	}

	// calcul des jours feries pour un seul mois.
	if (mktime(0,0,0,$mois, 1,$an) == -1)
	{ 
		return FALSE;
	}
	list($mois, $an) = explode("-", date("m-Y", mktime(0,0,0,$mois, 1, $an)));
	$an = intval($an);
	$mois = intval($mois);

	// une constante
	$jour = 3600*24;

	// quelques fetes mobiles
	$lundi_de_paques['mois'] = date( "n", easter_date($an)+1*$jour);
	$lundi_de_paques['jour'] = date( "j", easter_date($an)+1*$jour);
	$lundi_de_paques['nom'] = "Lundi de P&acirc;ques";

	$ascencion['mois'] = date( "n", easter_date($an)+39*$jour);
	$ascencion['jour'] = date( "j", easter_date($an)+39*$jour);
	$ascencion['nom'] = "Jeudi de l'ascenscion";

	$vendredi_saint['mois'] = date( "n", easter_date($an)-2*$jour);
	$vendredi_saint['jour'] = date( "j", easter_date($an)-2*$jour);
	$vendredi_saint['nom'] = "Vendredi Saint";

	$lundi_de_pentecote['mois'] = date( "n", easter_date($an)+50*$jour);
	$lundi_de_pentecote['jour'] = date( "j", easter_date($an)+50*$jour);
	$lundi_de_pentecote['nom'] = "Lundi de Pentec&ocirc;te";

	// France
	$ferie["Jour de l'an"][1] = 1;
	$ferie["Armistice 39-45 "][5] = 8;
	$ferie["Toussaint"][11] = 1;
	$ferie["Armistice 14-18"][11] = 11;
	$ferie["Assomption"][8] =15;
	$ferie["F&ecirc;te du travail "][5] =1;
	$ferie["F&ecirc;te nationale"][7] =14;
	$ferie["No&euml;l"][12] = 25;
	$ferie["Lendemain de No&euml;l (Alsace seulement)"][12] = 25;
	$ferie[$lundi_de_paques['nom']][$lundi_de_paques['mois']] = $lundi_de_paques['jour'];
	$ferie[$lundi_de_pentecote['nom']][$lundi_de_pentecote['mois']] = $lundi_de_pentecote['jour'];
	$ferie[$ascencion['nom']][$ascencion['mois']] = $ascencion['jour'];
	$ferie[$vendredi_saint['nom']." (Alsace)"][$vendredi_saint['mois']]= $vendredi_saint['jour'];

	// reponse
	$reponse = array();
	while(list($nom, $date)= each($ferie))
	{
		if (isset($date[$mois]))
		{
			// une fete a date calculable
			$reponse[$date[$mois]]=$nom;
		}
	}
	ksort($reponse);
	return $reponse;
}

function jour_ferie()
{/*
   <!--- variable pour préciser l'année... --->
   <cfset viewyear=2005>

   <!--- Calcul des jours feriés --->

    <!--- Calcul du dimanche de paques --->
    <cfscript>
        function CalculPaques(Y) {
          a = Y mod 19;
          b = Int(Y/100);
           C = Y mod 100;
           P = Int(b / 4);
           E = b mod 4;
           F = Int((b + 8) / 25);
           g = Int((b - F + 1) / 3);
           h = (19 * a + b - P - g + 15) mod 30;
           i = Int(C / 4);
           K = C mod 4;
           r = (32 + 2 * E + 2 * i - h - K) mod 7;
          N = Int((a + 11 * h + 22 * r) / 451);
         M = Int((h + r - 7 * N + 114) / 31);
          D = ((h + r - 7 * N + 114) mod 31) + 1;
           return createDate(Y,M,D);
       }
 </cfscript>

   <!--- Dates fixes --->
   <CFSET JourFerie["Jour de l'an"]=createDate(viewYear,1,1)>
   <CFSET JourFerie["Armistice 39-45"]=createDate(viewYear,5,8)>
   <CFSET JourFerie["Toussaint"]=createDate(viewYear,11,1)>
   <CFSET JourFerie["Assomption"]=createDate(viewYear,8,15)>
   <CFSET JourFerie["Fête du Travail"]=createDate(viewYear,5,1)>
   <CFSET JourFerie["Fête nationale"]=createDate(viewYear,7,14)>
   <CFSET JourFerie["Noël"]=createDate(viewYear,12,25)>

   <!--- Dates dépendantes du jour de paque --->
  <CFSET JourFerie["Lundi de Pâques"]=DateAdd("d",1,CalculPaques(viewYear))>
   <CFSET JourFerie["Ascencion"]=DateAdd("d",39,CalculPaques(viewYear))>
   <CFSET JourFerie["Lundi de Pentecôte"]=DateAdd("d",50,CalculPaques(viewYear))>

 <cfdump var="#JourFerie#">
 */
}
?>
