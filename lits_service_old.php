<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
//---------------------------------------------------------------------------------------------------------
//																										 //
//	programme: 			Lits_Service.php																	 //
//	date de création: 	15/08/03																		 //
//	auteur:				jcb																				 //
//	description:		Affiche la liste des services d'un hôpital donné									 //
//	version:			1.1																				 //
//	maj le:				15/08/03																		 //
//	appelé par:			
// 	Variables transmises																								 //
//---------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require "utilitairesHTML.php";
require("pma_connect.php");
require("pma_connexion.php");
require ("menu_sagec.php");
require 'utilitaires/globals_string_lang.php';

// en tête
print("<html>");
print("<head>");
print("<title> Gestion des Lits d'un Hôpital </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");

print("</head>");
print("<FORM name =\"Lits\"  ACTION=\"lits_service.php\">");
print("<input type=\"hidden\" name=\"dpt[]\">");
$dpt=array("57","68");
// Affichage de l'entête
MenuLits($langue);
// choix de l'hôpital
$mot = $string_lang['LISTE_SERVICE_HOPITAL'][$langue];
print("<H3>$mot</H3><A HREF=\"javascript:ouvrir_depart();\"> (limité à)</A>");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
TblDebut(0,"100%");
	TblDebutLigne();
		$mot = $string_lang['SELECT_HOPITAL'][$langue];
		TblCellule("$mot");
			print("<TD>");
				select_hopital2($connexion,$_GET['ID_hopital'],$langue);// retourne ID_hopital
			print("</TD>");
		$mot = $string_lang['SELECT_SERVICE'][$langue];
		TblCellule("$mot");
			print("<TD>");
			SelectTypeService($connexion,$_GET['type_s'],$langue);
			print("</TD>");
		$mot = $string_lang['VALIDER'][$langue];
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\" ");
	TblFinLigne();
TblFin();
// affichage de la liste: fonction dans Utilitaires HTML
//print("hopital".$ID_hopital."<BR>");
$back = "lits_service.php";
//print("departements: ".$dpt."<BR>");
Table_Lits2($connexion,$_GET[ID_hopital],$_GET['type_s'],$langue,$back,$dpt);
print("</FORM>");
?>
