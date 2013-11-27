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
  * programme: 			annuaire_ajoute.php
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
$id =  $_REQUEST['id'];// annu_ID

require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."utilitairesHTML.php");

if($_REQUEST['ok']=='Envoyer'){
	$requete = "UPDATE annuaire SET 
					annu_titre1 = '$_REQUEST[titre1]',
					annu_titre2 = '$_REQUEST[titre2]',
					annu_valeur = '$_REQUEST[valeur]',
					annu_visible = '$_REQUEST[visible]',
					annu_type = '$_REQUEST[type]'
					WHERE annu_ID = '$id'
					";
	$resultat = ExecRequete($requete,$connexion);
	header("Location:".$backPathToRoot.$_SESSION['back']);
	//echo $id;
}

if($id > 0){
	$requete = "SELECT * FROM annuaire WHERE annu_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
}
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

<body onload="document.getElementById('titre1').focus()">

<form name="" action= "annuaire_enregistre.php" method = "post">
<input type="hidden" name="id" value="<?php echo $id;?>">
<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Entrée annuaire</legend>
		<p>
			<label for="titre1" title="titre1">titre1:</label>
			<input type="text" name="titre1" id="titre1" title="titre1" value="<? echo $rub['annu_titre1'];?>" size="45" onFocus="_select('titre1');" onBlur="deselect('titre1');"/>
		</p>
		<p>
			<label for="nomc" title="titre2">titre2:</label>
			<input type="text" name="titre2" id="titre2" title="titre2" value="<? echo $rub['annu_titre2'];?>" size="45" onFocus="_select('titre2');" onBlur="deselect('titre2');"/>
		</p>
		<p>
			<label for="type" title="type">type:</label>
			<?php Select_from_table('type','type_contact','type_contact_ID','type_contact_nom',$rub['annu_type'],'type_contact_nom');?>
		</p>
		<p>
			<label for="nomc" title="nomc">valeur:</label>
			<input type="text" name="valeur" id="valeur" title="valeur" value="<? echo $rub['annu_valeur'];?>" size="45" onFocus="_select('valeur');" onBlur="deselect('valeur');"/>
		</p>
		<p>
			<label for="visible">visible:</label>
			<input type="checkbox" id="visible" name="visible" <?php if($rub['annu_visible']=='o') echo(' CHECKED')?> />
		</p>
	</fieldset>
	
	<!-- champ de type TextArea -->
	<fieldset id="field1">
		<legend> Commentaires </legend>
		<p>
			<label for="nomc" title="nomc">&nbsp;</label>
			<textarea name="rem" id="rem" rows="2" cols="50"></textarea>
		</p>
	</fieldset>
	
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
</div>

<?php
?>

</form>
</body>
</html>