<?php
session_start();
//----------------------------------------- SAGEC --------------------------------------------------------

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
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$backPathToRoot="";
include("utilitaires/table.php");
require 'utilitaires/globals_string_lang.php';
include("utilitairesHTML.php");
require("dbConnection.php");
require ("menu_gestion_lits.php");
include_once($backPathToRoot."login/init_security.php");

// en tête
print("<html>");
print("<head>");
print("<title> Gestion des Hôpitaux </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY onload=\"document.Hopitaux.ID_hopital.focus()\">");

print("<FORM name =\"Hopitaux\"  ACTION=\"hopital.php\" method=\"get\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

//menu_maj_des_lits($langue);
menu_lits_maj($langue, $string_lang['HOPITAUX_CREATION'][$langue]);

$mot = $string_lang['AJOUTER_HOPITAL'][$langue];
Print("<H3>$mot</H3>");
TblDebut(0,"50%");
	TblDebutLigne();
		$mot = $string_lang['SELECTIONNER_HOPITAL'][$langue];
		TblCellule($mot);
		print("<TD>");
			select_hopital($connexion,"0",$langue);//retourne "ID_hopital"
		print("</TD>");
		$mot = $string_lang['VALIDER'][$langue];
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\" ");
	TblFinLigne();
TblFin();
print("</FORM>");
print("<BODY>");
print("</html>");
?>
