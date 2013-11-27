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
  * programme: 			aujourdhui.php
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
$titre_principal = "";
include_once("top.php");
include_once("menu.php");
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

<body onload="document.getElementById('nom').focus()">

<form name="" action= "today_enregistre.php" method = "get">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Hélicoptères</legend>
		<p>
			<label for="nom" title="nom">Dragon 67:</label>
			<select name="helico1">
				<option value="1">Opérationnel</option>
				<option value="2">Indisponible</option>
			</select>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Services</legend>
		<p>
			<label for="nom" title="nom">SOS Main:</label>
			<select name="main">
				<option value="1">CCOM</option>
				<option value="2">Diaconat</option>
			</select>
		</p>
		<p>
			<label for="nom" title="nom">Réa medicale:</label>
			<select name="rea_med">
				<option value="1">NHC</option>
				<option value="2">HTP</option>
			</select>
		</p>
		
		<p>
			<label for="nom" title="nom">CNH:</label>
			<select name="cnh">
				<option value="1">NHC</option>
				<option value="2">HTP</option>
			</select>
		</p>
		<p>
			<label for="nom" title="nom">IPM:</label>
			<select name="ipm">
				<option value="1">NHC</option>
				<option value="2">HTP</option>
			</select>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Missions</legend>
		<p>
			<label for="nom" title="nom">DSM:</label>
			<select name="dsm">
				<option value="1">SAMU 67</option>
				<option value="2">SDIS 67</option>
			</select>
		</p>
	</fieldset>

	<fieldset id="field1">
		<legend>Protocoles en cours</legend>
		<p>
			<label for="nom" title="nom">Coeur arrêté:</label>
			<select name="proto1">
				<option value="1">Actif</option>
				<option value="2">Suspendu</option>
				<option value="3">En attente</option>
			</select>
		</p>
		<p>
			<label for="nom" title="nom">Cartagène:</label>
			<select name="proto2">
				<option value="1">Actif</option>
				<option value="2">Suspendu</option>
				<option value="3">En attente</option>
			</select>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Premier secours</legend>
		<p>
			<label for="nom" title="nom">ADPC 67:</label>
			<select name="adpc">
				<option value="1">ACTIF</option>
				<option value="2">INACTIF</option>
			</select>
		</p>
		<p>
			<label for="nom" title="nom">CRF 67:</label>
			<select name="crf">
				<option value="1">ACTIF</option>
				<option value="2">INACTIF</option>
			</select>
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