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
  * programme: 			manif_new.php
  * date de création: 	12/06/2011
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
$titre_principal = "Manifestations sportives";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");
require($backPathToRoot."utilitairesHTML.php");

/** identifiant si maj */
$manifID = $_REQUEST['manifID'];
if(isset($manifID))
{
	$requete = "SELECT * FROM manifestation WHERE manif_ID = '$manifID'";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
	$itr = $rep['manif_itr'];
	$dps = $rep['manif_dispositif'];
	$nbs = $rep['manif_secouristes'];
}
else
{
	/** indice toral de risques */
	$itr = $_REQUEST['itr'];
	/** ratio intervenants / secouristes */
	$ris = $_REQUEST['ris'];
	/** dispositif de secours */
	$dps = $_REQUEST['dps'];
	/** nombre de secouristes */
	$nbs = $_REQUEST['sec'];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Manifestations sportives</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	<script  type="text/javascript">
		function affichage_popup(nom_de_la_page, nom_interne_de_la_fenetre)
		{
			window.open (nom_de_la_page, nom_interne_de_la_fenetre, config='height=200, width=600, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no')
		}
	</script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="evenement" action= "manif_enregistre.php" method = "get">

<input type="hidden" name="manifID" value="<?php echo $manifID;?>">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Evènement</legend>
		<p>
			<label for="id" title="id">N°:</label>
			<input type="text" name="id" id="id" title="id" value="<? echo Security::db2str($rep['manif_ID']);?>" size="10"/>
		</p>
		<p>
			<label for="nom" title="nom">Nom:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo Security::db2str($rep['manif_nom']);?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		
		<p>
			<label for="nom" title="nom">Commune:</label>
			<?php
				$dep="'67','68'";
				$commune = $rep['manif_ville_ID'];
				select_ville_dep($connexion,$commune,$dep,"")
			?>
		</p>
		
		<p>
			<label for="org" title="org">Organisateur:</label>
			<input type="text" name="org" id="org" title="org" value="<? echo Security::db2str($rep['manif_org']);?>" size="50" onFocus="_select('org');" onBlur="deselect('org');"/>
		</p>
		
		<p>
			<label for="desc" title="desc">Description de l'évènement</label>
			<textarea name="desc" id="desc" rows="2" cols="57"><? echo Security::db2str($rep['manif_description']);?></textarea>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Calendrier </legend>
		
		<label for="date1" title="date1">Date de début:</label>
		<input TYPE="text" VALUE="<? echo usdate2fdate($rep['manif_debut']);?>" NAME="date1" SIZE="10" id="date1">
		<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=evenement&elem=date1','Calendrier','width=200,height=280')">
		<br>
		<label for="date2" title="date1">Date de fin:</label>
		<input TYPE="text" VALUE="<? echo usdate2fdate($rep['manif_fin']);?>" NAME="date2" SIZE="10" id="date2">
		<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=evenement&elem=date2','Calendrier','width=200,height=280')">
	</fieldset>
	
	<fieldset id="field1">
		<legend>Evaluation du risque</legend>
		<p>
			<label for="nombre" title="nombre">Nombre de participants:</label>
			<input type="text" name="nombre" id="nombre" title="nombre" value="<? echo $rep[manif_nb];?>" size="50" onFocus="_select('nombre');" onBlur="deselect('nombre');"/>
		</p>
		
		<p>
			<label for="risk" title="risk">Niveau de risque</label>
			<textarea name="risk" id="risk" rows="2" cols="80" ReadOnly>
			<?php
				echo "indice total de risque: ".$itr."\n";
				echo "nature du dispositif  : ".$dps."\n";
				echo "nombre de secouristes : ".$nbs;
			?>
			</textarea>
		</p>
		<table>
			<tr>
				<th>Risque</th>
				<th>Public<a href="javascript:affichage_popup('help_public.php','popup_1');"><img src="../images/quid.png" alt="help" border="0" style="vertical-align:middle"></a></th>
				<th>Environnement<a href="javascript:affichage_popup('help_activite.php','popup_2');"><img src="../images/quid.png" alt="help" border="0" style="vertical-align:middle"></a></th>
				<th>Délais secours<a href="javascript:affichage_popup('help_secours.php','popup_3');"><img src="../images/quid.png" alt="help" border="0" style="vertical-align:middle"></a></th>
			</tr>
			<tr>
				<td>Faible</td>
				<td><input type="radio" name="p2" id="p2" title="faible risque" value="1" <?php if($rep['manif_risk_public']=='1') echo ' CHECKED';?> /></td>
				<td><input type="radio" name="e1" id="e1" title="faible risque" value="1" <?php if($rep['manif_risk_environ']=='1') echo ' CHECKED';?>/></td>
				<td><input type="radio" name="e2" id="e2" title="faible risque" value="1" <?php if($rep['manif_risk_secours']=='1') echo ' CHECKED';?>/></td>
			</tr>
			<tr>
				<td>Modéré</td>
				<td><input type="radio" name="p2" id="p2" title="risque modéré" value="2" <?php if($rep['manif_risk_public']=='2') echo ' CHECKED';?>/></td>
				<td><input type="radio" name="e1" id="e1" title="risque modéré" value="2" <?php if($rep['manif_risk_environ']=='2') echo ' CHECKED';?>/></td>
				<td><input type="radio" name="e2" id="e2" title="risque modéré" value="2" <?php if($rep['manif_risk_secours']=='2') echo ' CHECKED';?>/></td>
			</tr>
			<tr>
				<td>Moyen</td>
				<td><input type="radio" name="p2" id="p2" title="risque moyen" value="3" <?php if($rep['manif_risk_public']=='3') echo ' CHECKED';?>/></td>
				<td><input type="radio" name="e1" id="e1" title="risque moyen" value="3" <?php if($rep['manif_risk_environ']=='3') echo ' CHECKED';?>/></td>
				<td><input type="radio" name="e2" id="e2" title="risque moyen" value="3" <?php if($rep['manif_risk_secours']=='3') echo ' CHECKED';?>/></td>
			</tr>
			<tr>
				<td>Elevé</td>
				<td><input type="radio" name="p2" id="p2" title="risque élevé" value="4" <?php if($rep['manif_risk_public']=='4') echo ' CHECKED';?>/></td>
				<td><input type="radio" name="e1" id="e1" title="risque élevé" value="4" <?php if($rep['manif_risk_environ']=='4') echo ' CHECKED';?>/></td>
				<td><input type="radio" name="e2" id="e2" title="risque élevé" value="4" <?php if($rep['manif_risk_secours']=='4') echo ' CHECKED';?>/></td>
			</tr>
		</table>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Caractéristiques </legend>
		<p>
			<label for="postes">Postes de secours :</label>
			<input type="checkbox" id="postes" name="postes" value="1" <?php if($rep['manif_ps']=='1') echo(' CHECKED')?> />
		</p>
		
		<p>
			<label for="moyens" title="moyens">Moyens sur place</label>
			<textarea name="moyens" id="moyens" rows="2" cols="50"><?php echo Security::db2str($rep['manif_moyens']);?></textarea>
		</p>
		
		<p>
			<label for="contact" title="contact">Contacts responsables</label>
			<textarea name="contact" id="contact" rows="2" cols="50"><?php echo Security::db2str($rep['manif_contacts']);?></textarea>
		</p>
		<p>
			<label for="valide" title="valide">Validation SAMU</label>
			<input type="radio" name="valide" id="oui" title="valide" value="1" <?php if($rep['manif_valide']=='1') echo ' CHECKED';?>/>oui
			<input type="radio" name="valide" id="non" title="valide" value="0" <?php if($rep['manif_valide']=='0') echo ' CHECKED';?>/>non
			<input type="radio" name="valide" id="progress" title="valide" value="2" <?php if($rep['manif_valide']=='2') echo ' CHECKED';?>/>en cours
		</p>
		<p>
			<label for="devenir">Devenir:</label>
			<select name="devenir" value="1">
				<option label="devenir" value="0" <?php if($rep['manif_devenir']=='0') echo ' selected';?> >----</option>
				<option label="devenir" value="1"  <?php if($rep['manif_devenir']=='1') echo ' selected';?> >Annulé</option>
			</select>
		</p>
		
		<p>
			<label for="validepar">Validé par:</label> 
			<select name="validepar" value="1">
				<option label="validepar" value="0" <?php if($rep['manif_validepar']=='0') echo 'selected';?> >----</option>
				<option label="validepar" value="1" <?php if($rep['manif_validepar']=='1') echo 'selected';?> >Dr Anne WEISS</option>
				<option label="validepar" value="2" <?php if($rep['manif_validepar']=='2') echo 'selected';?> >Dr Leslie DUSSAU</option>
			</select>
			<a href="manif_lettre.php?id=<?php echo $rep['manif_ID'];?>">Imprimer</a>
		</p>
		
	</fieldset>
	
	<!--
	<fieldset id="field1">
		<legend> Bouton radio </legend>
		<p>
			<label for="type" title="type">type :</label>
			<input type="radio" name="type" id="type" title="type" value="1" onFocus="_select('type');" onBlur="deselect('type');"/> Service
			<input type="radio" name="type" id="type" title="type" value="2" onFocus="_select('type');" onBlur="deselect('type');"/> UF
		</p>
	</fieldset>
	-->
	
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
</div>

<?php
?>

</form>
</body>
</html>