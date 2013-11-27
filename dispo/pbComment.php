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
//	programme: 				pbComment.php
//	date de cr�ation: 	12/02/2010
//	auteur:					jcb
//	description:			portail acc�s au plan blanc
//							
//	version:					1.0
//	maj le:			
//---------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "Services - Plan blanc";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
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

<form name="" action= "" method = "post">

<div id="div2">

	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Lits et places disponibles</legend>
			<p><a href="lits_planBlanc.php">Disponibilit�s imm�diates en lits</a></p>
			<p>Cette page permet de renseigner instantann�ment la cellule de crise de l'�tablisssement sur les lits disponibles</p>
			<p>La capacit� d'h�bergement d'un h�pital est un �l�ment cl� du dispositif Plan Blanc. Vous pouvez utiliser cette page aussi souvent que n�cessaire
				<br> en fonction de l'�volution de vos capacit�s et d�s le d�clenchement de l'alerte. Ce qui int�resse le gestionnaire de la crise, c'est:
				<br> - le nombre de lits vides � T0
				<br> - l'estimation de nombre de lits vides � T0+30, T+60 mn du fait du renvoi des maladesvers d'autres structures
			</p>
			
	</fieldset>
	<br>
	<fieldset id="field1">
		<legend>Informations Plan Blanc</legend>
			<p>Cette page donne des informations sur les op�rations en cours</p>
			<p><a href="">Informations</a></p>
	</fieldset>
	<br>
	<fieldset id="field1">
		<legend>Informations Victimes</legend>
			<p>Cette page donne des informations sur les victimes orient�es vers ce service (ce n'est pas la liste exhaustive des victimes)</p>
			<p><a href="pb_victimes.php">liste</a></p>
	</fieldset>
	
</div>

<?php
?>

</form>
</body>
</html>