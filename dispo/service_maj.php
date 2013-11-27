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
  * programme: 			service_maj.php
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
require $backPathToRoot.'utilitairesHTML.php';

$serviceID = $_REQUEST['the_service'];

if(isset($serviceID))
{
	$requete = "SELECT service.*, org_nom
					FROM service,organisme
					WHERE service_ID = '$serviceID'
					AND service.org_ID = organisme.org_ID
					";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	print_r($rub);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>MAJ d'un service</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend><? echo $string_lang['ORGANISME'][$langue];?> </legend>
		<p>
			<label for="nom" title="nom">Nom:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo $rub[org_nom];?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="nom" title="nom">Site:</label>
			<?php select_hopital($connexion,$rub[Hop_ID],$langue);?>
		</p>
		<p>
			<label for="nomc" title="nomc">Nom complet:</label>
			<input type="text" name="nomc" id="nomc" title="nomc" value="<? echo $rub[service_nom];?>" size="50" onFocus="_select('nomc');" onBlur="deselect('nomc');"/>
		</p>
		<p>
			<label for="code" title="n� de code du service">Code service:</label>
			<input type="text" name="code" id="code" title="code" value="<? echo $rub[service_code];?>" size="10" onFocus="_select('code');" onBlur="deselect('code');"/>
		</p>
		<p>
			<label for="code" title="discipline">Discipline:</label>
			<?php SelectDiscipline($connexion,$rub[service_discipline_ID]);?>
		</p>
		<p>
			<label for="code" title="groupe">Groupe:</label>
			<?php SelectGroupe($connexion,$rub[service_groupe_ID]);?> <!--groupe_id-->
		</p>
		<p>
			<label for="code" title="special">Specialit�:</label>
			<?php select_specialite($connexion,$rub[specialite_ID],$langue);?> <!--groupe_id-->
		</p>
		<p>
			<label for="code" title="special">Specialit�:</label>
			<?php SelectTypeService($connexion,$rub[type_ID],$langue);?> <!--groupe_id-->
		</p>
	</fieldset>
	<!-- champ de type TextArea -->
	<fieldset id="field1">
		<legend> Commentaires </legend>
		<p>
			<label for="rem" title="rem">Remarque:</label>
			<textarea name="rem" id="rem" rows="2" cols="50"></textarea>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Calendrier </legend>
		<label for="date1" title="date1">Date 1:</label>
		<input TYPE="text" VALUE="" NAME="date" SIZE="10" id="date1">
		<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=dispo_main&elem=date','Calendrier','width=200,height=280')">
	</fieldset>
	
	<fieldset id="field1">
		<legend> Case � cocher </legend>
		<p>
			<label for="ferme">ligne ferm�e :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Bouton radio </legend>
		<p>
			<label for="type" title="type">type :</label>
			<input type="radio" name="type" id="type" title="type" value="1" onFocus="_select('type');" onBlur="deselect('type');"/> Service
			<input type="radio" name="type" id="type" title="type" value="2" onFocus="_select('type');" onBlur="deselect('type');"/> UF
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