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
//----------------------------------------- SAGEC ---------------------------------------------//
//
//	programme: 		synoptique_home.php
//	date de création: 	15/02/2005
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			15/02/2005
//
/**
 * Documents the class following
 * @package SomePackage
 */
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require '../utilitaires/globals_string_lang.php';
include("../utilitairesHTML.php");
require ("../services_utilitaires.php");

print("<head>");
print("<title>DASS </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$langue = $_SESSION['langue'];

$mot = $string_lang['LITS_DISPO'][$langue]." ".$string_lang['PAR'][$langue]." ".$string_lang['SPECIALITE'][$langue];
$mot2 = $string_lang['A'][$langue];
$legende =  DateHeure($langue);
$hopID = $_GET['ID_hopital'];
$type_service = $_GET['type_s'];
$dpt = $_GET['dpt'];
$tri = $_GET['tri'];

//------------------------------- en tête -----------------------------------------------------
print("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style24\">");
	print("<tr>");
	print("<TD> SAMU 67 - Centre 15 du Bas-Rhin</td>");
	$d = date("Y-m-d");
	print("<TD class=\"DROITE\"> $d </td>");
	print("</tr>");
	print("<tr>");
	print("<TD>".$string_lang['HUS'][$langue]."</td>");
	print("<TD class=\"DROITE\">$mot</td>");
	print("</tr>");
	print("<tr>");
	print("<TD>&nbsp;</td>");
	print("<TD class=\"DROITE\">".$string_lang['JOURNEE_DU'][$langue].$legende."</td>");
	print("</tr>");
	// si un département est sélectionné
	if(count($dpt) != 0 && !$_GET['ID_hopital']){
		print("<tr>");
			print("<TD>");
				if(count($dpt) == 1) print("Pour le département ");
				else print("Pour les départements ");
				for($i=0;$i<count($dpt)-1; $i++)
					print($dpt[$i].", ");
				print($dpt[$i]);
			print("</TD>");
		print("</tr>");
	}
//--------------------------------  HOME  ------------------------------------------
	
if($_GET[ok1])
{
	// fin de l'entête
	print("</table>");
	/*
	$requete="SELECT lits_dispo,lits.service_ID,service.Type_ID,service_nom
			FROM lits,service
			WHERE lits_dispo > 0
			AND lits.service_ID = service.service_ID
			ORDER BY service.Type_ID
			";*/
	$requete="SELECT lits_dispo,lits.service_ID,service.Type_ID,service_nom
			FROM lits,service
			WHERE lits.service_ID = service.service_ID
			ORDER BY service.Type_ID
			";
	$resultat = ExecRequete($requete,$connexion);
	$max = 0;
	while($g = LigneSuivante($resultat))
	{
		$i=$g->Type_ID;
		$moyen[$i]= $moyen[$i] + $g->lits_dispo;
		if($i>$max)$max = $i;
	}

	print("<table width=\"50%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
	print("<TR>");
		print("<TD>&nbsp;</TD>");
		print("<TD><B>".$string_lang['SERVICE'][$langue]."</B></TD>");
		print("<TD><B>".$string_lang['LITS_DISPO'][$langue]."</B></TD>");//Gesamtzahl der verfügbaren Betten
	print("</TR>");
	for($i=1;$i<=$max;$i++)
	{
		if($moyen[$i])
		{
			print("<TR>");
			$mot = $string_lang['VOIR'][$langue];
			print("<TD width=\"20\"><div align=\"center\"><a href=\"synoptique_home.php?ok=''&type_s=$i\">$mot</a></div> </TD>");
			$mot = $string_lang[ChercheTypeService($i,$connexion)][$langue];
			print("<TD>$mot</TD>");
			print("<TD><div align=\"right\">$moyen[$i]</div></TD>");
			print("</TR>");
		}
	}
	print("</table>");
}
else //--------------------------------- par hopital ou spécialité -------------------------------------------
{
	$requete = select_services($connexion,$hopID,$type_service,$dpt,$tri);
	//print($requete."<BR>");
	$resultat = ExecRequete($requete,$connexion);
	$total = 0;
	print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
	print("<TR>");
		TblCellule("<div align=\"center\" class=\"Style23\"><B>".$string_lang['HOPITAL'][$langue]."</B>");
		TblCellule("<div align=\"center\" class=\"Style23\"><B>".$string_lang['SERVICE'][$langue]."</B>");
		TblCellule("<div align=\"center\" class=\"Style23\"><B>n</B></B>");
		TblCellule("<div align=\"center\" class=\"Style23\"><B>".$string_lang['MAJ'][$langue]."</B>");
	print("</TR>");
	while($i = LigneSuivante($resultat))
	{
		print("<TR>");
		TblCellule("<div align=\"left\" class=\"Style23\"> $i->Hop_nom");
		TblCellule("<div align=\"left\" class=\"Style23\"> $i->service_nom");
		TblCellule("<div align=\"center\" class=\"time_v\"><B> $i->lits_dispo</B>");
		$total += $i->lits_dispo;
		$t = date("j/m/Y H:i",$i->date_maj);
		TblCellule("<div align=\"right\" class=\"Style22\">$t");
		print("</TR>");
	}
/*
	// si un hôpital est sélectionné
	if($_GET['ID_hopital'])
	{
		print("<tr>");
		//$requete="SELECT org_nom FROM organisme WHERE org_ID='$_GET[ID_hopital]'";
		$requete="SELECT Hop_nom FROM hopital WHERE Hop_ID='$_GET[ID_hopital]'";
		$resultat = ExecRequete($requete,$connexion);
		$nom = LigneSuivante($resultat);
		print("<TD>");
			print($string_lang['ETABLISSEMENT'][$langue].": ".$nom->Hop_nom);
		print("</TD>");
		print("</tr>");
	}
	// services
	print("<tr>");
		print("<TD>".$string_lang['SERVICE'][$langue].": ");
		if(!$_GET['type_s'])
			print("tous services");
		else{
			$requete=	"SELECT type_nom FROM type_service WHERE type_ID='$_GET[type_s]'";
			$resultat = ExecRequete($requete,$connexion);
			$nom = LigneSuivante($resultat);
			print($string_lang[$nom->type_nom][$langue]);
		}
	print("</TD>");
	print("</tr>");
print("</table>");// fin de l'entête

print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
	print("<TR>");
		TblCellule("<div align=\"center\" class=\"Style23\"><B>".$string_lang['HOPITAL'][$langue]."</B>");
		TblCellule("<div align=\"center\" class=\"Style23\"><B>".$string_lang['SERVICE'][$langue]."</B>");
		TblCellule("<div align=\"center\" class=\"Style23\"><B>n</B></B>");
		TblCellule("<div align=\"center\" class=\"Style23\"><B>".$string_lang['MAJ'][$langue]."</B>");
	print("</TR>");
$requete = lits2_creeRequete($connexion,$_GET['ID_hopital'],$_GET['type_s'],$_GET['dpt']);
print($requete);
$resultat = ExecRequete($requete,$connexion);
$total = 0;
while($i = LigneSuivante($resultat))
{
	print("<TR>");
	TblCellule("<div align=\"left\" class=\"Style23\"> $i->org_nom");
	TblCellule("<div align=\"left\" class=\"Style23\"> $i->service_nom");
	TblCellule("<div align=\"center\" class=\"time_v\"><B> $i->lits_dispo</B>");
	$total += $i->lits_dispo;
	$t = date("j/m/Y H:i",$i->date_maj);
	TblCellule("<div align=\"right\" class=\"Style22\">$t");
	print("</TR>");
}
*/

	print("</table>");
	print("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
		print("<TR>");
			TblCellule("<div align=\"left\" class=\"Style23\"><B>".$string_lang['TOTAL_LITS_DISPO'][$langue]."</B>");
			TblCellule("<div align=\"center\" class=\"time_v\"><B> $total</B>");
		print("</TR>");
	print("</table>");
}
?>
