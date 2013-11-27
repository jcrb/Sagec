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
  * programme: 			cartographie.php
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
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body>

<form name="" action= "" method = "post">

<!-- <div><img src="../images/voiture.jpg" alt="voiture"></div> -->

<div id="div2"  width="50%">
	<fieldset id="field1">
		<legend>Strasbourg</legend>
		<p>
			<a href="../docs/Rallye/shakedown.pdf" target="_blank">Shakedown</a>
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend>Bischwiller</legend>
		<p>
			<a href="../docs/Rallye/bischwiller 1.pdf" target="_blank">Bischwiller 1</a>
		</p>
		<p>
			<a href="../docs/Rallye/bischwiller 2.pdf" target="_blank">Bischwiller 2</a>
		</p>
		<p>
			<a href="../docs/Rallye/Bischwiller vue d'ensemble.pdf" target="_blank">Vue d'ensemble</a>
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend>Cleebourg</legend>
		<p>
			<a href="../docs/Rallye/cleebourg 1.pdf" target="_blank">Cleebourg 1</a>
		</p>
		<p>
			<a href="../docs/Rallye/cleebourg 2.pdf" target="_blank">Cleebourg 2</a>
		</p>
		<p>
			<a href="../docs/Rallye/Cleebourg vue d'ensemble.pdf" target="_blank">Vue d'ensemble</a>
		</p>
	</fieldset>
		<fieldset id="field1">
		<legend>Haguenau</legend>
		<p>
			<a href="../docs/Rallye/haguenau.pdf" target="_blank">Haguenau 1</a>
		</p>
		<p>
			<a href="../docs/Rallye/haguenau vue d'ensemble.pdf" target="_blank">Vue d'ensemble</a>
		</p>
	</fieldset>
		</fieldset>
		<fieldset id="field1">
		<legend>Klevener</legend>
		<p>
			<a href="../docs/Rallye/klevener.pdf" target="_blank">Klevener 1</a>
		</p>
		<p>
			<a href="../docs/Rallye/klevener vue d'ensemble.pdf" target="_blank">Vue d'ensemble</a>
		</p>
	</fieldset>
		<fieldset id="field1">
		<legend>Salm</legend>
		<p>
			<a href="../docs/Rallye/salm 1.pdf" target="_blank">Salm 1</a>
		</p>
		<p>
			<a href="../docs/Rallye/salm 2.pdf" target="_blank">Salm 2</a>
		</p>
		<p>
			<a href="../docs/Rallye/Salm vue d'ensemble.pdf" target="_blank">Vue d'ensemble</a>
		</p>
	</fieldset>
	<fieldset id="field1">
		<legend>Ungersberg</legend>
		<p>
			<a href="../docs/Rallye/ungersberg 1.pdf" target="_blank">Ungersberg 1</a>
		</p>
		<p>
			<a href="../docs/Rallye/ungersberg 2.pdf" target="_blank">Ungersberg 2</a>
		</p>
		<p>
			<a href="../docs/Rallye/Ungersberg vue d'ensemble.pdf" target="_blank">Vue d'ensemble</a>
		</p>
	</fieldset>
		<fieldset id="field1">
		<legend>Haut-Rhin</legend>
		<p>
			<a href="../docs/Rallye/hohlandsbourg.pdf" target="_blank">Hohlandsbourg</a>
		</p>
		<p>
			<a href="../docs/Rallye/munster.pdf" target="_blank">Munster</a>
		</p>
		<p>
			<a href="../docs/Rallye/firstplan.pdf" target="_blank">Firstplan</a>
		</p>
		<p>
			<a href="../docs/Rallye/grandballon.pdf" target="_blank">Grand Ballon</a>
		</p>
		<p>
			<a href="../docs/Rallye/ormont.pdf" target="_blank">Pays d'Ormont</a>
		</p>
		<p>
			<a href="../docs/Rallye/mulhouse.pdf" target="_blank">Mulhouse</a>
		</p>
	</fieldset>
	
</div>

<?php
	echo $_SESSION[Hop_ID];
?>

</form>
</body>
</html>