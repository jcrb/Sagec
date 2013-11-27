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
//	programme: 		distance.php
//	date de création: 	23/09/2005
//	auteur:			jcb
//	description:		Distance orthodromique entre 2 villes
//	version:		1.0
//	modifié le		23/09/2005
//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require './../utilitaires/globals_string_lang.php';
include("./../utilitairesHTML.php");
require("./../pma_connect.php");
require("./../pma_connexion.php");

print("<html>");
print("<head>");
print("<title> Distances </title>");
print("<LINK REL=stylesheet HREF=\"./../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM name=\"distance\" action=\"#\" method=\"get\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$langue = $_SESSION['langue'];


function orthodro($latA,$longA,$latB,$longB)
{
	$ortho = acos(cos(deg2rad($latA))*cos(deg2rad($latB))*cos(deg2rad($longA-$longB))+sin(deg2rad($latA))*sin(deg2rad($latB)));
	return $ortho * 6366;
}
function cmp ($a, $b) {
    if ($a['dist'] == $b['dist']) return 0;
    return ($a['dist'] > $b['dist']) ? 1 : -1;
}

if($_GET['ok']=='ok')
{
	//print(orthodro(-45,-170,-20,70));
	//print(orthodro(48.585,7.736,52.372,9.738));
	$requete="SELECT ville_longitude, ville_latitude FROM ville WHERE ville_ID='$_GET[ville_1]' OR ville_ID='$_GET[ville2]'";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete."<br>");
	$rub1 = mysql_fetch_array($resultat);
	$rub2 = mysql_fetch_array($resultat);
	$distance = orthodro($rub1['ville_latitude'],$rub1['ville_longitude'],$rub2['ville_latitude'],$rub2['ville_longitude']);
}

print("<fieldset>");
print("<legend> Distance entre 2 villes </legend>");
print("<table>");
	print("<tr>");
		print("<td>ville 1</td>");
		print("<td>");
			select_ville2($connexion,$_GET['ville_1'],$langue,"","ville_1");//retourne $id_ville
		print("</td>");
		if(isset($distance))
		{
			print("<td>"."Distance = ".$distance." km</td>");
		}
	print("</tr>");
	print("<tr>");
		print("<td>ville 2</td>");
		print("<td>");
			select_ville2($connexion,$_GET['ville2'],$langue,"","ville2");//retourne $id_ville
		print("</td>");
	print("</tr>");
		print("<td><input type=\"submit\" name=\"ok\" value=\"ok\"></td>");
	print("<tr>");
	print("</tr>");
print("</table>");
print("</fieldset>");

print("<fieldset>");
print("<legend> Villes proches </legend>");
print("Villes se trouvant dans une rayon de ");
print("<input type=\"text\" name=\"rayon\" value=\"500\" zize=\"4\">");
print(" km autour de ");
select_ville2($connexion,$_GET['ville1'],$langue,"","ville1");//retourne $id_ville
print("<input type=\"submit\" name=\"ok2\" value=\"ok\">");
print("</br>");
if($_GET['ok2']=='ok')
{
	$requete="SELECT ville_longitude, ville_latitude FROM ville WHERE ville_ID='$_GET[ville1]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub1 = mysql_fetch_array($resultat);
	$requete="SELECT ville_nom,ville_ID,ville_longitude, ville_latitude FROM ville ORDER BY ville_longitude,ville_latitude";
	$resultat = ExecRequete($requete,$connexion);
	print("<table>");
	while($rub2 = mysql_fetch_array($resultat))
	{
		$distance = orthodro($rub1['ville_latitude'],$rub1['ville_longitude'],$rub2['ville_latitude'],$rub2['ville_longitude']);
		if($distance <= $_GET['rayon'])
		{
			print("<tr>");
			print("<td>".$rub2['ville_nom']."</td>");
			print("<td>".intval($distance+0.5)."</td>");
			print("</tr>");
		}
	}
	print("</table>");
}
print("</fieldset>");

