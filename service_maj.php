<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
//----------------------------------------- SAGEC ---------------------------------------------//
//																							   //
//	programme: 			Service_maj.php													   //
//	date de création: 	18/08/2003															   //
//	auteur:				jcb																	   //
//	description:				 								   //
//	version:			1.0																	   //
//	maj le:				18/08/2003															   //
//																							   //
//---------------------------------------------------------------------------------------------//
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
//$id_hop = $_GET['ID_hopital'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include("utilitaires/table.php");
require 'utilitaires/globals_string_lang.php';
include("utilitairesHTML.php");
require("pma_connect.php");
require("pma_connexion.php");
require ("menu_gestion_lits.php");
// en tête
print("<html>");
print("<head>");
print("<title> Gestion des Lits </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM name =\"Services\"  ACTION=\"services.php\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

//menu_maj_des_lits($langue);
menu_lits_maj($langue, $string_lang['SERVICE_CREATION'][$langue]);

$mot = $string_lang['AJOUTER_SERVICE'][$langue];
Print("<H2>$mot</H2>");
TblDebut(0,"50%");
	TblDebutLigne();
		$mot = $string_lang['SELECTIONNER_SERVICE'][$langue];
		TblCellule($mot);
		print("<TD>");
			SelectTousService($connexion,"0",$langue);
		print("</TD>");
		$mot = $string_lang['VALIDER'][$langue];
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\">");
		if($_SESSION['autorisation']>9)
		{
			$mot = $string_lang['SUPPRIMER'][$langue];
			TblCellule("<A href=\"service_supprime.php\">$mot</A>");
		}
	TblFinLigne();
TblFin();
print("</FORM>");

print("</html>");
?>
