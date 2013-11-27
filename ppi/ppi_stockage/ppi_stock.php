<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
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
//
//----------------------------------------- SAGEC ---------------------------------------------//
//
//	programme: 				ppi_stock.php
//	date de création: 	01/11/2008
//	auteur:					jcb
//	description:			saisie d'un stockage industriel
//	version:					01/11/2008
//
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."utilitaires/liste.php");
include_once($backPathToRoot."login/init_security.php");
$origin = array('--?--'=>'0');
$stock_id = $_REQUEST['id'];

//$stock_id = 4;

/**
*	Le bouton Valider a été cliqué
*/
if($_REQUEST['BtnSubmit'] == 'Valider')
{
	$nom = Security::esc2Db($_REQUEST['nom']);
	$type_stockage = Security::esc2Db($_REQUEST['type_stockage']);
	$produit = Security::esc2Db($_REQUEST['produit']);
	$nature = Security::esc2Db($_REQUEST['nature']);
	$qte = Security::esc2Db($_REQUEST['qte']);
	$unite = Security::esc2Db($_REQUEST['unite']);
	$lat = Security::esc2Db($_REQUEST['lat']);
	$lng = Security::esc2Db($_REQUEST['lng']);
	$r1 = Security::esc2Db($_REQUEST['r1']);
	$r2 = Security::esc2Db($_REQUEST['r2']);
	$r3 = Security::esc2Db($_REQUEST['r3']);
	$org  = Security::esc2Db($_REQUEST['org']);
	$ppi  = Security::esc2Db($_REQUEST['ppi']);
	$haut  = Security::esc2Db($_REQUEST['hauteur']);
	$diam  = Security::esc2Db($_REQUEST['diametre']);
	
	if($stock_id)	// maj 
	{
		$requete = "UPDATE stockage_industriel SET 
						stocki_nom = '$nom',
						stocki_type = '$type_stockage',
						produit_ID = '$produit',
						stocki_qte = '$qte',
						stocki_qte_unite = '$unite',
						stocki_lat = '$lat',
						stocki_lng = '$lng',
						stocki_rayon1 = '$r1',
						stocki_rayon2 = '$r2',
						stocki_rayon3 = '$r3',
						org_ID = '$org',
						ppi_ID = '$ppi',
						stocki_nature = '$nature',
						stocki_hauteur = '$haut',
						stocki_diametre = '$diam'
						WHERE stocki_ID = '$stock_id'";
		ExecRequete($requete,$connexion);
	}
	else
	{
		$requete = "INSERT INTO stockage_industriel 
		VALUES('','$nom','$type_stockage','$produit','$qte','$unite','$lat','$lng','$r1','$r2','$r3','$org','$ppi','$nature','$haut','$diam')";
		ExecRequete($requete,$connexion);
		$stock_id = mysql_insert_id();
	}
	//print($requete);
}
else
/**
*	Le bouton dupliquer a été cliqué
*/
if($_REQUEST['BtnSubmit'] == 'Dupliquer')
{
	$nom = Security::esc2Db($_REQUEST['nom']);
	$type_stockage = Security::esc2Db($_REQUEST['type_stockage']);
	$produit = Security::esc2Db($_REQUEST['produit']);
	$nature = Security::esc2Db($_REQUEST['nature']);
	$qte = Security::esc2Db($_REQUEST['qte']);
	$unite = Security::esc2Db($_REQUEST['unite']);
	$lat = Security::esc2Db($_REQUEST['lat']);
	$lng = Security::esc2Db($_REQUEST['lng']);
	$r1 = Security::esc2Db($_REQUEST['r1']);
	$r2 = Security::esc2Db($_REQUEST['r2']);
	$r3 = Security::esc2Db($_REQUEST['r3']);
	$org  = Security::esc2Db($_REQUEST['org']);
	$ppi  = Security::esc2Db($_REQUEST['ppi']);
	$haut  = Security::esc2Db($_REQUEST['hauteur']);
	$diam  = Security::esc2Db($_REQUEST['diametre']);
	
	$requete = "INSERT INTO stockage_industriel 
		VALUES('','$nom','$type_stockage','$produit','$qte','$unite','$lat','$lng','$r1','$r2','$r3','$org','$ppi','$nature','$haut','$diam')";
		ExecRequete($requete,$connexion);
		$stock_id = mysql_insert_id();
}

