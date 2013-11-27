<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------
//
//	programme: 		brule_liste.php
//	date de création: 	20/11/2005
//	auteur:			jcb
//	description:		Fonctionalit? permise ? l'administrateur
//	version:			1.0
//	maj le:			20/11/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require "../utilitairesHTML.php";
require '../utilitaires/globals_string_lang.php';
require ("../services_utilitaires.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$langue = $_SESSION['langue'];

function Table_Lits_brules($connexion,$hopID="0",$type_service="0",$langue,$back="",$dpt="",$tri="")
{
	require '../utilitaires/globals_string_lang.php';
	MAJ_Lits_cata($connexion);
	// création et exécution de la requete
	$requete = select_services($connexion,$hopID,$type_service,$dpt,$tri);
	//print($requete."<BR>");
	$resultat = ExecRequete($requete,$connexion);
	// affichage du résultat
	TblDebut(0,"100%");
	$_style = "A2";
	$retour=$back."?tri";
	TblDebutLigne("$_style");
	$mot = $string_lang['VOIR'][$langue];TblCellule("<div align=\"left\" class=\"Style24\"> $mot");
	//TblCellule("<B>ID</B>");
	$mot = $string_lang['HOPITAL'][$langue];TblCellule("<div align=\"left\" class=\"Style24\"><a href=\"$retour=hopital\">$mot</a>");
	$mot = $string_lang['SERVICE'][$langue];TblCellule("<div align=\"left\" class=\"Style24\"><a href=\"$retour=service\">$mot</a>");
	$mot = $string_lang['TYPE'][$langue];TblCellule("<div align=\"left\" class=\"Style24\"><a href=\"$retour=type\">$mot</a>");
	$mot = $string_lang['TOTAL_LITS'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['LITS_OCC'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['LITS_LIB'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['LITS_SUP'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['LITS_DISPO'][$langue];TblCellule("<div align=\"left\" class=\"Style24\"><a href=\"$retour=ldispo\">$mot</a>");
	$mot = $string_lang['VICTIMES_CATA'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['MAJ'][$langue];TblCellule("<div align=\"left\" class=\"Style24\"><a href=\"$retour=maj\">$mot</a>");
	TblFinLigne();

	$_style = "A5";
	$modifier = $string_lang['VOIR'][$langue];
	while($i = LigneSuivante($resultat))
	{
		if($_style=="A5")$_style="A6";
		else $_style="A5";
		TblDebutLigne("$_style");
		// MODFIER: on appelle Tri2 avec comme paramètre le n° d'ordre contenu
		// dans la variable 'identifiant' qui est attendue par Tri2
		$identifiant = $i->service_ID;
		// on transmet l'identifiant de l'hôpital et/ou du type de service
TblCellule("<a href=\"brule_service.php?service_ID=$identifiant&back=$back\" class=\"time\">$modifier</a>");
		// Affichage des données de la ligne
	//TblCellule("$i->lits_ID");
	//TblCellule("<div align=\"left\" class=\"Style23\"> $identifiant");
	TblCellule("<div align=\"left\" class=\"Style23\"> $i->Hop_nom");
	TblCellule("<div align=\"left\" class=\"Style23\"> $i->service_nom");

	$type = ChercheTypeService($i->Type_ID,$connexion);
	//$mot = $string_lang[$type->type_nom][$langue];
	$mot = $string_lang[$type][$langue];
	//------------------------------ adulte ou enfant ? -------------------
	if($i->service_adulte) $mot .= " ".$string_lang['ADULTE'][$langue];
	if($i->service_enfant) $mot .= " ".$string_lang['ENFANT'][$langue];
	if($i->age_min) $mot .= ">".$i->age_min.$string_lang['ANS'][$langue];
	TblCellule("<div align=\"left\" class=\"Style22\"> $mot");
	//---------------------------------------------------------------------
	TblCellule("<div align=\"right\" class=\"time\"> $i->lits_sp");
	TblCellule("<div align=\"right\" class=\"Style23\"> $i->lits_occ");
	TblCellule("<div align=\"center\" class=\"Style23\"> $i->lits_liberable");
	TblCellule("<div align=\"center\" class=\"Style23\"> $i->lits_supp");
	//$lits_dispo = $i->lits_sp + $i->lits_supp - $i->lits_occ - $i->lits_cata;
	TblCellule("<div align=\"center\" class=\"time_v\"><B> $i->lits_dispo</B>");
	TblCellule("<div align=\"center\" class=\"Style23\"> $i->lits_cata");
	if($i->date_maj < 1)
		TblCellule(" ");
	else
	{
		$t = date("j/m/Y H:i",$i->date_maj);
		TblCellule("<div align=\"center\" class=\"Style22\">$t");
	}
	TblFinLigne();
	}
	TblFin();
}

print("<HTML>");
print("<head>");
print("<title>menu assu</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY>");
print("<FORM name=\"menu\" method=\"get\" action=\"#\">");
// Affichage de l'entête
//MenuLits($langue);
$titre = $string_lang['GESTION_LITS'][$langue];

//------------------ Liste des pays ----------------------------------------------------------------------
$type_s=10; // brûlés

	print("<fieldset class=\"Style22\">");
	print("<legend>Choisir les pays actifs</legend>");
	TblDebut(0,"100%");
	print("<table width = \"100%\" bgcolor=\"#cccccc\">");
	TblDebutLigne();
	$requete="SELECT * FROM pays ORDER BY pays_nom";
	$resultat = ExecRequete($requete,$connexion);
	$n=0;
	while($rub = mysql_fetch_array($resultat))
	{
		$mot = $string_lang[$rub['pays_nom']][$langue];
		if(!$mot)$mot=$rub['pays_nom'];
		if(count($_GET['dpt']) && in_array($rub[pays_ID],$_GET['dpt']))
		print("<TD class=\"Style22\"><input type =\"checkbox\" Checked name=\"dpt[]\" value=\"$rub[pays_ID]\" >$mot</TD>");
		else
			print("<TD class=\"Style22\"><input type =\"checkbox\" name=\"dpt[]\"value=\"$rub[pays_ID]\"><class=\"time\">$mot</TD>");
		$n++;
		if($n>6){
			$n=0;
			print("</tr><tr>");
		}
	}
	print("<td><input type=\"submit\" name=\"ok\" value=\"valider\"></td>");
	TblFinLigne();
	TblFin();
	print("</fieldset>");
print("</TD>");
TblFinLigne();
TblFin();
print("</fieldset>");
//----------------------------------------------------------------------------------------------------------
$back = "brule_liste.php";
$tri=$_GET['tri'];
Table_Lits_brules($connexion,$_GET['ID_hopital'],$type_s,$langue,$back,$_GET['dpt'],$tri);

print("</FORM>");
print("</BODY>");
print("</html>");
?>