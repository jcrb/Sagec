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
//													//
//	programme: 		service_bloc_note.php								//
//	date de cr�ation: 	18/08/2003								//
//	auteur:			jcb									//
//	description:		Enregistre une information rextuelle					//
//													//
//	version:		1.1									//
//	maj le:			09/04/2004								//
//													//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
include("../utilitaires/table.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."pma_connect.php");
require($backPathToRoot."pma_connexion.php");
require $backPathToRoot.'utilitaires/requete.php';
require($backPathToRoot."html.php");
$back = $_REQUEST['back'];
if(!$back) $back = "sagec67.php";

print("<HTML><HEAD><TITLE>Liste des messages</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

// connexion � la base de donn�es
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
$query = "SELECT nom, prenom FROM utilisateurs WHERE ID_utilisateur = '$_SESSION[member_id]'";
$result = ExecRequete($query,$connect);
$utilisateur = LigneSuivante($result);

// Il s'agit d'un utilisateur r�pertori�
if($utilisateur)
{
	print("<FORM name =\"Vecteurs\" METHOD=\"GET\" ACTION=\"service_BN_enregistre.php\">");
	setlocale(LC_TIME,"french");
	$dateFR = strFTime("%A %d %B %Y");
	$mot = $string_lang['BLOCNOTE'][$langue];
	//entete_sagec($mot);
	entete_sagec2($mot,"center","",$backPathToRoot);

	TblDebut(0,"100%");
	TblDebutLigne("A1");
	$mot = $string_lang['LIREBN'][$langue];
		TblCellule("<A HREF=\"service_BN_lire.php\">$mot</A>");
		if($_SESSION['autorisation']>9)
			TblCellule("<A HREF=\"blocnote_lire.php\">Sauvegarder</A>");
		TblCellule("<A HREF=\"$back\">".$string_lang['RETOUR'][$langue]."</A>");
	TblFinLigne();
	TblFin();

	TblDebut(0,"100%");
	TblDebutLigne();
		TblCellule($string_lang['AUTEUR'][$langue].":");
		TblCellule($utilisateur->prenom." ".$utilisateur->nom);
	TblFinLigne();
	TblDebutLigne();
		TblCellule($string_lang['DATE'][$langue].":");
		TblCellule(" ".$dateFR." � ".date("H:i"));
		$timestamp = date("Y-m-j H:i:s");// format compatible mysql
	TblFinLigne();

	TblDebutLigne();
		$copie = $string_lang['COPIE'][$langue]." SAMU 67";
		TblCellule($copie);
		print("<TD><input type=\"checkbox\" name=\"copie\" checked></TD");
	TblFinLigne();

	TblDebutLigne();
		TblCellule($string_lang['MESSAGE'][$langue].":");
		$mot=$string_lang['VALIDER'][$langue];
		TblCellule("<TEXTAREA COLS=\"60\" ROWS=\"10\" NAME=\"montexte\"></TEXTAREA> ");
	TblFinLigne();
	TblDebutLigne();
		TblCellule(" ");
		$mot=$string_lang['VALIDER'][$langue];
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"VALIDER\" ");
	TblFinLigne();
	TblFin();
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"date\" VALUE=\"$timestamp\">");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"auteur\" VALUE=\"$_SESSION[member_id]\">");

print("<div>");
print("<frameset>");
$french= "Toutes les personnes travaillant dans le m�me h�pital, peuvent partager ce bloc-note. Il permet notamment l'�change d'informations entre la direction et les services. Si la case 'SAMU' est coch�e, une copie du message appara�tra dans le bloc-note du SAMU.";
$english = "All the people working in the same hospital, can share this notebook. It allows in particular the exchange of information between the Directorate and the Wards. If box 'SAMU' is checked, a copy of the message will appear in the notebook of the SAMU.";
$german = "Alle Personen, die im selben Krankenhaus arbeiten, k�nnen diesen Block-Vermerk teilen. Er erlaubt insbesondere den Informationsaustausch zwischen der Direktion und den Diensten. Wenn der Kasten 'SAMU' angekreuzt wird, wird eine Kopie der Mitteilung im Block-Vermerk des SAMU erscheinen.";
print("<p class=\"Style25\">$french</p>");
print("<p class=\"Style25\">$german</p>");
print("<p class=\"Style25\">$english</p>");
print("</frameset>");
print("</div>");
print("</FORM>");
print("</HTML>");
}

?>
