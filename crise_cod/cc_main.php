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
  * programme: 			ars_deces.php
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
$titre_principal = "COD";
include_once("cc_top.php");
include_once("cc_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
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

<body onload="">

<form name="" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> </legend>
		<p>
			<img alt="sport" name="sport" src="../images/CCrise.jpg">
		</p>
	</fieldset>
	
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Main courante </legend>
		<p>
			La <a href="blocnote_lire.php">main courante</a> est le premier document à activer lors de l'ouverture de la cellule de crise.<br>
			Elle permet de noter à la volée tous les évènements et informations pertinentes générées par l'évènement.
			Les informations sont automatiquement identifiées et horodatées. Si nécessaire, elles peuvent être transmises automatiquement au SAMU.
		</p>
	</fieldset>
	
	<fieldset id="field1">
	<legend> SAMU 67 </legend>
		<p>
			La rubrique <a href="cc_samu.php">SAMU 67</a> permet d'accéder en mode lecture à la main courante du SAMU.
		</p>
	</fieldset>
	
		<fieldset id="field1">
	<legend> Liste des Taches </legend>
		<p>
			La rubrique <a href="">Liste des taches</a> permet de valider les taches à accomplir par les grandes fonction de direction.
		</p>
	</fieldset>
	
	<fieldset id="field1">
	<legend> Lits et places </legend>
		<p>
			La rubrique <a href="cc_lits.php">Lits et place</a> donne un aperçu des lits disponibles.
		</p>
	</fieldset>
	
</div>

<?php
?>

</form>
</body>
</html>