if($stock_id)	// c'est une mise à jour
{
	$requete = "SELECT * FROM stockage_industriel WHERE stocki_ID = '$stock_id'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>formulaire stokages industriels</title>
	<meta http-equiv="content-type" content=""text/htm; charset=ISO-8859-1"  >
	<link href="./../../../css/formstyle.css" rel="stylesheet" type="text/css" />
</head>

<body onload="document.getElementById('nom').focus()">
<form id="catalogue" action="ppi_stock.php" method="post">
<input type="hidden" name="id" value="<?php echo($stock_id); ?>");

<div id="formtitle">Enregistrer/Modifier un stockage industriel</div>
	<div id="content">
	<fieldset id="coordonnees">
<p><label for="nom">nom du stockage </label><input id="nom" type="text" name="nom" value="<?php echo($rub[stocki_nom]);?>"></p>
<p><label for="type">type de stockage </label>
	<? genere_select("type_stockage","stockage_conteneur", "stockage_conteneur_ID","stockage_conteneur_nom",$connexion,'',$origin,'',$rub[stocki_type]); ?>
	hauteur (m): <input type="text" name="hauteur" id="h" value="<?php echo($rub[stocki_hauteur]);?>" maxlength="5" size="5">
	diamètre(m): <input type="text" name="diametre" id="d" value="<?php echo($rub[stocki_diametre]);?>" maxlength="5" size="5">
	</p>
<p><label for="type">nom du produit </label><? genere_select("produit","produitsChimiques", "chem_ID","chem_nom",$connexion," ORDER BY chem_nom ",$origin,'',$rub[produit_ID]); ?></p>
<p><label for="type">nature du produit </label>
	<? genere_select("nature","produit_nature", "prod_nature_ID","prod_nature_nom",$connexion,'',$origin,'',$rub[stocki_nature]); ?></p>
<p><label for="type">
	quantité stockée </label><input type="text" name="qte" value="<?php echo($rub[stocki_qte]);?>">
	unités <? genere_select("unite","med_unites", "unite_ID","unite_nom",$connexion,'',$origin,'',$rub[stocki_qte_unite]); ?>
</p>
<p><label for="type">latitude du stockage </label><input type="text" name="lat" value="<?php echo($rub[stocki_lat]);?>"></p>
<p><label for="type">longitude du stockage </label><input type="text" name="lng" value="<?php echo($rub[stocki_lng]);?>"></p>
<p><label for="type">rayon de danger (mortel) </label><input type="text" name="r1" value="<?php echo($rub[stocki_rayon1]);?>"></p>
<p><label for="type">rayon de danger (blessures) </label><input type="text" name="r2" value="<?php echo($rub[stocki_rayon2]);?>"></p>
<p><label for="type">rayon de danger </label><input type="text" name="r3" value="<?php echo($rub[stocki_rayon3]);?>"></p>
<p><label for="type">organisme </label><? genere_select("org","organisme", "org_ID","org_nom",$connexion,'',$origin,'',$rub[org_ID]); ?></p>
<p><label for="type">PPI </label><? genere_select("ppi","ppi", "ppi_ID","ppi_nom",$connexion,'',$origin,'',$rub[ppi_ID]); ?></p>

</fieldset>
	<br />
</div>
<div id="formfooter">
		<p>			
			<input type="submit" name="BtnSubmit" id="valid" value="Valider" />
			<input type="submit" name="BtnSubmit" id="dupliquer" value="Dupliquer" />
			<input type="reset" name="BtnClear" id="annul" value="Annuler" />
		</p>
	</div>
	</form>
</body>

</html>