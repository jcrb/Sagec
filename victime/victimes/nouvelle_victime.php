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
  * programme: 			nouvelle_victime.php
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
$backPathToRoot = "../../";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."utilitairesHTML.php");
$zds = 4;// secrétariat d'entrée par défaut
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
	<script>
			function controle()
			{
				if(document.forms[0].identifiant.value != "")
				{
					return true;
				}
				else
				{
					alert('il faut obligatoirement un identifiant');
					return false;
				}
			}
		</script>
</head>

<?php
if(empty($_SESSION['poste']))
{
	echo "<h2><a href='../../dossier_cata/poste_de_saisie.php?back=../victime/victimes/nouvelle_victime.php'>Veuillez indiquer votre poste de travail</a></h2>";
}
else
{
?>

<body onload="document.getElementById('identifiant').focus()">

<form name="identifiant" action= "victimes_saisie2.php" method = "get" onsubmit="return controle()">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Nouvelle Victime</legend>
		<p>
			<label for="identifiant" title="identifiant">identifiant victime:</label>
			<input type="text" name="identifiant" id="identifiant" title="identifiant" value="" size="50" onFocus="_select('identifiant');" onBlur="deselect('identifiant');"/>
		</p>
		<p>
			<label for="identifiant" title="identifiant">poste de saisie:</label>
			<?php echo $_SESSION['poste'];?>
		</p>
				<p>
			<input type="submit" name="ok1" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
		</p>
	</fieldset>
</div>

<?php
}
?>

</form>
</body>
</html>