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
*	programme: 		service_liste.php							
*	date de cr�ation: 	15/04/2004								
*	auteur:			jcb									
*	description:		affiche la liste des services		
*	version:		1.3									
*	maj le:			09/09/2005		
*/	
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
if(!($_SESSION['auto_hopital']||$_SESSION['auto_service']||$_SESSION['auto_organisme']))header("Location:../logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/globals_string_lang.php';
require "../utilitairesHTML.php";

print("<html>");
print("<head>");
print("<title> gestion des t�ches </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("<LINK REL = \"stylesheet\" TYPE = \"text/css\" HREF = \"service.css\">");
print("</head>");

$mot = $string_lang['LISTE_SERVICE_HOPITAL'][$langue];
Print("<H3>$mot</H3>");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

//TblDebut(0,"100%");
print("<TABLE WIDTH=\"100%\" CLASS=\"Style22\">");
	TblDebutLigne("A2");
		$modifier = $string_lang['MODIFIER'][$langue];print("<TH>$modifier</TH>");//TblCellule("$modifier");
		$mot = $string_lang['SELECT_SERVICE'][$langue];
		print("<TH><a href=\"service_liste.php?tri=service\">$mot</a></TH>");
		$mot = $string_lang['TYPE'][$langue];
		print("<TH><a href=\"service_liste.php?tri=type\">$mot</a></TH>");
		$mot = $string_lang['LITS'][$langue];print("<TH>$mot</TH>");//TblCellule("<div align=\"center\"> $mot");
		$mot = $string_lang['PLACES'][$langue];print("<TH>$mot</TH>");
		$mot = $string_lang['MAJ'][$langue];
		print("<TH><a href=\"service_liste.php?tri=date\">$mot</a></TH>");
	TblFinLigne();

	switch($_GET['tri']){
		case 'service':$tri=" ORDER BY service_nom";break;
		case 'type':$tri=" ORDER BY type_nom";break;
		case 'date':$tri=" ORDER BY date_maj";break;
		default:$tri=" ORDER BY service_nom";break;
	}

	// Si Priorite_Alerte = 9, ne pas afficher
	if($_SESSION['auto_org']=='o'){
		$requete="SELECT service.service_ID,service_nom,service_code,lits_dispo,places_dispo,date_maj,type_nom
				FROM service,lits,type_service
				WHERE service.org_ID = '$_SESSION[organisation]'
				AND service.Priorite_Alerte <> 9
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = type_service.Type_ID
				";
				$requete.=$tri;
		}

	
	/*	
	if($_SESSION['auto_org']=='o'){
		$requete="SELECT service.service_ID,service_nom,service_code, lits_dispo,date_maj,type_nom,service.Type_ID,places_dispo
				FROM service,hopital, lits,type_service
				WHERE hopital.org_ID = '$_SESSION[organisation]'
				AND service.Priorite_Alerte <> 9
				AND service.Hop_ID = hopital.Hop_ID
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = type_service.Type_ID";
				$requete.=$tri;}
	*/
	elseif($_SESSION["auto_hopital"]=='o'){
		$requete="SELECT service.service_ID,service_nom,service_code, lits_dispo,date_maj,type_nom,service.Type_ID,places_dispo
				FROM service, lits,type_service
				WHERE service.Hop_ID = '$_SESSION[Hop_ID]'
				AND service.Priorite_Alerte <> 9
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = type_service.Type_ID
				";
				$requete.=$tri;}


	elseif($_SESSION["service"]>0){
		$requete = "SELECT service.service_ID,service_nom,service_code, lits_dispo,date_maj,type_nom,service.Type_ID,places_dispo
				FROM service, lits,type_service
				WHERE service.service_ID = '$_SESSION[service]'
				AND service.Priorite_Alerte <> 9
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = type_service.Type_ID
				";
				$requete.=$tri;}

	$resultat = ExecRequete($requete,$connexion);
	//print($requete);
	//print_r($_SESSION);
	//print($_SESSION['auto_org']);
	$_style = "A5";
	$total = array();
	while($i = LigneSuivante($resultat))
	{
		if($_style=="A5")$_style="A6";
		else $_style="A5";
		TblDebutLigne("$_style");
		$identifiant = $i->service_ID;
		$type = $i->Type_ID;
		$mot = $string_lang["MODIFIER"][$langue];
		TblCellule("<a href=\"service_modifie.php?service=$identifiant&type=$type\" TARGET=\"midle\">$mot</a>");
		TblCellule("[".$i->service_code."] ".$i->service_nom);
		$mot = $string_lang["$i->type_nom"][$langue];
		TblCellule($mot);
		TblCellule("<div align=\"right\"> $i->lits_dispo");
		TblCellule("<div align=\"right\"> $i->places_dispo");
		if($i->date_maj < 1)
			$d = "ind�termin�";
		else
			$d = date("j/m/Y H:i",$i->date_maj);
		TblCellule("<div align=\"right\"> $d");
		$total[$i->type_nom] = $total[$i->type_nom] + $i->lits_dispo;
		$total_place[$i->type_nom] = $total_place[$i->type_nom] + $i->places_dispo;
	}
TblFin();

print("<br>");
print("<fieldset class=\"time_v\">");
$mot = $string_lang["TOTAL_SPECIALITE"][$langue];
print("<legend>$mot</legend>");

$requete = "SELECT type_nom FROM type_service ORDER BY type_nom";
$resultat = ExecRequete($requete,$connexion);
print("<table class=\"Style22\" width=\"50%\">");
print("<TR>");
	print("<TH>".$string_lang['SERVICE'][$langue]."</TH>");
	print("<TH>".$string_lang['LITS'][$langue]."</TH>");
	print("<TH>".$string_lang['PLACES'][$langue]."</TH>");
print("</TR>");
while($i = LigneSuivante($resultat))
{
	print("<tr><td>".$string_lang[$i->type_nom][$langue]."</td>");
	print("<td align=\"rigth\">".$total[$i->type_nom]."</td>");
	print("<td align=\"rigth\">".$total_place[$i->type_nom]."</td></tr>");
}
print("</table>");
print("</fieldset>");

print("</FORM>");
print("</BODY>");
print("</html>");
?>
