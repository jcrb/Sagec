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
  * programme: 			fournisseur_voir.php
  * date de création: 	08/08/2012
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
$titre_principal = "Biotox - Fournisseurs";
$sousmenu = "";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

$ID = $_REQUEST[id];
if($ID > 0){ // mise à jour
	$requete = "SELECT * FROM fournisseur WHERE fournisseur_ID = '$ID'";
	$reponse = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($reponse);
}
else $ID = 0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>fournisseur_voir</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href= "<?php echo $backPathToRoot;?>images/sagec67.ico" />
	<script  type="text/javascript" src= "<?php echo $backPathToRoot;?>utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">
<form name="" action= "fournisseur_enregistre.php?id=<?php echo $ID;?>" method = "post">
<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Organisme</legend>
		<p>
			<label for="nom" title="nom">Nom:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo Security::db2str($rub['fournisseur_nom']);?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="adr" title="adr">Adresse:</label>
			<input type="text" name="adr" id="adr" title="adr" value="<? echo Security::db2str($rub['fournisseur_adr']);?>" size="50" onFocus="_select('adr');" onBlur="deselect('adr');"/>
		</p>
	</fieldset>
	
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
</div>

</form>
</body>
</html>