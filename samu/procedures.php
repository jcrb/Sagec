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
  * programme: 			procedures.php
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
$backPathToRoot = "../";
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
		<legend>Proc�dures</legend>
		<table>
			<tr><td><a href="../procedures/Crise FT002 - Gaz renforc�.pdf">Proc�dure gaz renforc�e</a></td></tr>
			<tr><td><a href="">Proc�dure UNV HTP</a></td></tr>
			<tr><td><a href="">Proc�dure coeur arr�t�</a></td></tr>
			<tr><td><a href="">Sc�ne de crime</a></td></tr>
		</table>
	</fieldset>
	
	
</div>

<?php
?>

</form>
</body>
</html>
