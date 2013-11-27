<?php
//----------------------------------------- SAGEC ---------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
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
//		
//---------------------------------------------------------------------------------
//	programme: 				maj_cemment.php
//	date de création: 	12/02/2010
//	auteur:					jcb
//	description:			portail accès au services par les hôpitaux.
//								Remplace le dossier services 
//	version:					1.0
//	maj le:			
//---------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require $backPathToRoot.'utilitairesHTML.php';
require($backPathToRoot."dbConnection.php");
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

<form name="choix" action= "service_maj.php" method = "post">

<div id="div2">

	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Informations sur les services </legend>
			<p>Cette page permet de mettre à jour les informations concernant les services d'un hôpital</p>
			<p>On accède aux différents services à partir d'une liste des services</p>
			<p>Il s'agit d'informations de base nécessitant d'être vérifiée tous les 6 mois environ<br>
				ou plus souvent si nécessaire</p>
			<p><a href="service_maj.php">mettre à jour les données des services</a></p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Sélectionner un service </legend>
			<p>
				<?php select_service($connexion,$_SESSION[organisation],$item_select); ?> <!-- the_service -->
				<br>
				<input type="submit" name="ok" id="submit" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
			</p>
	</fieldset>
	
</div>

<?php
?>

</form>
</body>
</html>