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
//----------------------------------------- SAGEC --------------------------------------------------------
/**													
*	programme 			saisie rapide.php
*	@date de création: 	15/08/2005
*	@author:			jcb
*	description:		Saisie en une fois de tous les lits disponibles d'un organisme ou d'un établissement
*						Si une zone de saisie est laissée en blanc, la valeur précédamment enregistrée est
*						conservée
*	@version:			1.0 - $Id: saisie_rapide.php 23 2007-09-21 03:50:41Z jcb $
*	maj le:				15/08/2005
*	@package			Sagec
*  COMMENTAIRES: fonctionne avec FireFox mais pas avec IE. Le pb provient probablement de la méthode
* 						GET qui ne supporte pas un transfert de données en qté importante. Programme réécrit
*						et divisé en deux:
*						saisie_rapide: ne fait que la saisie
*						saisie_rapide_enregistre: enregistre les données
*/
//--------------------------------------------------------------------------------------------------------
session_start();
if(!$_SESSION['auto_hopital'])header("Location: ../../logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../../pma_connect.php");
require("../../pma_connexion.php");
require '../../utilitaires/globals_string_lang.php';
require "../../utilitairesHTML.php";
require "../../date.php";
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
print("<html>");
print("<head>");
print("<title> gestion des tâches </title>");
print("<LINK REL=stylesheet HREF=\"../../pma.css\" TYPE =\"text/css\">");
print("<LINK REL=stylesheet HREF=\"../service.css\" TYPE = \"text/css\">");
print("</head>");
print("<form name=\"services\" method=\"get\" action=\"saisie_rapide.php\">");

//=============================  Sauvegarde des données  ====================================================
if($_GET['ok'] && $_GET['date'])
{
	//print("saisie rapide<br>");
	$s=$_GET['service'];	// identifiant du service
	$l=$_GET['litsd'];		// tableau des lits disponibles
	$c=$_GET['check'];		
	$p=$_GET['placesd'];	// tableau des places disponibles
	$lits_auto = $_GET['lits_auto'];// tableau du nombre de lits autorisés
	$date=fDatetime2unix($_GET['date']);	//$_GET['date']
	$max = sizeof($l);

	// vérifier qu'il n'ya pas d'erreur de saisie:
	/*
	for($i=0;$i<$max;$i++)
	{
		if($l[$i] > $lits_auto[$i] || $l[$i] < 0)
			header("Location:saisie_rapide.php?erreur=1&id=$s[$i]");
	}
	*/

	for($i=0;$i<$max;$i++)
	{
		if( $s[$i] && is_numeric($l[$i]) || is_numeric($p[$i]) )
		//if( $s[$i] )
		{
			// mise à jour du journal des lits
			$requete="INSERT INTO lits_journal VALUES('$date','$s[$i]','$l[$i]','$_SESSION[member_id]')";
			$resultat = ExecRequete($requete,$connexion);
			// mise à jour du journal des places
			if(is_numeric($p[$i]))
			{
				$requete="INSERT INTO places_journal VALUES('$date','$s[$i]','$p[$i]','$_SESSION[member_id]')";
				$resultat = ExecRequete($requete,$connexion);
			}
			// la mise à jour ne se fait que si la date est plus récente que la date enregistrée
			$requete = "SELECT date_maj FROM lits WHERE service_ID = '$s[$i]'";
			$resultat = ExecRequete($requete,$connexion);
			$last_maj = mysql_fetch_array($resultat);
			$date2 = $last_maj['date_maj'];
			
			//print("service: ".$s[$i]."<br>");
			//print("last_maj = ".$date2." - date = ".$date."<br>");
			
			if(intval($date2) < intval($date))
			{
				$requete = "UPDATE lits SET
										lits_dispo = '$l[$i]',
										places_dispo = '$p[$i]',
										date_maj = '$date'
										WHERE service_ID = '$s[$i]'";
				$resultat = ExecRequete($requete,$connexion);
				//print("date maj <br>");
			}
			//print($l[$i]." ".$s[$i]." ".$s[$i]." ".$p[$i]."<br>");
			$requete = "SELECT date_maj FROM lits WHERE service_ID = '$s[$i]'";
			$resultat = ExecRequete($requete,$connexion);
			$last_maj = mysql_fetch_array($resultat);
			$date3 = $last_maj['date_maj'];
			//print("last_maj = ".$date3." - date = ".$date);
		}
		else print("<br>échec de la mise à jour<br>");
	}
}
//==========================  Saisie des données  ============================================================
print("<table width=\"100%\">");
print('<tr>');
	$mot = $string_lang['LISTE_SERVICE_HOPITAL'][$langue];
	print("<td><H3>$mot</H3></td>");
	print("<td>".$string_lang['DATE'][$langue]."</td>");
	$date=date("j/m/Y H:i:s");
	print("<td><input type=\"text\" name=\"date\" value=\"$date\"></td>");
	print("<td><input type=\"button\" name=\"calendrier\" value=\"...\"></td>");
