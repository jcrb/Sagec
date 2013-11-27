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
$titre_principal = "COD - Nouveau Point de situation";
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
	<title>nouveau point</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	
	<script src="../tinymce/tiny_mce/tiny_mce.js" type="text/javascript"></script>
	<script src="../tinymce/textarea.js" type="text/javascript"></script>
	
</head>

<body onload="document.getElementById('rem').focus()">
<form name="" action= "point_enregistre.php" method = "post">

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

	</fieldset>
	
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
</div>

<?php

?>
</form>
</body>
</html>
