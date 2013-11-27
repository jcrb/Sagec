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
  * programme: 			sdis_config.php
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
$titre_principal="SDIS 67 -Configuration du poste";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."utilitairesHTML.php");
include_once($backPathToRoot."dossier_cata/dossier_cata_utilitaires.php");

$ini_array = parse_ini_file($backPathToRoot."pma.ini");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Configuration du poste</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="config" action= "sdis_config_enregistre.php" method = "post">
<input type="hidden" name="pma_nom" value="<?php echo $ini_array['pma_nom'];?>">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Configuration actuelle </legend>
		<p>
			<?php if(sizeof($ini_array)<1)
				echo "Pas de configuration";
				else {?>
				<p>Localisation: <?php echo $ini_array['pma_nom']; ?></p>
				<p>Poste de saisie: <?php echo $ini_array['pma_saisie']; ?></p>
				<?php
				}
			?>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Nouvelle configuration </legend>
		<p>
			<label for="poste">Poste de saisie: </label>
			<?php SelectStatus($connexion,$ini_array['pma_saisie'],$langue) /*status_type*/ ?>
		</p>
		<p>
			<label for="loc">Localisation: </label>
			<?php localisation($connexion,$ini_array['pma_ID']); ?>
		</p>
		
		<p>
			<input type="submit" name="ok" id="submit" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Informations </legend>
		<p>
			<label for="poste">Identifiant évènement: </label>
			<input type="text">
		</p>
		
		<p>
			<input type="submit" name="ok" id="submit" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
		</p>
	</fieldset>
	
		<fieldset id="field1">
		<legend> Exporter des données </legend>
		<p>
			<label for="poste">victimes: </label>
			<a href="sdis_export.php">export</a>
		</p>
		
		<p>
			<input type="submit" name="ok" id="submit" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
		</p>
	</fieldset>
	
</div>

<?php
?>

</form>
</body>
</html>