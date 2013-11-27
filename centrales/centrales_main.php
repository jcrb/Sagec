<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//		
//---------------------------------------------------------------------------------------------------------
//	programme: 		organisme_saisie.php
//	date de création: 	7/10/2003
//	auteur:			jcb
//	description:		Saisie des caractéristiques d'un organisme
//	version:			1.2
//	maj le:			11/11/2004
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
include_once("top.php");
include_once("menu.php");

include($backPathToRoot."utilitaires/table.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require $backPathToRoot.'utilitaires/google/utilitaires_carto.php';
include($backPathToRoot."utilitairesHTML.php");
require($backPathToRoot."dbConnection.php");
include($backPathToRoot."html.php");
include($backPathToRoot."contact_main.php");
include($backPathToRoot."adresse_ajout.php");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>Gestion des organismes</title>
	<meta http-equiv="content-type" content="="text/ht; charset=ISO-8859-15" ">
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">
<form name="centrales" action= "centrales_enregistre.php" method="GET">
<?php

// mémorisation dans un champ caché $maj de $org_type pour se rappeler s'il s'agit d'une MAJ
// ou d'une création (=0)
print("<INPUT TYPE=\"HIDDEN\" NAME=\"centraleID\" VALUE=\"$_REQUEST[centraleID]\">");
// adresse de retour fournie par le programme appelant
print("<INPUT TYPE=\"HIDDEN\" NAME=\"back\" VALUE=\"$_REQUEST[back]\">");
if(!$nomenu)
	//MenuVecteurs($langue);// $nomenu est une var de session qui bloque l'affichage du menu'
if($_REQUEST['centraleID'] > 0)
{
	$requete = "SELECT * FROM centrale WHERE centrale_ID = '$_REQUEST[centraleID]'";
	$resultat = ExecRequete($requete,$connexion);
	$centrale = mysql_fetch_array($resultat);
	
	//$ad = get_une_adresse($centrale[adresse_ID],'V',$classe);
	$requete = "SELECT * FROM adresse WHERE ad_ID = '$centrale[centrale_adresse_ID]'";
	$resultat = ExecRequete($requete,$connexion);
	$ad = mysql_fetch_array($resultat);
	
	$centraleID = $centrale['centrale_ID'];
}
else if($_REQUEST['centraleID'] == 0)
{
	//$mot=$string_lang['VECTEUR_NOUVEAU'][$langue];
	$mot="Nouvel Organisme";
}
else
{
	$mot=$string_lang['MODIFIER_ORGANISME'][$langue];
}
?>
<div id="div2">

	<fieldset id="field1">
		<legend><? echo $string_lang['CENTRALES'][$langue];?> </legend>
		<p>
			<label for="nom" title="nom"><? echo $string_lang['NOM'][$langue]; ?>:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo $centrale['centrale_nom'];?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="type" title="type"><? echo $string_lang['TYPE'][$langue]; ?>:</label>
			<?php  SelectCentrales($connexion,$centrale['centrale_type_ID'],$langue);?> <!-- retourne centralesID -->
		</p>
		<p>
			<label for="org" title="org"><? echo $string_lang['ORGANISME'][$langue]; ?>:</label>
			<?php SelectOrganisme($connexion,$centrale['org_ID'],$langue);?>
		</p>
	</fieldset>
	
	<fieldset  id="field1">
		<legend><? echo $string_lang['ADRESSE'][$langue];?> </legend>
		<p>
			<label for="z1" title="z1">Zone 1:</label>
			<input type="text" name="z1" id="z1" title="z1" value="<? echo $ad[ad_zone1];?>" size="30" onFocus="_select('z1');" onBlur="deselect('z1');"/>
		</p>
		<p>
			<label for="z2" title="z2">Zone2:</label>
			<input type="text" name="z2" id="z2" title="z2" value="<? echo $ad[ad_zone2];?>"size="30" onFocus="_select('z2');" onBlur="deselect('z2');"/>
		</p>
		<p>
			<label for="ville" title="ville">Ville:</label>
			<?php select_ville($connexion,$ad['ville_ID'],$langue,$onChange=""); // retourne $id_ville 
			?>
		</p>
		<p>
			<label for="zip" title="zip">code postal:</label>
			<input type="text" name="zip" id="zip" title="zip" value="<? echo $ad['zip'];?>" size="6" onFocus="_select('zip');" onBlur="deselect('zip');"/>
		</p>
		<p>
			<label for="latitude" title="latitude">Latitude:</label>
			<input type="text" name="latitude" id="latitude" title="latitude" value="<? echo $ad[ad_latitude];?>" size="15" onFocus="_select('latitude');" onBlur="deselect('latitude');"/>
			<? echo dec2min($ad[ad_latitude]);?>
		</p>
		<p>
			<label for="longitude" title="longitude">Longitude:</label>
			<input type="text" name="longitude" id="longitude" title="longitude" value="<? echo $ad[ad_longitude];?>" size="15" onFocus="_select('longitude');" onBlur="deselect('longitude');"/>
			<? echo dec2min($ad[ad_longitude]);?>
		</p>
		<input type="hidden" name="adresse_ID" value="<? echo $centraleID->adresse_ID;?>">
	</fieldset>
	
	<fieldset id="field1">
		<legend> Commentaires </legend>
		<p>
			<label for="rem" title="rem">Remarque:</label>
			<textarea name="rem" id="rem" rows="2" cols="50"></textarea>
		</p>
	</fieldset>
	
	<fieldset  id="field1" >
		<legend><? echo $string_lang['CONTACT'][$langue];?> </legend>
		<span>
		<?php
		//===============================  affichage des contacts  ==============================================
		$service_caracid=$_REQUEST[centraleID];
		$type=0;//nouveau
		$nature=9;//nature_contact = centrale
		$back="'../centrales/centrales_main.php'";//adresse de retour
		$variable="centraleID'";// variable de retour
		//if($_REQUEST['centraleID'])
			contact($service_caracid,$type,$nature,$contact_id,$back,$variable,$_REQUEST['centraleID'],'','../../../html/sagec3/');
		//=======================================================================================================
		?>
		</span>
	</fieldset>

	
	
	<input type="submit" name="ok" id="valider" value="Valider"/>
</div>
</form>
</body>
</html>
