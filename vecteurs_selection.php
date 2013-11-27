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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 			vecteur_selection.php
//	date de création: 	18/08/2003
//	auteur:				jcb
//	description:		$v_type = type de vecteur (VLM = 1...)	
//					$type_v = état du vecteur (disponible...)
//	version:			1.0
//	maj le:			06/09/2003
//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION[langue];

require("vecteurs_menu.php");
include("utilitairesHTML.php");
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
require 'utilitaires/globals_string_lang.php';

print("<HTML><HEAD><TITLE>Liste des vecteurs</TITLE>");
print("<meta http-equiv=\"refresh\" content=\"30\">");// rafraichissement toutes les 30 s
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\"></HEAD>");

print("<FORM name =\"Lits\"  ACTION=\"vecteurs_selection.php\" METHOD=\"get\">");
MenuVecteurs($langue);
$mot = $string_lang['SELECTIONNER_VECTEUR'][$langue];
Print("<H3>$mot</H3>");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

TblDebut(0,"100%");
	TblDebutLigne();
		$mot = $string_lang['TYPE_DE_MOYEN'][$langue];
		TblCellule("$mot");
			print("<TD>");
				SelectTypeVecteur($connexion,$_GET['v_type'],$_SESSION[langue]);
			print("</TD>");
		$mot = $string_lang['ETAT_MOYEN'][$langue];
		TblCellule("$mot");
			print("<TD>");
			SelectEtatVecteur($connexion,$_GET['type_v'],$langue);
			print("</TD>");
		$mot = $string_lang['ENGAGE'][$langue];
		if($_GET['engage']=="1")$check="CHECKED";
		TblCellule("$mot<INPUT TYPE=\"CHECKBOX\" NAME=\"engage\" VALUE=\"1\" $check>");
			
		$mot = $string_lang['VALIDER'][$langue];	
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\" ");
	TblFinLigne();
TblFin();

Table_Vecteurs($connexion,$_GET['v_type'],$_GET['type_v'],$_GET['engage'],$_SESSION[langue]);

print("</html>");

?>
