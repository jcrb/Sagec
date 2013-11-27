<?php
//----------------------------------------- SAGEC --------------------------------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC ----------------------------------------------
/**
 * Documents the class following adresse_ajout.php
 * description:		Ajout/ modification d'une adresse
 * @package Sagec
 * @version $Id: adresse_ajout.php 42 2008-03-09 22:45:00Z jcb $
 * @author JCB
 */		
//	date de création: 	05/08/2005
//	maj le:			05/08/2005
//----------------------------------------------------------------------------------------------

// Création / mise à jour d'un Hôpital
// appelé par Hopital_maj. Le Hop_ID est transmis par la variable $ID_hopital qui vaut 0
// pour un nouveau service
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
//$backPathToRoot="";
require_once $backPathToRoot.'utilitaires/globals_string_lang.php';
include_once($backPathToRoot."utilitairesHTML.php");
require_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."utilitaires/google/utilitaires_carto.php");

/**
*	recupère un enregistrement de la table adresse
*	et met les résultats dans le tableau $ad
*/
function get_une_adresse($adresse_ID,$ville_ou_commune='V',$classe='')
{
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	if($adresse_ID)
	{
		$requete = "SELECT * FROM adresse WHERE ad_ID = '$adresse_ID'";
		$resultat = ExecRequete($requete,$connexion);
		$ad = mysql_fetch_array($resultat);
		for($i=0;$i<count($ad);$i++)
			Security::db2str($ad[$i]);
		$ad['ad_zone1'] = Security::db2str($ad['ad_zone1']);
	}
	return $ad;
}

/**
*	affiche le dialogue de récupération d'une adresse
*	variables créés:
*	- z1
*	- z2
*	- id_ville
*	- zip
*	- longitude
*	- latitude
*/
function get_adresse($adresse_ID,$ville_ou_commune='V',$classe='')
{
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	if($adresse_ID)
	{
		$requete = "SELECT * FROM adresse WHERE ad_ID = '$adresse_ID'";
		$resultat = ExecRequete($requete,$connexion);
		$ad = mysql_fetch_array($resultat);
		
	}
	?>
	
	<fieldset  id="field1">
		<legend>Adresse </legend>
		<p>
			<label for="z1" title="z1">Zone 1:</label>
			<input type="text" name="z1" id="z1" title="z1" value="<? echo Security::db2str($ad[ad_zone1]);?>" size="30" onFocus="_select('z1');" onBlur="deselect('z1');"/>
		</p>
		<p>
			<label for="z2" title="z2">Zone2:</label>
			<input type="text" name="z2" id="z2" title="z2" value="<? echo Security::db2str($ad[ad_zone2]);?>"size="30" onFocus="_select('z2');" onBlur="deselect('z2');"/>
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
	<!--
	<fieldset>
		<legend class="time">  Adresse  </legend>
		<table cellspacing="1" CELLPADDING="0" class="time_v">
		<tr>
			<td>zone 1</td>
			<td><input type="text" name="z1" value="<? echo $ad[ad_zone1];?>" size="30"></td>
			<td>zone 2 </td>
			<td><input type="text" name="z2" value="<? echo $ad[ad_zone2];?>"size="30"></td>
			<td>ville </td>
	</fieldset>
	-->
	<?php
	/*
			print("<td>");
				select_ville($connexion,$ad['ville_ID'],$langue,$onChange="");// retourne $id_ville
			print("</td>");
			print("<td>zip </td>");
			print("<td><input type=\"text\" name=\"zip\" value=\"$ad[zip]\"size=\"6\"></td>");
			print("<td>");
				print("<input type=\"button\" name=\"nouvelle\" value=\"nouvelle\" onclick=\"window.location='gis/gis_frameset.php';\">");
			print("</td>");
		print("</tr>");
		print("<tr>");
			print("<td>latitude (deg.dec) </td>");
			print("<td><input type=\"text\" name=\"latitude\" value=\"$ad[ad_latitude]\"size=\"15\"></td>");
			print("<td>longitude (deg.dec) </td>");
			print("<td><input type=\"text\" name=\"longitude\" value=\"$ad[ad_longitude]\"size=\"15\"></td>");
		print("</tr>");
		?>
		</table>
	</fieldset>
	<?php
	*/
}

/**
*	récupère et enregistre une adresse
*/
function recupere_adresse()
{
	$adresse = $_REQUEST['adresseID'];
	$z1 = Security::str2db($_REQUEST['z1']);
	$z2 = Security::str2db($_REQUEST['z2']);
	$zip = Security::str2db($_REQUEST['zip']);
	$lat = Security::str2db($_REQUEST['latitude']);
	$lng = Security::str2db($_REQUEST['longitude']);
	$ad_id = enregistre_adresse($adresse,$z1,$z2,$_REQUEST['id_ville'],$zip,'V',$lat,$lng);
	return $ad_id;
}

