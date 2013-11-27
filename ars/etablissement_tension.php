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
  * programme: 			etablissement_tension.php
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
include_once("ars_top.php");
include_once("ars_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Tension</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="tension" action= "" method = "get">

<div id="div2">
	<fieldset id="field1">
		<legend><? echo $string_lang['ORGANISME'][$langue];?> </legend>
		<table>
			<tr>
				<th>Mesure</th>
				<th>Réalisée</th>
				<th>Date d'effet</th>
				<th>Date de fin</th>
				<th>Commentaires</th>
			</tr>
			<tr>
				<td>Réouverture de lits</td>
				<td><input type="checkbox" id="ouverture" name="ouverture" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> /></td>
				<td>
					<input TYPE="text" VALUE="" NAME="date1" SIZE="10" id="date1">
					<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=tension&elem=date1','Calendrier','width=200,height=280')">
				</td>
				<td><input TYPE="text" VALUE="" NAME="date2" SIZE="10" id="date2"><input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=tension&elem=date2','Calendrier','width=200,height=280')"></td>
				<td><textarea name="rem1" id="rem" rows="2" cols="50"></textarea></td>
			</tr>
			<tr>
				<td>Rappels de personnels</td>
				<td><input type="checkbox" id="rappel" name="rappel" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> /></td>
				<td>
					<input TYPE="text" VALUE="" NAME="date3" SIZE="10" id="date3">
					<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=tension&elem=date3','Calendrier','width=200,height=280')">
				</td>
				<td><input TYPE="text" VALUE="" NAME="date4" SIZE="10" id="date4"><input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=tension&elem=date4','Calendrier','width=200,height=280')"></td>
				<td><textarea name="rem2" id="rem" rows="2" cols="50"></textarea></td>
			</tr>
			<tr>
				<td>Déprogrammation</td>
				<td><input type="checkbox" id="depro" name="depro" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> /></td>
				<td>
					<input TYPE="text" VALUE="" NAME="date5" SIZE="10" id="date5">
					<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=tension&elem=date5','Calendrier','width=200,height=280')">
				</td>
				<td><input TYPE="text" VALUE="" NAME="date6" SIZE="10" id="date6"><input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=tension&elem=date6','Calendrier','width=200,height=280')"></td>
				<td><textarea name="rem3" id="rem" rows="2" cols="50"></textarea></td>
			</tr>
			<tr>
				<td>Activation du plan blanc</td>
				<td><input type="checkbox" id="pb" name="pb" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> /></td>
				<td>
					<input TYPE="text" VALUE="" NAME="date7" SIZE="10" id="date7">
					<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=tension&elem=date7','Calendrier','width=200,height=280')">
				</td>
				<td><input TYPE="text" VALUE="" NAME="date8" SIZE="10" id="date8"><input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=tension&elem=date8','Calendrier','width=200,height=280')"></td>
				<td><textarea name="rem4" id="rem" rows="2" cols="50"></textarea></td>
			</tr>
		</table>
		<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
</div>

<?php
?>

</form>
</body>
</html>