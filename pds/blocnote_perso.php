<?php
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
/**													
*	programme 			blocnote_perso.php
*	@date de création: 	05/11/2006
*	@author:			jcb
*	description:		Nouveau message dans le bloc note perso
*	@version:			1.0 - $ $
*	maj le:				05/11/2006
*	@package			Sagec
*/													
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require("../html.php");

print("<HTML><HEAD><TITLE>Liste des messages</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

// connexion à la base de données
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
$query = "SELECT nom, prenom FROM utilisateurs WHERE ID_utilisateur = '$_SESSION[member_id]'";
$result = ExecRequete($query,$connect);
$utilisateur = LigneSuivante($result);

// Il s'agit d'un utilisateur répertorié
if($utilisateur)
{

	print("<FORM name =\"blocnote\" METHOD=\"GET\" ACTION=\"blocnote_perso_enregistre.php\">");

	setlocale(LC_TIME,"french");
	$dateFR = strFTime("%A %d %B %Y");

	TblDebut(0,"100%");
	TblDebutLigne("A1");
		$mot = "Saisir un nouveau message";
		TblCellule("<A HREF=\"pds_doc#3.php\">$mot</A>");
		TblCellule("<A HREF=\"blocnote_perso_lire.php\">Annuler</A>");
	TblFinLigne();
	TblFin();

	//echo PHP_OS;

	TblDebut(0,"100%");
	TblDebutLigne();
		TblCellule($string_lang['AUTEUR'][$langue].":");
		TblCellule($utilisateur->prenom." ".$utilisateur->nom);
	TblFinLigne();
	TblDebutLigne();
		TblCellule($string_lang['DATE'][$langue].":");
		TblCellule(" ".$dateFR." à ".date("H:i"));
		$timestamp = date("Y-m-j H:i:s");// format compatible mysql
		TblCellule($timestamp);
	TblFinLigne();
	TblDebutLigne();
		TblCellule($string_lang['MESSAGE'][$langue].":");
		$mot=$string_lang['VALIDER'][$langue];
		TblCellule("<TEXTAREA COLS=\"60\" ROWS=\"5\" NAME=\"montexte\"></TEXTAREA> ");
	TblFinLigne();
	TblDebutLigne();
		TblCellule(" ");
		$mot=$string_lang['VALIDER'][$langue];
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"VALIDER\" ");
	TblFinLigne();
	TblFin();
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"date\" VALUE=\"$timestamp\">");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"auteur\" VALUE=\"$_SESSION[member_id]\">");
print("</FORM>");
print("</HEAD></HTML>");
}

?>
