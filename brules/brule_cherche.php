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
*	programme: 		brule_cherche.php
*	date de cr�ation: 	23/09/2005
*	auteur:			jcb
*	description:		Distance orthodromique entre 2 villes
*	@version:		$Id: brule_cherche.php 35 2008-02-19 22:50:08Z jcb $
*	modifi� le		23/09/2005
*/
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "./../";
require './../utilitaires/globals_string_lang.php';
include("./../utilitairesHTML.php");
require("./../pma_connect.php");
require("./../pma_connexion.php");
require($backPathToRoot."login/init_security.php");
$langue = $_SESSION['langue'];

print("<html>");
print("<head>");
print("<title> Distances </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM name=\"distance\" action=\"#\" method=\"get\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$langue = $_SESSION['langue'];

/**
* Calcul de la distance orthodromique entre deux points
* @version $Id: brule_cherche.php 35 2008-02-19 22:50:08Z jcb $
* @author JCB
* @param [in] $latA  latitude du point A
* @param [in] $longA longitude du point A
* @param [in] $latB  latitude du point B
* @param [in] $longB longitude du point B
* @return distance en km
*/
function orthodro($latA,$longA,$latB,$longB)
{
	$ortho = acos(cos(deg2rad($latA))*cos(deg2rad($latB))*cos(deg2rad($longA-$longB))+sin(deg2rad($latA))*sin(deg2rad($latB)));
	return $ortho * 6366;
}

/**
* fonction de comparaison
* @param [in] $a valeur A
* @param [in] $b valeur B
* @return 0 si a = b, 1 si a > b, -1 si a < b
*/
function cmp ($a, $b) {
    if ($a['dist'] == $b['dist']) return 0;
    return ($a['dist'] > $b['dist']) ? 1 : -1;
}

if($_GET['ok']=='ok')
{
	//print(orthodro(-45,-170,-20,70));
	//print(orthodro(48.585,7.736,52.372,9.738));
	$requete="SELECT ville_longitude, ville_latitude FROM ville WHERE ville_ID='$_GET[ville1]' OR ville_ID='$_GET[ville2]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub1 = mysql_fetch_array($resultat);
	$rub2 = mysql_fetch_array($resultat);
	$distance = orthodro($rub1['ville_latitude'],$rub1['ville_longitude'],$rub2['ville_latitude'],$rub2['ville_longitude']);
}

print("<fieldset class=\"Style25\">");
print("<legend>".$string_lang['CENTRE_DE_BRULES_PROCHES'][$langue]."</legend>");

print("<table bgcolor=\"orange\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" class=\"Style25\">");
print("<tr>");
print("<td>");
	print("<fieldset class=\"Style25\">");
	print("<legend>".$string_lang['AGE'][$langue]."</legend>");
	print("<table class=\"Style25\">");
	//----------------------- adultes ----------------------------------------------
	if(!$_GET['adulte'] && !$_GET['enfant'])$c="checked";
	else if($_GET['adulte'])$c="checked"; else $c="";
	print("<tr><td><input type=\"checkbox\" $c name=\"adulte\">".$string_lang['ADULTE'][$langue]."</td></tr>");
	//-----------------------  ET/OU -----------------------------------------------
	if(!$_GET['choix'] || $_GET['choix']=='et')$c="checked"; else $c="";
	print("<tr><td><input type=\"radio\" $c name=\"choix\" value=\"et\">".$string_lang['ET'][$langue]);
	if($_GET['choix']=='ou')$c="checked"; else $c="";
	print("<input type=\"radio\" $c name=\"choix\" value=\"ou\">".$string_lang['OU'][$langue]."</td></tr>");
	//------------------------ enfants ---------------------------------------------
	if($_GET['enfant'])$c="checked"; else $c="";
	print("<tr><td><input type=\"checkbox\" $c name=\"enfant\">".$string_lang['ENFANT'][$langue]."</td></tr>");
	print("</table>");
	print("</fieldset>");
print("</td>");
print("<td>");
	print("<fieldset class=\"Style25\">");
	print("<legend> ".$string_lang['LITS'][$langue]." </legend>");
	print("<table class=\"Style25\">");
	if(!$_GET['lits'] || $_GET['lits']=='tous')$c="checked";else $c="";
	$mot=$string_lang['TOUS'][$langue]." ".$string_lang['LITS'][$langue];
	print("<tr><td><input type=\"radio\" $c name=\"lits\" value=\"tous\">$mot</td>");
	if($_GET['dispo'])$c="checked"; else $c="";
	$mot=$string_lang['SEULEMENT'][$langue]." ".$string_lang['LITS_DISPO'][$langue];
	print("<td><input type=\"checkbox\" $c name=\"dispo\">$mot</td></tr>");
	if($_GET['lits']=='avec_respi')$c="checked"; else $c="";
	print("<tr><td><input type=\"radio\" $c name=\"lits\" value=\"avec_respi\">".$string_lang['LITS_RESPI'][$langue]."</td>");
	if($_GET['lits']=='sans_respi')$c="checked"; else $c="";
	print("<tr><td><input type=\"radio\" $c name=\"lits\" value=\"sans_respi\">".$string_lang['LITS_SANS_RESPI'][$langue]."</td>");
	print("</table>");
	print("</fieldset>");
print("</tr>");
print("</table>");
//------------------------ Rayon -----------------------------------------------
print($string_lang['RAYON'][$langue]." ");//se trouvant dans un ryon de 
if($_GET['rayon']=='') $_GET['rayon']='500';
print("<input type=\"text\" name=\"rayon\" value=\"$_GET[rayon] \" size=\"4\">");
print(" km ".$string_lang['AUTOUR'][$langue]." ");//print(" km autour de ");
if($_GET['ville1']=='') $_GET['ville1']='1';
select_ville2($connexion,$_GET['ville1'],$langue,"","ville1");//retourne $id_ville
print("<input type=\"submit\" name=\"ok3\" value=\"ok\">");
print("</br>");
//============================ Recherche et affichage =====================================================
if($_GET['ok3']=='ok')
{
	$requete="SELECT ville_longitude, ville_latitude FROM ville WHERE ville_ID='$_GET[ville1]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub1 = mysql_fetch_array($resultat);
	$requete="SELECT service.service_ID, service_nom,Hop_nom,ville_nom,ville_longitude, ville_latitude,pays_nom,lit_spe1
			FROM service,ville,hopital,adresse,pays,lits
			WHERE service.type_ID = 10";
		if($_GET['adulte'] && $_GET['enfant'])
		{
			if($_GET['choix']=='ou')
				$requete .= " AND (service_adulte = 'o' OR service_enfant = 'o')";
			else
				$requete .= " AND service_adulte = 'o' AND service_enfant = 'o'";
		}
		elseif($_GET['adulte']) $requete .=" AND service_adulte = 'o' ";
		elseif($_GET['enfant']) $requete .=" AND service_enfant = 'o' ";
		$requete .="
			AND service.Hop_ID = hopital.Hop_ID
			AND hopital.adresse_ID = adresse.ad_ID
			AND adresse.ville_ID = ville.ville_ID
			AND pays.pays_ID = ville.pays_ID ";
		if($_GET['lits']=='avec_respi')
		{
			if($_GET['dispo'] && $_GET['adulte']) $requete .=" AND lit_spe5 > 0 ";//lits pour adultes ventil�s disponibles
			elseif($_GET['dispo'] && $_GET['enfant']) $requete .=" AND lit_spe7 > 0 ";//lits pour enfants ventil�s disponibles
			else $requete .=" AND lit_spe1 > 0 "; //lits tout venant
			$requete .=" AND lits.service_ID = service.service_ID";
		}
		elseif($_GET['lits']=='sans_respi')
		{
			$requete .=" AND lit_spe1 = 0 and lits.service_ID = service.service_ID";
		}
		else $requete .=" AND lit_spe1 > -1 and lits.service_ID = service.service_ID";
		// Ordre de tri
		if($_GET['tri']=='service') $requete .=" ORDER BY service.service_nom";
	//print($requete.'<br>');
	$resultat = ExecRequete($requete,$connexion);
	
	while($rub2 = mysql_fetch_array($resultat))
	{
		$distance = intval(0.5+orthodro($rub1['ville_latitude'],$rub1['ville_longitude'],$rub2['ville_latitude'],$rub2['ville_longitude']));
		if($distance <= $_GET['rayon'])
		{
			$rub2[] = $distance;
			$rub2['dist'] = $distance;
			$T[]=$rub2;
		}
	}
	
	print("<hr><table>");
	if($_GET['tri']=='' || $_GET['tri']=='distance')
	{
		if($T) usort($T,"cmp");
		$n = sizeof($T);
	}
	else $n = sizeof($T);
	
	print("<tr>");//GET['adulte'] && !$_GET['enfant']
		//print("<td><a href=\"brule_cherche.php?tri=service&rayon=$_GET[rayon]&ville1=$_GET[ville1]&ok3=ok\">Service</a></td>");
	$suite="&rayon=$_GET[rayon]&ville1=$_GET[ville1]&ok3=ok&adulte=$_GET[adulte]&enfant=$_GET[enfant]&choix=$_GET[choix]&lits=$_GET[lits]&dispo=$_GET[dispo]";
		print("<td><a href=\"brule_cherche.php?tri=service$suite\">".$string_lang['SERVICE'][$langue]."</a></td>");
		print("<td>".$string_lang['HOPITAL'][$langue]."</td>");
		print("<td>".$string_lang['VILLE'][$langue]."</td>");
		print("<td>".$string_lang['PAYS'][$langue]."</td>");
		print("<td>".$string_lang['DISTANCE'][$langue]." (km)</td>");
	print("</tr>");
	
	for($i=0;$i<$n;$i++)
	{
		print("<tr class=\"time_b\">");
		//print("<td>".$T[$i]['service_nom']."</td>");
		$ref = $T[$i]['service_ID'];
		$nom = db2str($T[$i]['service_nom']);
		print("<td><a href=\"brule_service.php?service_ID=$ref\">$nom</a></td>");
		print("<td>".$T[$i]['Hop_nom']."</td>");//print("<td>".$rub2['Hop_nom']."</td>");
		print("<td>".$T[$i]['ville_nom']."</td>");
		print("<td>".$string_lang[$T[$i]['pays_nom']][$langue]."</td>");//$T[$i]['pays_nom']
		print("<td align=\"right\">".$T[$i]['dist']."</td>");
		print("</tr>");
	}
	print("</table>");
	//print_r($T);
}
print("</fieldset>");

print("</FORM>");
print("</html>");
?>