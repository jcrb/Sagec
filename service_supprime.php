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
//
//	programme: 		service_supprime.php
//	date de création: 	08/11/2004
//	auteur:			jcb
//	description:
//	version:			1.1
//	maj le:			13/10/2005 // Ajout de la table contact dans les suppressions
//
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

print("<FORM name =\"Services\"  method=\"get\" ACTION=\"service_supprime.php\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
menu_maj_des_lits($langue);
//$mot = $string_lang['AJOUTER_SERVICE'][$langue];
$mot = "Supprimer un service";
Print("<H2>$mot</H2>");
//------------------------ supprime un service et les lits associés ----------------------------------
if($_GET['ttservice'])
{
	$requete="DELETE FROM contact WHERE nature_contact_ID = 4 AND identifiant_contact = '$_GET[ttservice]'";
	$requete="DELETE FROM lits WHERE service_ID = '$_GET[ttservice]'";
	$resultat = ExecRequete($requete,$connexion);
	$requete="DELETE FROM service WHERE service_ID = '$_GET[ttservice]'";
	$resultat = ExecRequete($requete,$connexion);
	$_GET['service_ID']="";
}
//-----------------------------------------------------------------------------------------------------
TblDebut(0,"50%");
	TblDebutLigne();
		$mot = $string_lang['SELECTIONNER_SERVICE'][$langue];
		TblCellule($mot);
		print("<TD>");
			SelectTousService($connexion,"0");//ttservice
		print("</TD>");
		$mot = $string_lang['SUPPRIMER'][$langue];
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\">");
	TblFinLigne();
TblFin();
print("</FORM>");

print("</html>");
?>