print("<fieldset>");
print("<legend> Centres de brûlés proches </legend>");

print("<table>");
print("<tr>");
print("<td>");
	print("<table>");
	//----------------------- adultes ----------------------------------------------
	if(!$_GET['adulte'] && !$_GET['enfant'])$c="checked";
	else if($_GET['adulte'])$c="checked"; else $c="";
	print("<tr><td><input type=\"checkbox\" $c name=\"adulte\">Adultes</td></tr>");
	//-----------------------  ET/OU -----------------------------------------------
	if(!$_GET['choix'] || $_GET['choix']=='et')$c="checked"; else $c="";
	print("<tr><td><input type=\"radio\" $c name=\"choix\" value=\"et\">et");
	if($_GET['choix']=='ou')$c="checked"; else $c="";
	print("<input type=\"radio\" $c name=\"choix\" value=\"ou\">ou</td></tr>");
	//------------------------ enfants ---------------------------------------------
	if($_GET['enfant'])$c="checked"; else $c="";
	print("<tr><td><input type=\"checkbox\" $c name=\"enfant\">Enfants</td></tr>");
	print("</table>");
print("</td>");
print("<td>");
	print("<table>");
	if(!$_GET['lits'] || $_GET['lits']=='tous')$c="checked";else $c="";
	print("<tr><td><input type=\"radio\" $c name=\"lits\" value=\"tous\">tous les lits</td>");
	if($_GET['dispo'])$c="checked"; else $c="";
	print("<td><input type=\"checkbox\" $c name=\"dispo\">Uniquement les lits disponibles</td></tr>");
	if($_GET['lits']=='avec_respi')$c="checked"; else $c="";
	print("<tr><td><input type=\"radio\" $c name=\"lits\" value=\"avec_respi\">lits avec respirateur</td>");
	if($_GET['lits']=='sans_respi')$c="checked"; else $c="";
	print("<tr><td><input type=\"radio\" $c name=\"lits\" value=\"sans_respi\">lits sans respirateurs</td>");
	print("</table>");
print("</tr>");
print("</table>");
//------------------------ Rayon -----------------------------------------------
print("Se trouvant dans une rayon de ");
print("<input type=\"text\" name=\"rayon\" value=\"500\" zize=\"4\">");
print(" km autour de ");
if(!$_GET['ville1'])$_GET['ville1']=1;
select_ville2($connexion,$_GET['ville1'],$langue,"","ville1");//retourne $ville1
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
			if($_GET['dispo'] && $_GET['adulte']) $requete .=" AND lit_spe5 > 0 ";//lits pour adultes ventilés disponibles
			elseif($_GET['dispo'] && $_GET['enfant']) $requete .=" AND lit_spe7 > 0 ";//lits pour enfants ventilés disponibles
			else $requete .=" AND lit_spe1 > 0 "; //lits tout venant
			$requete .=" AND lits.service_ID = service.service_ID";
		}
		elseif($_GET['lits']=='sans_respi')
		{
			$requete .=" AND lit_spe1 = 0 and lits.service_ID = service.service_ID";
		}
		else $requete .=" AND lit_spe1 > -1 and lits.service_ID = service.service_ID";
		
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
	if($T) usort($T,"cmp");
	$n = sizeof($T);
	for($i=0;$i<$n;$i++)
	{
		print("<tr class=\"time_b\">");
		$service="<a href=\"../services.php?ttservice=".$T[$i]['service_ID']."\">".$T[$i]['service_nom']."</a>"; //&back=lits_service.php&hopID=&type_service=10
		print("<td>".$service."</td>");
		print("<td>".$T[$i]['Hop_nom']."</td>");//print("<td>".$rub2['Hop_nom']."</td>");
		print("<td>".$T[$i]['ville_nom']."</td>");
		print("<td>".$T[$i]['pays_nom']."</td>");
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