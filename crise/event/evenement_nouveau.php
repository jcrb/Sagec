<?php
/**
  *	evenement_nouveau.php
  *
  *----------------------------------------- SAGEC ------------------------------
  *	This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
  *	SAGEC67 is free software; you can redistribute it and/or modify
  *	it under the terms of the GNU General Public License as published by
  *	the Free Software Foundation; either version 2 of the License, or
  *	at your option) any later version.
  *	SAGEC67 is distributed in the hope that it will be useful,
  *	but WITHOUT ANY WARRANTY; without even the implied warranty of
  *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  *	GNU General Public License for more details.
  *	You should have received a copy of the GNU General Public License
  *	along with SAGEC67; if not, write to the Free Software
  *	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  *----------------------------------------- SAGEC -----------------------------
  *	programme: 			evenement_nouveau.php
  *	date de création: 	12/11/2004
  *	@author:				jcb
  *	description:		Création d'un nouvel évènement. Archivage automatique du
  *							précédent
  *	@version:			1.2 - $Id: evenement_nouveau.php 23 2007-09-21 03:50:41Z jcb $
  *	maj le:				14/10/2010
  *	@package				Sagec
  *--------------------------------------------------------------------------------
  */
	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
	$langue = $_SESSION['langue'];
	include_once("top.php");
	include_once("menu.php");
	
	$backPathToRoot = "../../";
	require $backPathToRoot.'utilitaires/liste.php';;
	require $backPathToRoot.'utilitaires/globals_string_lang.php';
	require $backPathToRoot.'dbConnection.php';
	
 /**
	*	@TODO Sauvegarde de l'évènement précédent
	*/
	//include_once($backPathToRoot."administrateur/sauvegarde_TXT.php");
	if($_SESSION['evenement'] > 1)
	{
		//sauvegarde_txt();
	}
	
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Nouvel evenement</title>
	<link rel="stylesheet" href="../div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">
<form name="event" action= "evenement_enregistre.php" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend><? echo $string_lang['EVENEMENT'][$langue];?> </legend>
		<p>
			<label for="nom" title="nom">Evènement:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo $organisme->org_nom;?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
		<label for="date" title="date">Date:</label>
		<input TYPE="text" VALUE="<?echo date("Y-m-j");?>" NAME="date" SIZE="10" id="date">
		<input type="button" class="bouton" onClick="window.open('../../calendrier/mycalendar.php?form=event&elem=date','Calendrier','width=200,height=300')">
		</p>
		
		<p>
			<label for="heure" title="heure">Heure:</label>
			<input type="text" name="heure" id="heure" title="heure" value="<? echo date('H:i:s');?>" size="10" onFocus="_select('heure');" onBlur="deselect('heure');"/>
		</p>
		<p>
			<label for="heure" title="heure">Adresse:</label>
			<input type="text" name="heure" id="heure" title="heure" value="<? echo $organisme->org_nom_complet;?>" size="20" onFocus="_select('heure');" onBlur="deselect('heure');"/>
		</p>
		<p>
			<label for="heure" title="heure">Ville:</label>
			<input type="text" name="heure" id="heure" title="heure" value="<? echo $organisme->org_nom_complet;?>" size="20" onFocus="_select('heure');" onBlur="deselect('heure');"/>
		</p>
		<p>
			<label for="heure" title="heure">Latitude:</label>
			<input type="text" name="heure" id="heure" title="heure" value="<? echo $organisme->org_nom_complet;?>" size="10" onFocus="_select('heure');" onBlur="deselect('heure');"/>
		</p>
		<p>
			<label for="heure" title="heure">longitude:</label>
			<input type="text" name="heure" id="heure" title="heure" value="<? echo $organisme->org_nom_complet;?>" size="10" onFocus="_select('heure');" onBlur="deselect('heure');"/>
		</p>
		<p>
			<label for="heure" title="heure">No dossier SAMU:</label>
			<input type="text" name="heure" id="heure" title="heure" value="<? echo $organisme->org_nom_complet;?>" size="10" onFocus="_select('heure');" onBlur="deselect('heure');"/>
		</p>
		<p>
			<label for="heure" title="heure">No dosier SDIS:</label>
			<input type="text" name="heure" id="heure" title="heure" value="<? echo $organisme->org_nom_complet;?>" size="10" onFocus="_select('heure');" onBlur="deselect('heure');"/>
		</p>
		<p>
			<label for="heure" title="heure">PPI Associé:</label>
			<? $null["aucun"]=0;genere_select("ppi_id", "ppi","ppi_ID","ppi_nom",$connexion,'',$null,'','',false);?>
		</p>

		
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
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
		<legend> Case à cocher </legend>
		<p>
			<label for="ferme">évènement actif :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php echo(' CHECKED')?> />
		</p>
		<p>
			<label for="ferme">Créer un chantier :</label>
			<input type="checkbox" id="ferme" name="ferme"  />
		</p>
		<p>
			<label for="ferme">Créer un PCO :</label>
			<input type="checkbox" id="ferme" name="ferme"  />
		</p>
		<p>
			<label for="ferme">Créer un PMA :</label>
			<input type="checkbox" id="ferme" name="ferme"  />
		</p>
	</fieldset>
	
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
</div>

</form>
</body>
</html>


