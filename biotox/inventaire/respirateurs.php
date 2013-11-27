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
  * programme: 			inventaire_main.php
  * date de création: 	19/08/2012
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
$titre_principal = "Inventaire - Respirateurs";
$sousmenu = "";
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
	<link rel="shortcut icon" href= "<?php echo $backPathToRoot;?>images/sagec67.ico" />
	<script  type="text/javascript" src= "<?php echo $backPathToRoot;?>utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">
<form name="" action= "" method = "post">
<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Respirateur </legend>
		<p>
			<label for="nom" title="nom">Nom:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo $rub[''];?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="type" title="type">Type:</label>
			<input type="text" name="type" id="type" title="type" value="<? echo $rub[''];?>" size="50" onFocus="_select('type');" onBlur="deselect('type');"/>
		</p>
		<p>
			<label for="marque" title="marque">Marque:</label>
			<input type="text" name="marque" id="marque" title="marque" value="<? echo $rub[''];?>" size="50" onFocus="_select('marque');" onBlur="deselect('marque');"/>
		</p>
		<p>
			<label for="no_serie" title="no_serie">n° de série:</label>
			<input type="text" name="no_serie" id="no_serie" title="no_serie" value="<? echo $rub[''];?>" size="50" onFocus="_select('no_serie');" onBlur="deselect('no_serie');"/>
		</p>
		<p>
			<label for="no_inventaire" title="no_inventaire">n° inventaire:</label>
			<input type="text" name="no_inventaire" id="no_inventaire" title="no_inventaire" value="<? echo $rub[''];?>" size="50" onFocus="_select('no_inventaire');" onBlur="deselect('no_inventaire');"/>
		</p>
	</fieldset>
</div>
<?php
?>

</form>
</body>
</html>