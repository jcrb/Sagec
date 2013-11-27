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
*	programme: 		service_fermeture.php
*	@date de création: 	23/03/2005
*	@author:			jcb
*	description:		service à modifier
*	@version:		1.1 - $Id: service_fermeture.php 9 2006-08-09 08:15:58Z jcb $
*	maj le:			03/09/2005
*	@package		Sagec
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
require "../date.php";

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

/**
* Cherche si un service donné à des lits fermés à la date donnée.
* $date timestamp unix date du jour de recherche
* $service_id int identifiant du service
*/
function lits_fermés($date, $service_id)
{
	global $connexion;
	$requete = "SELECT* FROM lits_fermes WHERE service_ID = '$service_id' AND '$date' BETWEEN debut AND fin";
	$resultat = ExecRequete($requete,$connexion);
	$i = LigneSuivante($resultat);
	return array($i->nb_lits_fermes,$i->date_maj); 
}

print("<html>");
print("<head>");
print("<title> services à modifier </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("<LINK REL = \"stylesheet\" TYPE = \"text/css\" HREF = \"service.css\">");
print("</head>");

print("<FORM name=\"\" action=\"\">");

$mot = $string_lang['LISTE_SERVICE_HOPITAL'][$langue];
$mot="Consulter / modifier les fermetures de lits";
Print("<H3>$mot</H3>");

//TblDebut(0,"100%");
print("<TABLE WIDTH=\"100%\" CLASS=\"Style22\">");
	TblDebutLigne("A2");
		$mot = $string_lang['VOIR'][$langue];print("<TH>$mot</TH>");//TblCellule("$modifier");
		$mot = $string_lang['NOUVEAU'][$langue];print("<TH>$mot</TH>");
		$mot = $string_lang['SELECT_SERVICE'][$langue];print("<TH>$mot</TH>");//TblCellule("<div align=\"center\"> $mot");
		$mot = $string_lang['TYPE'][$langue];print("<TH>$mot</TH>");//TblCellule("<div align=\"center\"> $mot");
		$mot = $string_lang['LITS'][$langue];print("<TH>$mot</TH>");//TblCellule("<div align=\"center\"> $mot");
		$mot = $string_lang['LITS_FERME'][$langue];print("<TH>$mot</TH>");
		$mot = $string_lang['MAJ'][$langue];print("<TH>$mot</TH>");//TblCellule("<div align=\"center\"> $mot");
	TblFinLigne();

	if($_SESSION["auto_org"])
		$requete = "SELECT service.service_ID,service_nom,service_code, lits_sp,lits_ferme,date_maj,type_nom
				FROM service, lits,type_service
				WHERE service.org_ID = $_SESSION[organisation]
				AND service.Priorite_Alerte < 9
				AND service.service_ID = lits.service_ID
				AND service.Type_ID = type_service.Type_ID
				ORDER BY type_nom";
	elseif($_SESSION["auto_hopital"])
		$requete = "SELECT service.service_ID,service_nom,service_code, lits_sp,lits_ferme,date_maj,type_nom
				FROM service, lits,type_service
				WHERE service.Hop_ID = $_SESSION[Hop_ID]
				AND service.Priorite_Alerte < 9
				AND service.service_ID = lits.service_ID
				AND service.Type_ID = type_service.Type_ID
				ORDER BY type_nom
				";
	else
		$requete = "SELECT service.service_ID,service_nom,service_code, lits_sp,lits_ferme,date_maj,type_nom
				FROM service, lits,type_service
				WHERE service.service_ID = $_SESSION[service]
				AND service.Priorite_Alerte < 9
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = type_service.Type_ID
				ORDER BY type_nom
				";//service.org_ID = $_SESSION[organisation]
	

	$resultat = ExecRequete($requete,$connexion);
	//print($requete);
	$_style = "A5";
	$total = array();
	$aujourdhui = today();//date du jour à 0h
	while($i = LigneSuivante($resultat))
	{
		if($_style=="A5")$_style="A6";
		else $_style="A5";
		TblDebutLigne("$_style");
		$identifiant = $i->service_ID;
		$mot = $string_lang["VOIR"][$langue];
		TblCellule("<a href=\"lits_fermes_voir.php?_service=$identifiant&nom=$i->service_nom\" TARGET=\"midle\">$mot</a>");
		$mot = $string_lang["NOUVEAU"][$langue];
		TblCellule("<a href=\"lits_fermes_nouveau.php?_service=$identifiant&nom=$i->service_nom\" TARGET=\"midle\">$mot</a>");
		TblCellule("$i->service_nom");
		$mot = $string_lang["$i->type_nom"][$langue];
		TblCellule($mot);
		TblCellule("<div align=\"right\"> $i->lits_sp");
		$lf = lits_fermés($aujourdhui, $i->service_ID);
		if($lf[0]!='') // si des lits sont fermés durant cette période
		{
			$lits_fermes = $lf[0];
			$maj = date("j/m/Y H:i",$lf[1]);
		}
		else
		{
			$lits_fermes = 0;
			if($i->date_maj < 1)
				$maj = "indéterminé";
			else
				$maj = date("j/m/Y H:i",$i->date_maj);
		}
		TblCellule("<div align=\"right\"> $lits_fermes");
		TblCellule("<div align=\"right\"> $maj");
		$total[$i->type_nom] = $total[$i->type_nom] + $i->lits_dispo;
	}
TblFin();
print("</FORM>");
print("</BODY>");
print("</html>");
?>
