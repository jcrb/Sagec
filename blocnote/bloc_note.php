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
//	programme: 		bloc_note.php								//
//	date de création: 	18/08/2003								//
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
include($backPathToRoot."utilitaires/table.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php'; 
require($backPathToRoot."dbConnection.php");
include($backPathToRoot."login/init_security.php");
//require 'utilitaires/requete.php';
//require($backPathToRoot."html.php");
require($backPathToRoot."date.php");
include_once("blocnote_menu2.php");

entete("Main courante - Nouveau message");

// connexion à la base de données
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
$query = "SELECT nom, prenom FROM utilisateurs WHERE ID_utilisateur = '$_SESSION[member_id]'";
$result = ExecRequete($query,$connect);
$utilisateur = LigneSuivante($result);

// Il s'agit d'un utilisateur répertorié
if($utilisateur)
{
	?>
	<HTML>
	<HEAD>
		<TITLE>Liste des messages</TITLE>
		<LINK REL="SHORTCUT ICON" HREF="../images/sagec67.ico">
		<LINK REL=stylesheet HREF="../pma.css" TYPE ="text/css">
		<script src="../tinymce/tiny_mce/tiny_mce.js" type="text/javascript"></script>
		<script src="../tinymce/textarea.js" type="text/javascript"></script>
	</HEAD>
	
	<FORM name ="blocnote" METHOD="post" ACTION="blocnote_enregistre.php">
	<?php
	
	//setlocale(LC_TIME,"french");
	//$dateFR = strFTime("%A %d %B %Y");
	$mot = $string_lang['BLOCNOTE'][$langue];
	//TblCellule("<H1>$mot</H1>");
	//entete_sagec($mot);

	//echo PHP_OS; // retourne linux 

	TblDebut(0,"100%");
	TblDebutLigne();
		TblCellule($string_lang['AUTEUR'][$langue].":");
		TblCellule($utilisateur->prenom." ".$utilisateur->nom);
	TblFinLigne();
	TblDebutLigne();
		$timestamp = time();
		TblCellule($string_lang['DATE'][$langue].":");
		$date = dateHeureComplete(time(),$langue);
		TblCellule($date);
	TblFinLigne();
	?>
	<tr>
		<td><?php echo $string_lang['MESSAGE'][$langue].':';?></td>
		<td><textarea style="width: 50%;" name="montexte">&lt;br /&gt; </textarea></td>
	</tr>
	
	<noscript>
	<?php
	/**
	if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Firefox' ) !== FALSE ) { echo " Firefox"; }
	elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera' ) !== FALSE ) { echo " Opera"; }
	elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Safari' ) !== FALSE ) { echo "Safari"; }
	elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== FALSE ) { echo "Internet Explorer"; }
	else { echo "navigateur non reconnu"; }
	echo "Votre navigateur a pour \"signature\":<br />".
    htmlEntities($_SERVER["HTTP_USER_AGENT"]);
   */
	TblDebutLigne();
		TblCellule($string_lang['MESSAGE'][$langue].":");
		$mot=$string_lang['VALIDER'][$langue];
	 	TblCellule("<TEXTAREA COLS=\"60\" ROWS=\"5\" NAME=\"montexte\"></TEXTAREA> ");
	TblFinLigne();
	?>
	</noscript>
		<tr>
			<td>&nbsp;</td>
			<td><input type="radio" name="irq" value="1" checked> information
			<input type="radio" name="irq" value="2"> question
			<input type="radio" name="irq" value="3"> réponse</td>
		</tr>
	<?php
	TblDebutLigne();
		TblCellule(" ");
		$mot=$string_lang['VALIDER'][$langue];
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"VALIDER\" ");
	TblFinLigne();
	TblFin();
	//print("<INPUT TYPE=\"HIDDEN\" NAME=\"date\" VALUE=\"$timestamp\">");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"auteur\" VALUE=\"$_SESSION[member_id]\">");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"visible\" VALUE=\"o\">");
print("</FORM>");
print("</HEAD></HTML>");
}

?>
