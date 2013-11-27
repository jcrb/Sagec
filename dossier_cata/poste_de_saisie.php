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
  * programme: 			poste_de_saisie.php
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			mémorise dans une variable de session la localisation du 
  *							poste de saisie:
  *							- nom du PMA
  *							- situation dans le PMA (tri, évac, etc.)
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
//include_once("top.php");
//include_once("menu.php");
require($backPathToRoot."utilitaires/globals_string_lang.php");
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."utilitairesHTML.php");
$zds = 4;// secrétariat d'entrée par défaut

$back = $_REQUEST['back']; // adresse de retour 

if(!empty($_REQUEST['ok2']))
{
	$_SESSION['localisation'] = $_REQUEST['localisation']; // localisation geographique ex.pma broglie 
	$_SESSION['poste'] = $_REQUEST['status_type'];// poste de saisie ex; secrétariat entrée
	if(!empty($back))
		header("Location:".$back);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des victimes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
</head>

<body onload="document.getElementById('identifiant').focus()">

<form name="identifiant" action= "poste_de_saisie.php" method = "get" onsubmit="return controle()">

<input type="hidden" name="back" value="<?php echo $back;?>">

<div id="div2">
	<fieldset id="field1">
		<legend>Zone de saisie</legend>

		<p>
			<label for="poste"  title="zds">Poste de saisie: </label>
			<?php SelectStatus($connexion,$zds,$langue); ?> <!--  //status_type; -->
		</p>
		<p>
			<label for="localisation" title="localisation">Localisation:</label>
			<input type="text" name="localisation" id="localisation" title="localisation" value="" size="50" onFocus="_select('localisation');" onBlur="deselect('localisation');"/>
		</p>
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok2" id="valider" value="Valider"/>
	</fieldset>
</div>

<?php
?>

</form>
</body>
</html>