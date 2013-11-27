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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		organisme_maj
//	date de création: 	8/10/2003
//	auteur:			jcb
//	description:
//	version:			1.1
//	maj le:			8/10/2003
//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backpath="../";
include_once("top.php");
include_once("menu.php");

include_once($backpath."utilitaires/table.php");
require_once $backpath.'utilitaires/globals_string_lang.php';
require_once($backpath."utilitairesHTML.php");
require_once($backpath."pma_connect.php");
require_once($backpath."pma_connexion.php");
include_once($backPath."login/init_security.php");

// en tête
print("<html>");
print("<head>");
print("<title> Gestion des organismes </title>");
print("<link rel=\"shortcut icon\" href=\"../images/sagec67.ico\" />");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("<link rel=\"stylesheet\" href=\"div.css\" type=\"text/css\" media=\"all\" />");
print("</head>");
// Corps
print("<FORM name =\"Organismes\"  ACTION=\"organisme_saisie.php\" method=\"post\">");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

// adresse de retour mémorisée dans un champ caché
print("<INPUT TYPE=\"HIDDEN\" NAME=\"back\" VALUE=\"organisme_maj.php\">");

?><div id="div2"><?php
//MenuVecteurs($langue);
$mot = $string_lang['AJOUTER_MODIF_ORGANISME'][$langue];
Print("<H2>$mot</H2>");
TblDebut(0,"50%");
	TblDebutLigne();
		$mot = $string_lang['SELECTIONNER_ORGANISME'][$langue];
		TblCellule($mot);
		print("<TD>");
			SelectOrganisme($connexion,"0",$langue);//$orgID contient le type_ID
		print("</TD>");
		$mot = $string_lang['VALIDER'][$langue];
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\" ");
	TblFinLigne();
TblFin();
?></div><?php

print("</FORM>");
print("</html>");
?>
