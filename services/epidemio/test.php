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
//													//
//	programme: 		test.php							//
//	date de création: 	15/04/2004								//
//	auteur:			jcb									//
//	description:		affiche un choix d'options		//
//	version:		1.0									//
//	maj le:			15/04/2004								//
//													//
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_hopital'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../../pma_connect.php");
require("../../pma_connexion.php");
require '../../utilitaires/globals_string_lang.php';
require "../../utilitairesHTML.php";
require "../../date.php";

print("<html>");
print("<head>");
print("<title> gestion des tâches </title>");
print("<LINK REL=stylesheet HREF=\"../../pma.css\" TYPE =\"text/css\">");
print("<LINK REL = \"stylesheet\" TYPE = \"text/css\" HREF = \"../service.css\">");
print("</head>");

print("<form name=\"services\" method=\"get\" action=\"test.php\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

if($_GET['ok']&&$_GET['date'])
{
	$s=$_GET['service'];
	$l=$_GET['litsd'];
	$c=$_GET['check'];
	$date=fDatetime2unix($_GET['date']);	//$_GET['date']
	for($i=0;$i<sizeof($l);$i++)
	{
		if($s[$i] && $l[$i]!=''){
			$requete="INSERT INTO lits_journal VALUES('$date','$s[$i]','$l[$i]','$_SESSION[member_id]')";
			$resultat = ExecRequete($requete,$connexion);
			$requete = "UPDATE lits SET
				lits_dispo = '$l[$i]',
				date_maj = '$date'
				WHERE service_ID = '$s[$i]'";
			$resultat = ExecRequete($requete,$connexion);
			//print($l[$i]." ".$s[$i]." ".$s[$i]."<br>");
		}
	}
}

print("<table width=\"100%\">");
print('<tr>');
	$mot = $string_lang['LISTE_SERVICE_HOPITAL'][$langue];
	print("<td><H3>$mot</H3></td>");
	print("<td>date</td>");
	$date=date("j/m/Y H:i:s");
	print("<td><input type=\"text\" name=\"date\" value=\"$date\"></td>");
	print("<td><input type=\"button\" name=\"calendrier\" value=\"...\"></td>");
print('<tr>');
print("</table>");

print("<TABLE WIDTH=\"100%\" CLASS=\"Style22\">");
	TblDebutLigne("A2");
		//$modifier = $string_lang['MODIFIER'][$langue];print("<TH>$modifier</TH>");//TblCellule("$modifier");
		$mot = $string_lang['SELECT_SERVICE'][$langue];
		print("<TH><a href=\"test.php?tri=service\">$mot</a></TH>");//TblCellule("<div align=\"center\"> $mot");
		$mot = $string_lang['TYPE'][$langue];
		print("<TH><a href=\"test.php?tri=type\">$mot</a></TH>");//TblCellule("<div align=\"center\"> $mot");
		$mot = $string_lang['LITS'][$langue];print("<TH>$mot</TH>");//TblCellule("<div align=\"center\"> $mot");
		$mot = $string_lang['LITS_DISPO'][$langue];print("<TH>$mot</TH>");
		$mot = $string_lang['MAJ'][$langue];print("<TH>$mot</TH>");//TblCellule("<div align=\"center\"> $mot");
	TblFinLigne();
if($_SESSION["service"]>0)
		$requete = "SELECT service.service_ID,service_nom,service_code,lits_sp,lits_dispo,date_maj,type_nom
				FROM service, lits,type_service
				WHERE service.service_ID = $_SESSION[service]
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = type_service.Type_ID
				ORDER BY 
				";//service.org_ID = $_SESSION[organisation]
	else
		$requete = "SELECT service.service_ID,service_nom,service_code,lits_sp,lits_dispo,date_maj,type_nom,service.Type_ID
				FROM service, lits,type_service
				WHERE service.org_ID = $_SESSION[organisation]
				AND service.service_ID = lits.service_ID
				AND service.Type_ID = type_service.Type_ID
				ORDER BY 
				";
	switch($_GET['tri']){
		case 'service':$requete.='service_nom';break;
		case 'type':$requete.='type_nom';break;
		default:$requete.='type_nom';break;
	}

	$resultat = ExecRequete($requete,$connexion);
	while($i = LigneSuivante($resultat))
	{
		if($_style=="A5")$_style="A6";
		else $_style="A5";
		TblDebutLigne("$_style");
		$identifiant = $i->service_ID;
		$type = $i->Type_ID;
		TblCellule("$i->service_nom");
		$mot = $string_lang["$i->type_nom"][$langue];
		TblCellule($mot);
		TblCellule("<div align=\"right\"> $i->lits_sp");
		print("<td>");
		// lits disponibles
		print("<div align=\"right\"><input type=\"text\" name=\"litsd[]\" value=\"$i->lits_dispo\" size=\"3\" ></div>");
		print("<input type=\"hidden\" name=\"service[]\" value=\"$i->service_ID\">");
		print("</td>");
		if($i->date_maj < 1)
			$d = "indéterminé";
		else
			$d = date("j/m/Y H:i",$i->date_maj);
		TblCellule("<div align=\"right\"> $d");
		$total[$i->type_nom] = $total[$i->type_nom] + $i->lits_dispo;
	}
print("</TABLE>");
print("<input type=\"submit\" name=\"ok\" value=\"Valider\">");
print("</form>");
?>
