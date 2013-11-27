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
//---------------------------------------------------------------------------------------------------------
/**																									 
*	programme: 			organisme_enregistre.php																	
*	date de création: 	07/10/2003																		
*	auteur:				jcb																				 
*	description:		enregistre un nouvel organisme ou met à jour									
*	@version:			1.1 $Id: organisme_enregistre.php 31 2008-02-12 18:02:26Z jcb $																				 
	maj le:				07/10/2003																		 
	appelé par:			vecteur_maj.php
* 	Variables transmises	$nom	nom du vecteur
*						 	$maj	correspond à Vec_ID. Vaut 0 si maj et à Vec_ID sinon
*							$engage	vaut oui si cochée, n'est pas transmise sinon'
*						$type_v	état du vecteur
*							$Type_de_vecteur
*							$indicatif
*							$tel	
*/																								 
//---------------------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot="../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."pma_requete.php");
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."date.php");
include($backPathToRoot."adresse_ajout.php");

$orgID = $_REQUEST['orgID'];
$date_maj = uDate2MySql(time());

// teste s'il existe un organisme ayant le meme nom
function organisme_existe($nom,$connexion)
{
	if($_GET['maj'] == 0)// uniquement si demande de création
	{
		$requete="SELECT org_nom FROM organisme WHERE org_nom = '$_GET[nom]'";
		$resultat = ExecRequete($requete,$connexion);
		$donnees = mysql_fetch_array($resultat);
		if($donnees)return true;
		else return false;
	}
}

$nom = Security::str2db($_REQUEST['nom']);
$nomc = Security::str2db($_REQUEST['nomc']);
$type = Security::str2db($_REQUEST['organisme_type']);
$adresse = Security::str2db($_REQUEST['adresse_ID']);
$z1 = Security::str2db($_REQUEST['z1']);
$z2 = Security::str2db($_REQUEST['z2']);
$ville = Security::str2db($_REQUEST['id_ville']);
$zip = Security::str2db($_REQUEST['zip']);
$lat = Security::str2db($_REQUEST['latitude']);
$lng = Security::str2db($_REQUEST['longitude']);
$rem = Security::str2db($_REQUEST['rem']);

if($orgID > 0)	// MAJ 
{	// update du vecteur
	// MAJ de l'adresse 
	$adresse_ID = recupere_adresse();
	
	$requete="UPDATE organisme SET 
									org_nom = '$nom',
									organisme_type_ID = '$type',
									contact_ID = '',
									adresse_ID = '$adresse_ID',
									org_nom_complet= '$nomc',
									maj = '$date_maj',
									comment = '$rem'
							WHERE org_ID = '$orgID'";
	$resultat = ExecRequete($requete,$connexion);
	
	//print($requete."<br>");
	header("Location: organisme_saisie.php?orgID=$orgID&back=$_REQUEST[back]");
}
else
{
	if(!organisme_existe($nom,$connexion))
	{	// Création de l'organisme
		$adresse_ID = recupere_adresse();
		$requete2="INSERT INTO organisme (org_ID,org_nom,organisme_type_ID,adresse_ID,org_nom_complet,maj,comment)
									 VALUES ('',
												'$nom',
												'$type',
												'$adresse_ID',
												'$nomc',
												'$maj',
												'$rem'
												)";
		$resultat = ExecRequete($requete2,$connexion);
		$maj = mysql_insert_id();
		//print($requete2);
		header("Location:organisme_saisie.php?orgID=$maj&back=$_REQUEST[back]");
	}
	else
	{
		print("Un organisme du même nom existe déjà... ");
		print("<A HREF = \"organisme_saisie.php?org_type=$_GET[organisme_type]\">Continuer");
	}	
}

?>