print('<tr>');
print("</table>");

if($_GET[erreur])
{
	if($_GET[erreur]==1)
		print("Saisie incohérente<br>");
	$err = $_GET[id];// id du service en cause
}

print("<TABLE WIDTH=\"100%\" CLASS=\"Style22\">");
	TblDebutLigne("A2");
		//$modifier = $string_lang['MODIFIER'][$langue];print("<TH>$modifier</TH>");//TblCellule("$modifier");
		$mot = $string_lang['SELECT_SERVICE'][$langue];
		print("<TH><a href=\"saisie_rapide.php?tri=service\">$mot</a></TH>");
		$mot = $string_lang['TYPE'][$langue];
		print("<TH><a href=\"saisie_rapide.php?tri=type\">$mot</a></TH>");
		$mot = $string_lang['LITS'][$langue];print("<TH>$mot</TH>");
		print("<TH>&nbsp;</TH>");
		$mot = $string_lang['LITS_DISPO'][$langue];print("<TH>$mot</TH>");
		$mot = $string_lang['PLACES'][$langue];print("<TH>$mot</TH>");
		$mot = $string_lang['PLACES_DISPO'][$langue];print("<TH>$mot</TH>");
		$mot = $string_lang['MAJ'][$langue];print("<TH>$mot</TH>");
		print("<TH>&nbsp;</TH>");
	TblFinLigne();
	/*
	print("organisme: ".$_SESSION[organisation]."<br>");
	print("hopital: ".$_SESSION[Hop_ID]."<br>");
	print("service: ".$_SESSION[service]."<br>");
	*/
	if($_SESSION['auto_org']=='o'){
		$requete="SELECT service.service_ID,service_nom,service_code, lits_dispo,lits_sp,date_maj,type_nom,places_dispo,places_auto
				FROM service,hopital, lits,type_service
				WHERE hopital.org_ID = '$_SESSION[organisation]'
				AND service.Hop_ID = hopital.Hop_ID
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = type_service.Type_ID
				ORDER BY ";
	}
	elseif($_SESSION["auto_hopital"]=='o')
		$requete="SELECT service.service_ID, service_nom, service_code, lits_dispo,lits_sp, date_maj, type_nom,places_dispo,places_auto
				FROM service, lits,type_service
				WHERE service.Hop_ID = '$_SESSION[Hop_ID]'
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = type_service.Type_ID
				ORDER BY ";

	elseif($_SESSION["service"]>0)
		$requete = "SELECT service.service_ID,service_nom,service_code,lits_dispo,lits_sp,date_maj,type_nom,places_dispo,places_auto
				FROM service, lits,type_service
				WHERE service.service_ID = $_SESSION[service]
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = type_service.Type_ID
				ORDER BY type_nom
				";
	switch($_GET['tri']){
		case 'service':$requete.='service_nom';break;
		case 'type':$requete.='type_nom';break;
		default:$requete.='type_nom';break;
	}
	//print($requete);
	$resultat = ExecRequete($requete,$connexion);
	while($i = LigneSuivante($resultat))
	{
		if($_style=="A5")$_style="A6";
		else $_style="A5";
		if($err == $i->service_ID) $_style="A1";
		TblDebutLigne("$_style");
		$identifiant = $i->service_ID;
		$type = $i->Type_ID;
		//TblCellule("$i->service_nom");
		TblCellule("[".$i->service_code."] ".$i->service_nom);
		$mot = $string_lang["$i->type_nom"][$langue];
		TblCellule($mot);
		TblCellule("<div align=\"right\"> $i->lits_sp");
		// on mémorise le nombre de lits autorisés
		print("<input type=\"hidden\" name=\"lits_auto[]\" value=\"$i->lits_sp\">");
		// lits dispo lors de la dernière maj
		print("<td><div align=\"right\">$i->lits_dispo</div></td>");
		// lits disponibles
		print("<td>");
		print("<div align=\"right\"><input type=\"text\" name=\"litsd[]\" value=\"\" size=\"3\" ></div>");
		print("<input type=\"hidden\" name=\"service[]\" value=\"$i->service_ID\">");
		print("</td>");
		// places autorisées
		TblCellule("<div align=\"right\"> $i->places_auto");
		// places disponibles
		print("<td>");
		print("<div align=\"right\"><input type=\"text\" name=\"placesd[]\" value=\"\" size=\"3\" ></div>");
		print("</td>");
		// date de mise à jour
		if($i->date_maj < 1)
			$d = "indéterminé";
		else
			$d = date("j/m/Y H:i",$i->date_maj);
		TblCellule("<div align=\"right\"> $d");
		$total[$i->type_nom] = $total[$i->type_nom] + $i->lits_dispo;
		$voir = $string_lang['VOIR'][$langue];
		print("<td><a href=\"modifier_lits.php?service=$i->service_ID&nom=$i->service_nom\">$voir</td>");
	}
print("</TABLE>");
print("<input type=\"submit\" name=\"ok\" value=\"Valider\">");
print("</form>");
print("</html>");
?>