function enregistre_adresse($adresse_ID,$z1,$z2,$ville_id,$zip='',$ville_ou_commune='V',$latitude,$longitude)
{
	if(!$ville_id) return 0;
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

	if($adresse_ID)
	{
		$requete = "UPDATE adresse SET
					ad_zone1 =  '$z1',
					ad_zone2 =  '$z2',
					ad_latitude = '$latitude',
					ad_longitude = '$longitude',
					";
			if($ville_ou_commune=='V')
				$requete.=" ville_ID =  '$ville_id'";
			else
				$requete.=" com_ID = '$ville_id'";
			$requete .= " ,zip = '$zip'";
			$requete.=" WHERE ad_ID = '$adresse_ID'";
			$resultat = ExecRequete($requete,$connexion);
	}
	else
	{
		$requete = "INSERT INTO adresse VALUES(
					'',
					 '$z1',
					 '$z2',";
					 if($ville_ou_commune=='V')
							$requete.="'','$ville_id',";
					 else
						  $requete.="'$ville_id','',";
					 $requete.="'$zip',";
					 $requete.="'$longitude','$latitude')";
		$resultat = ExecRequete($requete,$connexion);
		$adresse_ID = mysql_insert_id();
	}
	//print($requete);
	return $adresse_ID;
}

/**
* Récupère les champs adresse et contact de la table organisme
* pour les injecter dans les tables adresse et contact
*/
function maj_organisme($type_organisme)
{
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	$requete = "SELECT * FROM organisme WHERE organisme_type_ID = '$type_organisme'";
	$resultat = ExecRequete($requete,$connexion);
	
	while($rub=mysql_fetch_array($resultat))
	{
		if($rub[contact_ID]==0)
		{
			if($rub[tel1] != ""){
				$requete = "INSERT INTO `pma`.`contact` (`contact_ID`,`type_contact_ID`,`nature_contact_ID`,`identifiant_contact`,`pays_ID`,`confidentialite_ID`,`reseau_ID`,`valeur`,`contact_lieu` ,`contact_nom`)
								VALUES (NULL , '1', '2', '$rub[org_ID]', '1', '1', '0', '$rub[tel1]', '2', ''); ";
				ExecRequete($requete,$connexion);
				print($requete)."<br>";
			}
			if($rub[tel2] != ""){
				$requete = "INSERT INTO `pma`.`contact` (`contact_ID`,`type_contact_ID`,`nature_contact_ID`,`identifiant_contact`,`pays_ID`,`confidentialite_ID`,`reseau_ID`,`valeur`,`contact_lieu` ,`contact_nom`)
								VALUES (NULL , '1', '2', '$rub[org_ID]', '1', '1', '0', '$rub[tel2]', '2', ''); ";
				ExecRequete($requete,$connexion);
				print($requete)."<br>";
			}
			if($rub[tel3]!=""){
				$requete = "INSERT INTO `pma`.`contact` (`contact_ID`,`type_contact_ID`,`nature_contact_ID`,`identifiant_contact`,`pays_ID`,`confidentialite_ID`,`reseau_ID`,`valeur`,`contact_lieu` ,`contact_nom`)
								VALUES (NULL , '1', '2', '$rub[org_ID]', '1', '1', '0', '$rub[tel3]', '2', ''); ";
				ExecRequete($requete,$connexion);
				print($requete)."<br>";
			}
			if($rub[fax] != ""){
				$requete = "INSERT INTO `pma`.`contact` (`contact_ID`,`type_contact_ID`,`nature_contact_ID`,`identifiant_contact`,`pays_ID`,`confidentialite_ID`,`reseau_ID`,`valeur`,`contact_lieu` ,`contact_nom`)
								VALUES (NULL , '7', '2', '$rub[org_ID]', '1', '1', '0', '$rub[fax]', '2', ''); ";
				ExecRequete($requete,$connexion);
				print($requete)."<br>";
			}
			if($rub[mail1]!=""){
				$requete = "INSERT INTO `pma`.`contact` (`contact_ID`,`type_contact_ID`,`nature_contact_ID`,`identifiant_contact`,`pays_ID`,`confidentialite_ID`,`reseau_ID`,`valeur`,`contact_lieu` ,`contact_nom`)
								VALUES (NULL , '5', '2', '$rub[org_ID]', '1', '1', '0', '$rub[mail1]', '2', ''); ";
				ExecRequete($requete,$connexion);
				print($requete)."<br>";
			}
			if($rub[mail2] != ""){
				$requete = "INSERT INTO `pma`.`contact` (`contact_ID`,`type_contact_ID`,`nature_contact_ID`,`identifiant_contact`,`pays_ID`,`confidentialite_ID`,`reseau_ID`,`valeur`,`contact_lieu` ,`contact_nom`)
								VALUES (NULL , '5', '2', '$rub[org_ID]', '1', '1', '0', '$rub[mail2]', '2', ''); ";
				ExecRequete($requete,$connexion);
				print($requete)."<br>";
			}
			/** pour éviter de la faire deux fois */
			$requete="UPDATE organisme SET contact_ID = 1 WHERE org_ID = '$rub[org_ID]'";
			ExecRequete($requete,$connexion);
		}
		if($rub[adresse_ID]==0)
		{
			$ad_zone1 = Security::str2db($rub[ad_zone1]);
			$ad_zone2 = Security::str2db($rub[ad_zone2]);
			$requete = "INSERT INTO `pma`.`adresse` (`ad_ID`, `ad_zone1`, `ad_zone2`, `com_ID`, `ville_ID`, `zip`, `ad_longitude`, `ad_latitude`) 
							VALUES (NULL,'$ad_zone1','$ad_zone2','', '$rub[ville_ID]', '','$rub[longitude]','$rub[latitude]')";
			ExecRequete($requete,$connexion);
			$adresse_ID = mysql_insert_id();
			$requete = "UPDATE organisme SET adresse_ID = '$adresse_ID' WHERE org_ID = '$rub[org_ID]' ";
			ExecRequete($requete,$connexion);
			print($requete)."<br>";
		}
	}
}
?>
