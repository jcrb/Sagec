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
//	programme: 				ars_comment.php
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
$titre_principal = "Services - Demandes ARS";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Demandes ARS</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="" action= "" method = "post">

<div id="div2">

	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Demandes permanentes </legend>
			<p>Cette page permet d'enregistrer des informations concernant le suivi annuel de certains indicateurs</p>
			<ul>
				<li><a href="ars_deces.php">Recueil de la mortalité hospitalière</a></li>
			</ul>
	</fieldset>
	
	<br>
	<fieldset id="field1">
		<legend>Demandes ponctuelles </legend>
		<p>Cette page permet d'enregistrer des informations concernant le suivi annuel d'indicateurs saisonniers</p>
		<li><a href="">Cas de grippe</a></li>
		<li><a href="">Indicateurs canicule</a></li>
		<li><a href="">Indicateurs grand froid</a></li>
	</fieldset>
	
</div>

<?php
?>

</form>
</body>
</html>