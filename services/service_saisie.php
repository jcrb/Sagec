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
//	programme: 		service_saisie.php							//
//	date de création: 	15/04/2004								//
//	auteur:			jcb									//
//	description:		modifie et enregistre les Informations générales sur le service		//
//	version:		1.1									//
//	maj le:			03/06/2005								//
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
require '../utilitaires/globals_string_lang.php';
require "../utilitairesHTML.php";

print("<html>");
print("<head>");
print("<title> maj service </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY>");
print("<FORM name =\"taches\"  ACTION=\"service_memorise.php\" METHOD=\"post\">");

//variables caxhées
print("<INPUT TYPE=\"HIDDEN\" name=\"service_ID\" VALUE=\"$_POST[service]\">");
print("<INPUT TYPE=\"HIDDEN\" name=\"back\" VALUE=\"service_modifie.php\">");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$requete =	"SELECT service.service_ID,service_nom,service_code,service_tel,service_fax,service_etage,
service_batiment,lits_sp,service_adulte, service_enfant,age_min
		FROM service, lits
		WHERE service.service_ID = '$_POST[service]'
		AND service.service_ID = lits.service_ID
		";
$resultat = ExecRequete($requete,$connexion);
//print($requete);
$i = LigneSuivante($resultat);

print("<TABLE WIDTH=\"100%\" BGCOLOR=\"wheat\">");
//---------------------------------- lits disponibles ----------------------------------------------
print("<TR BGCOLOR=\"yellow\">");
	print("<TD>".$string_lang['SERVICE_NOM'][$langue]."</TD>");
	print("<TD div align=\"right\">$i->service_nom - $i->service_ID </TD>");
print("</TR>");
print("<TR>");
	print("<TD>".$string_lang['CODE_SERVICE'][$langue]."</TD>");
	print("<TD div align=\"right\"><INPUT TYPE=\"TEXT\" NAME=\"code\" VALUE=\"$i->service_code\" div align=\"right\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>".$string_lang['TEL'][$langue]."</TD>");
	print("<TD div align=\"right\"><INPUT TYPE=\"TEXT\" NAME=\"tel\" VALUE=\"$i->service_tel\" div align=\"right\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>".$string_lang['FAX'][$langue]."</TD>");
	print("<TD div align=\"right\"><INPUT TYPE=\"TEXT\" NAME=\"dax\" VALUE=\"$i->service_fax\" div align=\"right\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>".$string_lang['BATIMENT'][$langue]."</TD>");
	print("<TD div align=\"right\"><INPUT TYPE=\"TEXT\" NAME=\"batiment\" VALUE=\"$i->service_batiment\" div align=\"right\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>".$string_lang['ETAGE'][$langue]."</TD>");
	print("<TD div align=\"right\"><INPUT TYPE=\"TEXT\" NAME=\"etage\" VALUE=\"$i->service_etage\" div align=\"right\"></TD>");
print("</TR>");

print("<TR>");
	print("<TD>".$string_lang['PATIENT_ACCEPTE'][$langue]."</TD>");
	if($i->service_adulte=='o')$c = 'checked'; else $c='';
	print("<TD><input type=\"checkbox\" name=\"adulte\" value=\"o\" $c> ".$string_lang['ADULTE'][$langue]."</TD>");
print("</TR>");
print("<TR>");
	print("<TD>&nbsp;</TD>");
	if($i->service_enfant=='o')$c = 'checked'; else $c='';
	$mot=$string_lang['ENFANT_ACCEPTE'][$langue].", ".$string_lang['A_PARTIR'][$langue]." "; 
	print("<TD>");
	print("<input type=\"checkbox\" name=\"enfant\" value=\"o\" $c> $mot");
	print(" <INPUT TYPE=\"TEXT\" NAME=\"age_enfant\" VALUE=\"$i->age_min\"> ".$string_lang['ANS'][$langue]."</TD>");
print("</TR>");

print("<TR BGCOLOR=\"yellow\">");
	$mot = $string_lang['VALIDER'][$langue];
	print("<TD>".$mot." ?</TD>");
	print("<TD div align=\"right\"><INPUT TYPE=\"SUBMIT\" NAME=\"ok_service\" VALUE=\"$mot\" div align=\"center\"></TD>");
print("</TR>");

?>
