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
/** ---------------------------------------------------------------------------------
  * programme: 			dossier_complet_main.php
  * date de cr�ation: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
/**
  *	identifiant patient
  */
$id = $_REQUEST['id'];
$titre_principal = "Dossier complet - ".$id;
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

$_SESSION[DOSSIER_COURANT] = $_REQUEST['id'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href= "<?php echo $backPathToRoot;?>images/sagec67.ico" />
	<script  type="text/javascript" src= "<?php echo $backPathToRoot;?>utilitaires.js"></script>
</head>


<body onload="document.getElementById('nom').focus()">

<form name="" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend><? echo $string_lang['ORGANISME'][$langue];?> </legend>
		<p>
			<label for="nom" title="nom">Nom:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo $rub[0];?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="nomc" title="nomc">Nom complet:</label>
			<input type="text" name="nomc" id="nomc" title="nomc" value="<? echo $rub[0];?>" size="50" onFocus="_select('nomc');" onBlur="deselect('nomc');"/>
		</p>
	</fieldset>
	<!-- champ de type TextArea -->
	<fieldset id="field1">
		<legend> Commentaires </legend>
		<p>
			<label for="rem" title="rem">Remarque:</label>
			<textarea name="rem" id="rem" rows="2" cols="50"></textarea>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Calendrier </legend>
		<label for="date1" title="date1">Date 1:</label>
		<input TYPE="text" VALUE="" NAME="date" SIZE="10" id="date1">
		<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=dispo_main&elem=date','Calendrier','width=200,height=280')">
	</fieldset>
	
	<fieldset id="field1">
		<legend> Case � cocher </legend>
		<p>
			<label for="ferme">ligne ferm�e :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Bouton radio </legend>
		<p>
			<label for="type" title="type">type :</label>
			<input type="radio" name="type" id="type" title="type" value="1" onFocus="_select('type');" onBlur="deselect('type');"/> Service
			<input type="radio" name="type" id="type" title="type" value="2" onFocus="_select('type');" onBlur="deselect('type');"/> UF
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