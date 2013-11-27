<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//----------------------------------------- SAGEC --------------------------------
//
/**	programme: 			ppi_nouveau.php
*	date de création: 	12/11/2004
*	@author:					jcb
*	description:			Creation d'un nouveau PPI
*	@version:				1.2 - $Id: evenement_nouveau.php 23 2007-09-21 03:50:41Z jcb $
*	maj le:					14/10/2004
*	@package					Sagec
*/
//--------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
$backPathToRoot = "../";
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."utilitairesHTML.php");

$ppi_id = $_REQUEST['id'];

if($_REQUEST['BtnSubmit'] == 'Valider')
{
	$nom = Security::str2db($_REQUEST['nom']);
	$activite = Security::str2db($_REQUEST['activite']);
	$adresse = Security::str2db($_REQUEST['adresse']);
	$maj = Security::str2db($_REQUEST['maj']);
	$lat = Security::str2db($_REQUEST['lat']);
	$lng = Security::str2db($_REQUEST['lng']);
	$etat = Security::str2db($_REQUEST['etat']);
	$station_mto = Security::str2db($_REQUEST['mtoID']);
	$partage = Security::str2db($_REQUEST['partage']);
	
	if($ppi_id)	// maj 
	{
		$requete = "UPDATE ppi SET 
						ppi_nom = '$nom',
						ppi_activite = '$activite',
						adresse_ID = '$adresse',
						ppi_date = '$maj',
						center_lat = '$lat',
						center_lng = '$lng',
						ppi_actif = '$etat',
						ppi_dossier = '',
						ppi_station_mto = '$station_mto',
						ppi_partage = '$partage'
						WHERE ppi_ID = '$ppi_id'";
		ExecRequete($requete,$connexion);
	}
	else
	{
		$requete = "INSERT INTO ppi VALUES('','$nom','$activite','$maj','$adresse','$lat','$lng','$etat','','$station_mto','$partage')";
		ExecRequete($requete,$connexion);
		$ppi_id = mysql_insert_id();
	}
} 

if($ppi_id)	// c'est une mise à jour
{
	$requete = "SELECT * FROM ppi WHERE ppi_ID = '$ppi_id'";
	$resultat = ExecRequete($requete,$connexion);
	$rep=mysql_fetch_array($resultat);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>formulaire PPI</title>
	<meta http-equiv="content-type" content=""text/htm; charset=ISO-8859-1"  >
	<link href="../../css/formstyle.css" rel="stylesheet" type="text/css" />
</head>

<body onload="document.getElementById('nom').focus()">
	<form id="catalogue" action="ppi_nouveau.php" method="post">
	<input type="hidden" name="id" value="<?php echo($ppi_id); ?>");
	
	<div id="formtitle">Enregistrer un PPI</div>
	<div id="content">
	<fieldset id="coordonnees">
		<legend>PPI</legend>
		<p>
			<label for="nom" title="Intitulé du PPI">Nom :</label>
			<input type="text" id="nom" name="nom" title="Intitulé du PPI" value="<?php echo(Security::db2str($rep[ppi_nom])); ?>"/>
			<span class="exemple">ex : PPI Reichstett</span>
		</p>
		<p>
			<label for="activite">Activité :</label>
			<input type="text" id="activite" name="activite" size="50" value="<?php echo(Security::db2str($rep[ppi_activite]));?>"/>
		</p>
		<p>
			<label for="adresse">Adresse :</label>
			<input type="text" id="adresse" name="adresse" value="<?php echo($rep[adresse_ID]);?>"/>
			<a href="#" class="help" title="Notez bien votre adresse complète!"></a>
		</p>
		<p>
			<label for="org">Organisme :</label>
			<?php 
				$type = 23;// organisme type industrie 
				SelectOrgParType($connexion,$rep['org_ID'],$langue,$type);/* orgByType */ ?>
		</p>
		<p>
			<label for="maj">Date de mise à jour :</label>
			<input type="text" id="maj" name="maj" size="10" value="<?php echo($rep[ppi_date]);?>" />
		</p>
	</fieldset>
	<br />
	
	<fieldset id="coordonnees">
		<legend>Localisation principale</legend>
		<p>
			<label for="lat">Latitude :</label>
			<input type="text" id="lat" name="lat" size="20" value="<?php echo($rep[center_lat]);?>"/>
			<span class="exemple">degrés décimaux</span>
		</p>
		<p>
			<label for="lng">Longitude :</label>
			<input type="text" id="lng" name="lng" size="20" value="<?php echo($rep[center_lng]);?>" />
		</p>
		<?php 
			/**
			  *	Cherche la station météo la plus proche
			  *	ne fonctionne que si le PPI est géolocalisé
			  *	Utlise une distance euclidienne simplifiée
			  */
			if($rep[center_lat] && $rep[center_lng])
			{
				$a = $rep[center_lat];
				$b = $rep[center_lng];
				$requete = "SELECT *,(station_lat - $a)*(station_lat - $a)+(station_lng - $b)*(station_lng - $b) as d
								FROM station_mto
								WHERE station_lat > 0
								ORDER BY d ASC
								LIMIT 1
								";
				$resultat2 = ExecRequete($requete,$connexion);
				$rub2= mysql_fetch_array($resultat2);
				?>
					<p>
						<label>Station météo: </label>
						<input type="text" value="<?php echo $rub2['station_name'];?>"/>
						<a href="ppi_meteo.php?station=<?php echo $rub2[station_code];?>&ppi_ID=<?php echo $ppi_id;?>"> voir</a>
					</p>
				<?php
			}
		?>
		<input type="hidden" name="mtoID" VALUE="<?php echo $rep['station_code'];?>">
	</fieldset>
	<br />
	
	<fieldset id="typecat">
		<legend>Etat</legend>		
		<p><span class="exemple">Sélectionnez l'état du PPI :</span><br />
			<input type="radio" name="etat" id="actif" value="o" <?php if($rep[ppi_actif]=='o') echo('checked');?> /> Actif<br />
			<input type="radio" name="etat" id="inactif" value="n" <?php if($rep[ppi_actif]=='n') echo('checked');?>/> Inactif<br />		
		</p>
		<p>
			<label for="partage">Partager :</label>
			<input type="checkbox" id="partage" name="partage" <?php if($rep['ppi_partage']=='o') echo(' CHECKED')?> />
		</p>
	</fieldset>
	
	</div>
	<div id="formfooter">
		<p>			
			<input type="submit" name="BtnSubmit" id="valid" value="Valider" />
			<input type="reset" name="BtnClear" id="annul" value="Annuler" />
		</p>
	</div>
	</form>
</body>

</html>
