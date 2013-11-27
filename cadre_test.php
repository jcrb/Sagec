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
//
//	programme: 		cadre_test
//	date de création: 	20/12/2006
//	auteur:			jcb
//	description:		Affiche la liste des services d'un hôpital donné
//	version:			1.0
//	maj le:			20/12/2006
//--------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
require "utilitairesHTML.php";
require 'utilitaires/globals_string_lang.php';
require ("menu_gestion_lits.php");
require ("services_utilitaires.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
print("<title> menu service </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY>");
print("<FORM name=\"menu\" method=\"get\" action=\"cadre_test.php\">");
$titre = $string_lang['GESTION_LITS'][$langue];
menu_lits_simple($langue,$titre);
$mot = $string_lang['LISTE_SERVICE_HOPITAL'][$langue];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
TblDebut(0,"100%",2,4,"time");
	TblDebutLigne();
		$mot = $string_lang['SELECT_HOPITAL'][$langue];
		TblCellule("$mot");
		print("<TD>");
			select_hopital_org($connexion,$_GET['ID_hopital'],$_SESSION['organisation'],$langue);// retourne ID_hopital. 0 = tous les sites
		print("</TD>");
		$mot = $string_lang['SELECT_SERVICE'][$langue];
		TblCellule("$mot");
		print("<TD>");
			SelectTypeService($connexion,$_GET['type_s'],$langue);
		print("</TD>");
		print("<td>total: ".$total_lits_dispo."</td>");
		print("<TD>");
			$mot = $string_lang['VALIDER'][$langue];
			TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\" ");
	TblFinLigne();
TblFin();

$back = "cadre_test.php";

if($_GET['ID_hopital'] != 0)
	Table_Lits3($connexion,$_GET['ID_hopital'],$_GET['type_s'],$langue,$back,$_GET['dpt'],$tri,'true');
else
	Table_Lits4($connexion,$_SESSION['organisation'],$_GET['type_s'],$langue,$back,$tri);

print("</FORM>");
print("</BODY>");
print("</html>");
?>