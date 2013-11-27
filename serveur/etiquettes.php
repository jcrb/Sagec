<?php
/**----------------------------------------- SAGEC ---------------------------------
  * This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
  * SAGEC67 is free software; you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation; either version 2 of the License, or
  * (at your option) any later version.
  * SAGEC67 is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  * You should have received a copy of the GNU General Public License
  * along with SAGEC67; if not, write to the Free Software
  * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */	
/** ----------------------------------------------------------------------------
  * programme: 			ars_deces.php
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * --------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
include_once("top_main.php");
include_once("menu_main.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."utilitairesHTML.php");
require($backPathToRoot."login/init_security.php");
$type = "1,3"; // SAMU et SDIS
$item_select = $_SESSION['organisation'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nb').focus()">

<form name="etiquette" action= "imprime_etiquettes2.php" method = "get">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Identifiants</legend>
		<p>
			<label for="org" title="org">Organisme:</label>
			<?php SelectOrgParType($connexion,$_SESSION['organisation'],$langue,$type);?>
		</p>
		<p>
			<label for="nb" title="nb">nombre souhaité:</label>
			<input type="text" name="nb" id="nb" title="nb" value="10" size="10" onFocus="_select('nb');" onBlur="deselect('nb');"/>
			(maximum: 99.999)
		</p>
		<p>
			<label for="no" title="no">n° victime 1:</label>
			<input type="text" name="no" id="no" title="no" value="1" size="10" onFocus="_select('no');" onBlur="deselect('no');"/>
			numero d'ordre de la première étiquette de la série
		</p>
		<p>
			<label for="ferme">avec code barre :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="type" title="type">type :</label>
			<input type="radio" name="type" id="type" title="type" value="1" checked onFocus="_select('type');" onBlur="deselect('type');"/> Exercice
			<input type="radio" name="type" id="type" title="type" value="2" onFocus="_select('type');" onBlur="deselect('type');"/> Réel
		</p>
		<p>
			<!--<a href="paper_printer.php">impresion papier</a>-->
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
