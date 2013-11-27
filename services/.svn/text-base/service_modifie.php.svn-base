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
//	programme: 		service_modifie.php							//
//	date de création: 	15/04/2004								//
//	auteur:			jcb									//
//	description:		modifie le nombre des lits disponibles		//
//	version:		1.1									//
//	maj le:			03/09/2005								//
//													//
//--------------------------------------------------------------------------------------------------------
// Variable transmise $_GET[service] = service_ID
//--------------------------------------------------------------------------------------------------------
session_start();
if(!($_SESSION['auto_hopital']||$_SESSION['auto_service']||$_SESSION['auto_organisme']))header("Location:../logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require '../utilitaires/globals_string_lang.php';
require "../utilitairesHTML.php";

print("<html>");
print("<head>");
print("<title> maj service </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("<LINK REL = \"stylesheet\" TYPE = \"text/css\" HREF = \"service.css\">");
include("service_help.js");
print("</head>");

print("<BODY>");
print("<FORM name =\"taches\"  ACTION=\"service_memorise.php\" METHOD=\"post\">");

//variables cachées
print("<INPUT TYPE=\"HIDDEN\" name=\"service_ID\" VALUE=\"$_GET[service]\">");
print("<INPUT TYPE=\"HIDDEN\" name=\"service_type\" VALUE=\"$_GET[type]\">");
print("<INPUT TYPE=\"HIDDEN\" name=\"back\" VALUE=\"service_modifie.php\">");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$requete =	"SELECT service.service_ID,service_nom,Type_ID, lits_dispo,date_maj,lits_liberable,lits_supp,lits_sp,lits_respi,lits_pneg,lits_ferme,lits_reserve,lits_installe,lit_spe1,lit_spe2,lit_spe3,lit_spe4,lit_spe5,lit_spe6,lit_spe7,places_auto,places_dispo
		FROM service, lits
		WHERE service.service_ID = '$_GET[service]'
		AND service.service_ID = lits.service_ID
		";
$resultat = ExecRequete($requete,$connexion);
//print($requete);
$i = LigneSuivante($resultat);

//print("<HR>");
print("<TABLE WIDTH=\"100%\" class=\"\">");
print("<TR>");
	$mot = $string_lang["SERVICE"][$langue];
	print("<TD>$mot</TD>");
	print("<TD><H3>".$i->service_nom."</H3></TD>");
	print("<TD><input type=\"button\" value=\"Aide?\" onClick=helpOuPas()></TD>");
	$mot = $string_lang["INFORMATION_SERVICE"][$langue];
	//print("<TD>$mot</TD>");
	print("<TD>");
		//$mot = $string_lang["VOIR"][$langue];
		print("<A HREF=\"service_info.php?service=$_GET[service]\">$mot</A>");
	print("</TD>");
	if($i->Type_ID==1) // si c'est un SAU
	{
		print("<TD><A HREF=\"epidemio/passages_sau.php?service=$_GET[service]\">Veille sanitaire</A></TD>");
	}
print("</TR>");
print("</TABLE>");
//print("<HR>");
print("<BR>");

print("<TABLE WIDTH=\"100%\" >");//BGCOLOR=\"RED\"
print("<TR>");
print("<TD WIDTH=\"40%\">");

print("<TABLE WIDTH=\"100%\" >");//BGCOLOR=\"RED\"
//---------------------------------- lits disponibles ----------------------------------------------
print("<TR BGCOLOR=\"yellow\">");
	$mot = $string_lang["LITS_DISPO"][$langue];
	print("<TD>$mot</TD>");
	print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lits_dispo\" VALUE=\"$i->lits_dispo\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet1')></TD>");
	if($_GET['type']==10)// brûlés
	{
		print("<TD>".$string_lang["LITS_REA"][$langue]."</TD>");
		print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lit_spe1\" VALUE=\"$i->lit_spe1\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet1')></TD>");
	}
print("</TR>");
//---------------------------------- lits libérables ----------------------------------------------
print("<TR>");
$mot = $string_lang["LITS_LIB"][$langue];
print("<TD>$mot</TD>");
	print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lits_liberable\" VALUE=\"$i->lits_liberable\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet2')></TD>");
	if($_GET['type']==10)// brûlés
	{
		print("<TD>".$string_lang["LITS_ADULTES"][$langue]."</TD>");
		print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lit_spe2\" VALUE=\"$i->lit_spe2\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet1')></TD>");
	}
print("</TR>");
//---------------------------------- lits supplémentaires ----------------------------------------------
print("<TR>");
$mot = $string_lang["LITS_SUP"][$langue];
print("<TD>$mot</TD>");
	print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lits_supp\" VALUE=\"$i->lits_supp\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet3')></TD>");
	if($_GET['type']==10)// brûlés
	{
		print("<TD>".$string_lang["LITS_ENFANTS"][$langue]."</TD>");
		print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lit_spe3\" VALUE=\"$i->lit_spe3\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet1')></TD>");
	}
