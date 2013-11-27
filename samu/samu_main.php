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
if(!isset($_SESSION['member_id'])) header("Location:".$backPathToRoot."logout.php");
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="top.css" type="text/css" media="all" />
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="">

<form name="" action= "" method = "post">

<div id="div2">
	
	<fieldset id="field1">
		<legend>Régulation </legend>
		<p>
			Aides à la régulation notamment la cartographie et la géolocalisation
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend>Main courante </legend>
		<p>
			Informations partagées entre les membres de la régulation, le terrain et les cellules de crise.
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend>Situation de crise</legend>
		<p>
			Regroup les outils permettant de gérer les intervenants, les vecteurs, 
			les victimes et les places hospitalières.
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend>Répertoire opérationnel de ressources (ROR)</legend>
		<p>
			Gestion à froid des ressources matérielles et humaines
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Procédures</legend>
		<p>
			Liste des <a href="procedures.php">procédures</a> applicables au SAMU67
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Surveillance syndromique</legend>
		<p>
			Gestion des éléments de surveillance épidémiologique
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend>Gestion administrative</legend>
		<p>
			Gestion des tables, des utilisateurs, etc.
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend>Secrétariat</legend>
		<p>
			Liste des personnes, nouvelles inscriptions, affectations, etc.
		</p>
	</fieldset>
	
	
</div>

<?php
?>

</form>
</body>
</html>
