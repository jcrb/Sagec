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
  * programme: 			admin_check_main.php
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "Caractéristiques de l'évènement";
include_once("cc_top.php");
include_once("admin_evenement_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Evenement</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="">

<form name="fiche_evenement" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> A propos </legend>
		<p>
			<label for="nom" title="nom">Identifiant évènement:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo $rub[0];?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="nom" title="nom">Lieu:</label>
			<input type="text" name="lieu" id="lieu" title="lieu" value="<? echo $rub[0];?>" size="50" onFocus="_select('lieu');" onBlur="deselect('lieu');"/>
		</p>
		<p>
			<label for="date1" title="date1">Date:</label>
			<input TYPE="text" VALUE="" NAME="date" SIZE="10" id="date" onFocus="_select('date');" onBlur="deselect('date');">
			<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=fiche_evenement&elem=date','Calendrier','width=200,height=280')">
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Informations générales </legend>
		<p>
			<label for="ig1">Gestion opérationelle :</label>
			<input type="checkbox" id="ig1" name="ig1" <?php if($way['ig1']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="ig2">Exercice :</label>
			<input type="checkbox" id="ig2" name="ig2" <?php if($way['ig2']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="ig3">Autres :</label>
			<input type="checkbox" id="ig3" name="ig3" <?php if($way['ig3']=='o') echo(' CHECKED')?> />
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Typologie de l'évènement </legend>
		<p>
			<label for="ferme">Risque naturel :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="ferme">Risque Industriel :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="ferme">Risque Sanitaire :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="ferme">Risque sociétal :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="ferme">Défense Civile :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="ferme">Risque infrastructure :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="ferme">Risque divers :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="ferme">Exercice PPI :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
	</fieldset>
	
</div>

<?php
?>

</form>
</body>
</html>