print("</TR>");
//---------------------------------- lits autorisés ----------------------------------------------
print("<TR>");
$mot = $string_lang["LITS_AUTO"][$langue];
print("<TD>$mot</TD>");
	print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lits_sp\" VALUE=\"$i->lits_sp\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet4')></TD>");
print("</TR>");
//---------------------------------- lits installés ----------------------------------------------
print("<TR>");
$mot = $string_lang["LITS_INSTALLE"][$langue];
print("<TD>$mot</TD>");
	print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lits_installe\" VALUE=\"$i->lits_installe\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet5')></TD>");
//---------------------------------- lits fermés ----------------------------------------------
print("<TR>");
$mot = $string_lang["LITS_FERME"][$langue];
print("<TD>$mot</TD>");
	print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lits_ferme\" VALUE=\"$i->lits_ferme\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet6')></TD>");
	//---------------------------------- lits réservés ----------------------------------------------
print("<TR>");
$mot = $string_lang["LITS_RESERVE"][$langue];
print("<TD>$mot</TD>");
	print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lits_reserve\" VALUE=\"$i->lits_reserve\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet7')></TD>");

print("</TR>");
print("</TABLE>");
print("</TD>");

if($_GET['type']==10)// brûlés
{
print("<TD>");
print("<fieldset>");
print("<legend> ".$string_lang["DISPO_ACTUEL"][$langue]." </legend>");
print("<TABLE>");
print("<TR>");
	print("<TD>".$string_lang["ADULTE_N_VENTILE"][$langue]."</TD>");
	print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lit_spe4\" VALUE=\"$i->lit_spe4\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet1')></TD>");
print("</TR>");
print("<TR>");
	print("<TD>".$string_lang["ADULTE_VENTILE"][$langue]."</TD>");
	print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lit_spe5\" VALUE=\"$i->lit_spe5\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet1')></TD>");
print("</TR>");
print("<TR>");
	print("<TD>".$string_lang["ENFANT_N_VENTILE"][$langue]."</TD>");
	print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lit_spe6\" VALUE=\"$i->lit_spe6\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet1')></TD>");
print("</TR>");
print("<TR>");
	print("<TD>".$string_lang["ENFANT_VENTILE"][$langue]."</TD>");
	print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lit_spe7\" VALUE=\"$i->lit_spe7\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet1')></TD>");
print("</TR>");
print("</TABLE>");
print("</fieldset>");
print("</TD>");
}
else
{
	print("<TD>");
	//---------------------------------- places disponibles ----------------------------------------------
	print("<TABLE WIDTH=\"80%\" >");
	print("<TR>");
		print("<TD>Places disponibles</td>");
		print("<TD><INPUT TYPE=\"TEXT\" NAME=\"places_dispo\" VALUE=\"$i->places_dispo\" SIZE=\"3\" div align=\"right\"</TD>");
	print("</tr>");
	print("<TR>");
		print("<TD>Places autorisées</td>");
		print("<TD><INPUT TYPE=\"TEXT\" NAME=\"places_auto\" VALUE=\"$i->places_auto\" SIZE=\"3\" div align=\"right\"</TD>");
	print("</tr>");
	print("</TABLE>");
	//---------------------------------- places disponibles ----------------------------------------------
	print("</TD>");
}

print("</TR>");
print("</TABLE>");

print("<BR>");
$mot = $string_lang["POUR_SERVICE"][$langue];
print($mot."<BR>");
print("<TABLE WIDTH=\"40%\" BGCOLOR=\"Wheat\">");
//---------------------------------- Respirateurs ----------------------------------------------
print("<TR BGCOLOR=\"yellow\">");
	$mot = $string_lang["RESPI_DISPO"][$langue];
	print("<TD>$mot</TD>");
	print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lits_respi\" VALUE=\"$i->lits_respi\" SIZE=\"3\" div align=\"right\"onMouseOver=help('sujet8')></TD>");
print("</TR>");
//---------------------------------- lits en isolement ----------------------------------------------
print("<TR>");
	$mot = $string_lang["LITS_ISOLEMENT"][$langue];
print("<TD>$mot</TD>");
	print("<TD><INPUT TYPE=\"TEXT\" NAME=\"lits_pneg\" VALUE=\"$i->lits_pneg\" SIZE=\"3\" div align=\"right\" onMouseOver=help('sujet9')></TD>");
print("</TR>");
print("</TABLE>");
print("<BR>");
//---------------------------------- Validation ----------------------------------------------
print("<TABLE WIDTH=\"100%\" BGCOLOR=\"gold\">");
print("<TR>");
	$mot = $string_lang["MODIF"][$langue];
	print("<TD><blink>$mot</blink></TD>");
	$mot = $string_lang["VALIDER"][$langue];
	print("<TD><INPUT TYPE=\"SUBMIT\" NAME=\"ok_lits\" VALUE=\"$mot\" div align=\"center\"></TD>");
print("</TR>");
print("</TABLE>");

print("</FORM>");
print("</BODY>");
print("</html>");
?>
