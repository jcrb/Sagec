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
  * programme: 			evenement_new.php
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
if(!isset($_SESSION['member_ID'])) $backPathToRoot.'logout.php';
$evenementID = $_REQUEST['evenementID'];
if(isset($evenementID)){
	$titre_principal = "Evènements - Mise à jour";
	$sousmenu = "<a href='evenement_main.php'>main </a> > mise à jour";}
else {
	$titre_principal = "Evènements - Nouveau";
	$sousmenu = "<a href='evenement_main.php'>main </a> > nouveau";}
	
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."date.php");
require $backPathToRoot.'utilitaires/liste.php';

$date = date("Y-m-j");
$heure = date("H:i:s");
$null["---------- aucun ----------"]=0;

$requete = "SELECT*
 				FROM evenement
 				WHERE evenement_ID = '$evenementID'
 				LIMIT 1
				";
$resultat = ExecRequete($requete,$connexion);
$rub = mysql_fetch_array($resultat);
/* per défaut met la date du jour */
if($rub['evenement_date1']=='') $rub['evenement_date1'] = $date;
if($rub['evenement_heure1']=='') $rub['evenement_heure1'] = $heure;

/* évènement actif */
$requete = "SELECT evenement_ID FROM alerte";
$resultat = ExecRequete($requete,$connexion);
$rep = mysql_fetch_array($resultat);
$evenement_courant_ID = $rep['evenement_ID'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Evènements</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href= "<?php echo $backPathToRoot;?>images/sagec67.ico" />
	<script  type="text/javascript" src= "<?php echo $backPathToRoot;?>utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">
<form name="" action= "evenement_enregistre.php" method = "post">

<input type="hidden" name="id" value="<?php echo $evenementID;?>">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Evènement </legend> 
		<p>
			<label for="nom" title="nom">Nom:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo Security::db2str($rub[evenement_nom]);?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="date1" title="date1">Date de création:</label>
			<input type="text" name="date1" id="date1" title="date1" value="<? echo $rub[evenement_date1];?>" size="50" onFocus="_select('date1');" onBlur="deselect('date1');"/>
		</p>
		<p>
			<label for="heure1" title="heure1">Heure de création:</label>
			<input type="text" name="heure1" id="heure1" title="heure1" value="<? echo $rub[evenement_heure1];?>" size="50" onFocus="_select('heure1');" onBlur="deselect('heure1');"/>
		</p>
		
		<p>
			<label for="samu" title="samu">N° dossier SAMU:</label>
			<input type="text" name="samu" id="samu" title="samu" value="<? echo $rub[dossier_samu];?>" size="50" onFocus="_select('samu');" onBlur="deselect('samu');"/>
		</p>
		<p>
			<label for="sdis" title="sdis">N° dossier SDIS:</label>
			<input type="text" name="sdis" id="sdis" title="sdis" value="<? echo $rub[dossier_sdis];?>" size="50" onFocus="_select('sdis');" onBlur="deselect('sdis');"/>
		</p>
		<p>
			<label for="ppi" title="ppi">PPI associé:</label>
			<?php genere_select('ppi_id','ppi','ppi_ID','ppi_nom',$connexion,'',$null,'',$rub[ppi_ID],false); ?>
		</p>
		<p>
			<label for="rem" title="rem">Localisation:</label>
			<textarea name="localisation" id="rem" rows="3" cols="56"><?php echo Security::db2str($rub[localisation]);?></textarea>
		</p>
		<p>
			<label for="rem" title="rem">Remarque:</label>
			<textarea name="rem" id="rem" rows="3" cols="56"><?php echo Security::db2str($rub[comment]);?></textarea>
		</p>
		<p>
			<label for="transit" title="transit">Point de transit:</label>
			<input type="text" name="transit" id="transit" title="transit" value="<?php echo Security::db2str($rub['pt_transit']);?>" size="50" onFocus="_select('transit');" onBlur="deselect('transit');"/>
		</p
		<p>
			<label for="actif">évènement actif ? :</label>
			<!--<input type="checkbox" id="actif" name="actif" <?php if($rub['evenement_ID'] == $evenement_courant_ID) echo(' CHECKED')?> />-->
			<input type="checkbox" id="actif" name="actif" <?php if($rub['evenement_actif']) echo(' CHECKED')?> />
		</p>
		<p>
			<label for="chantier">créer un chantier:</label>
			<input type="checkbox" id="chantier" name="chantier" <?php if($way['chantier']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="pma">créer un PMA:</label>
			<input type="checkbox" id="pma" name="pma" <?php if($way['pma']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="pco">créer un PCO:</label>
			<input type="checkbox" id="pco" name="pco" <?php if($way['pco']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="cod">activation du COD:</label>
			<input type="checkbox" id="cod" name="cod" <?php if($rub['cod']=='o') echo(' CHECKED')?> />
		</p>
		
		<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	</fieldset>
	<!--
	/**	-----------------------------------------------------------------
	  *	Organisation du commandement
	  *	-----------------------------------------------------------------
	  */-->
	<fieldset id="field1">
		<legend>Organisation du commandement </legend>
		<p>
			<label for="dos">DOS:</label>
			<input type="text" name="dos" id="dos" title="dos" value="<? echo $rub[dos];?>" size="50" onFocus="_select('dos');" onBlur="deselect('dos');"/>
		</p>
		<p>
			<label for="cos">COS:</label>
			<input type="text" name="cos" id="cos" title="cos" value="<? echo $rub[cos];?>" size="50" onFocus="_select('cos');" onBlur="deselect('cos');"/>
		</p>
		<p>
			<label for="dsm">DSM:</label>
			<input type="text" name="dsm" id="dsm" title="dsm" value="<? echo $rub[dsm];?>" size="50" onFocus="_select('dsm');" onBlur="deselect('dsm');"/>
		</p>
	</fieldset id="field1">
	<!--
	/**	-----------------------------------------------------------------
	  *	Météorologie
	  *	-----------------------------------------------------------------
	  */-->
	<fieldset id="field1">
		<legend>Conditions météorologiques </legend>
		<p>
			<label for="dirvent">Direction du vent:</label>
			<input type="text" name="dirvent" id="dirvent" title="dirvent" value="<? echo $rub[dirvent];?>" size="50" onFocus="_select('dirvent');" onBlur="deselect('dirvent');"/>
		</p>
		<p>
			<label for="cos">vitesse du vent (m/s):</label>
			<input type="text" name="vitvent" id="vitvent" title="vitvent" value="<? echo $rub[vitvent];?>" size="50" onFocus="_select('vitvent');" onBlur="deselect('vitvent');"/>
		</p>
		<p>
			<label for="dsm">Nébulosité:</label>
			<input type="text" name="nebul" id="nebul" title="nebul" value="<? echo $rub[nebul];?>" size="50" onFocus="_select('nebul');" onBlur="deselect('nebul');"/>
		</p>
	</fieldset id="field1">
	<!--
	/**	---------------------------------------------------------------
	  *	Compléments
	  *	---------------------------------------------------------------
	  */-->
	<fieldset id="field1">
		<legend>Compléments </legend>
		<p>
			<label for="type" title="type">type:</label>
			<?php genere_select('typeID','incident_type', 'type_ID', 'type_nom',$connexion,'',$null,'', $rub['type'],false, '', '',''); ?>
			<!--  incident_type -->
		</p>
		<p>
			<label for="soustype" title="soustype">sous-type:</label>
			<?php genere_select('soustypeID','incident_soustype', 'stype_ID', 'stype_nom',$connexion,'',$null,'', $rub['soustype'],false, '', '',''); ?>
		</p>
		<p>
			<label for="categorie" title="categorie">categorie:</label>
			<?php genere_select('categorieID','incident_categorie', 'categorie_ID', 'categorie_nom',$connexion,'',$null,'', $rub['categorie'],false, '', '',''); ?>
		</p>
		<p>
			<label for="certitude" title="certitude">certitude:</label>
			<?php genere_select('certitudeID','incident_certitude', 'certitude_ID', 'certitude_nom',$connexion,'',$null,'', '',false, '', '',''); ?>
		</p>
		<p>
			<label for="gravite" title="gravite">gravité:</label>
			<?php genere_select('graviteID','incident_gravite', 'gravite_ID', 'gravite_nom',$connexion,'',$null,'', '',false, '', '',''); ?>
		</p>
		<p>
			<label for="niveau" title="niveau">niveau:</label>
			<?php genere_select('niveauID','incident_niveau', 'niveau_ID', 'niveau_nom',$connexion,'',$null,'', '',false, '', '',''); ?>
		</p>
		<p>
			<label for="severite" title="severite">severité:</label>
			<?php genere_select('severiteID','incident_severite', 'severite_ID', 'severite_nom',$connexion,'',$null,'', '',false, '', '',''); ?>
		</p>
		<p>
			<label for="phase" title="phase">phase:</label>
			<?php genere_select('phaseID','incident_phase', 'phase_ID', 'phase_nom',$connexion,'',$null,'', '',false, '', '',''); ?>
		</p>
		<p>
			<label for="status" title="status">status:</label>
			<?php genere_select('statusID','incident_status', 'status_ID', 'status_nom',$connexion,'',$null,'', '4',false, '', '',''); ?>
		</p>
	</fieldset>
</div>
<?php
?>

</form>
</body>
</html>