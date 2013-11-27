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
*	programme: 		bloc_note.php								
*	date de création: 	18/08/2003	
*	auteur:			jcb
*	description:		Enregistre une information textuelle			
*	@version:		$Id: bloc_note.php 36 2008-02-22 16:05:49Z jcb $
*	maj le:			09/04/2004
*	Totalement réécrit le 7 mai 2011
*/
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "COD - Nouveau message";
include_once("cc_top.php");
include_once("cc_menu.php");
require $backPathToRoot."utilitaires/globals_string_lang.php";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."html.php");
/**
  *	Identifier l'auteur du message
  */
  $query = "SELECT nom, prenom FROM utilisateurs WHERE ID_utilisateur = '$_SESSION[member_id]'";
	$resultat = ExecRequete($query,$connexion);
	$rep = mysql_fetch_array($resultat);
	$utilisateur = $rep['nom'].' '.$rep['prenom'];

$timestamp = date("Y-m-j H:i:s");// format compatible mysql
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Liste des messages</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	
	<script src="../tinymce/tiny_mce/tiny_mce.js" type="text/javascript"></script>
	<script src="../tinymce/textarea.js" type="text/javascript"></script>
	
</head>

<body onload="document.getElementById('rem').focus()">
<form name="" action= "blocnote_enregistre.php" method = "post">

	<input type="hidden" name="date" value="<?php echo $timestamp;?>">
	<input type="hidden" name="auteur" value="<?php echo $_SESSION['member_id'];?>">


<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Mon message </legend>
		<p><label>Auteur: </label> <?php echo $utilisateur;?></p>
		<p><label>Date: </label> <?php echo $timestamp;?></p>

		<p>
			<label for="rem" title="rem">Message:</label>
			<textarea name="montexte" id="rem" rows="2" cols="50"></textarea>
		</p>

		<p>
			<label for="copie">Copie SAMU :</label>
			<input type="checkbox" id="copie" name="copie" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
<!--
		<p>
			<label for="type" title="type">type :</label>
			<input type="radio" name="type" id="type" title="type" value="1" onFocus="_select('type');" onBlur="deselect('type');"/> Service
			<input type="radio" name="type" id="type" title="type" value="2" onFocus="_select('type');" onBlur="deselect('type');"/> UF
		</p>
		-->
	</fieldset>
	
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
</div>

<?php
/*


// Il s'agit d'un utilisateur répertorié
if($utilisateur)
{

	print("<FORM name =\"blocnote\" METHOD=\"GET\" ACTION=\"blocnote_enregistre.php\">");

	setlocale(LC_TIME,"french");
	$dateFR = strFTime("%A %d %B %Y");

	if(isset($_GET['back'])) $back = $_GET['back'];
	else $back = "login2.php";
	TblDebut(0,"100%");
	TblDebutLigne("A1");
	$mot = $string_lang['LIREBN'][$langue];
		TblCellule("<A HREF=\"blocnote_lire.php\">$mot</A>");
		if($_SESSION['autorisation']>9)
			TblCellule("<A HREF=\"blocnote_lire.php\">Sauvegarder</A>");
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
		$copie = $string_lang['COPIE'][$langue]." SAMU 67";
		TblCellule($copie);
		print("<TD><input type=\"checkbox\" name=\"copie\" checked></TD");
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
}
*/
?>
</form>
</body>
</html>
