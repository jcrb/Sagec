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
  * programme: 			aide.php
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
include_once("top_main.php");
include_once("menu_main.php");
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
		<legend>Contact</legend>
		<p>
			Pour toute question, commentaire, suggestion adressez vos messages à <a href="mailto:jeanclaude.bartier@gmail.com">jeanclaude.bartier@gmail.com</a>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Structure du code</legend>
		<p>
			L'identifiant victime est un code à 13 chiffres basé sur le principe de la norme EAN 13 (ISBN, CIP des médicaments, produits manufacturés, etc.)<br>
			L'identiant se compose de 12 chiffres et d'une clé de contrôle qui permet sa validation <br>
			<table>
				<tr>
					<th>code pays</th>
					<th>code organisme</th>
					<th>code victime</th>
					<th>clé de controle</th>
				</tr>
				<tr>
					<td>300</td>
					<td>0001</td>
					<td>00001</td>
					<td>0</td>
				</tr>
			</table>
			<br>
			Cet identifiant se transcode facilement en code barre <br>
			Le SAMU 67 se propose de maintenir à jour une liste unique d'identifiants pour les organismes de manière à ce que chacun puisse émettre<br>
			ses propres codes sans risquer de créer des doublons avec d'autres organismes de secours.<br>
			<br>
			Par convention, les codes commençant par 379 sont des identifiants d'exercice<br>
		</p>
	</fieldset>
</div>

</form>
</body>
</html>