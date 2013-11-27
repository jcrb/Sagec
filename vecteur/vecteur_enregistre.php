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
*	programme: 			vecteur_enregistre.php																	 
*	date de création: 	19/08/2003																		
*	@author:				jcb																				
*	description:		enregistre un nouveau vecteur ou met à jour									
*	version:			1.3																				 
*	maj le:				14/03/2011																		 
*	appelé par:			vecteur_maj.php
* 	Variables transmises	$nom	nom du vecteur
*						 	$maj	correspond à Vec_ID. Vaut 0 si maj et à Vec_ID sinon
*							$engage	vaut oui si cochée, n'est pas transmise sinon'
*							$type_v	état du vecteur
*							$Type_de_vecteur
*							$indicatif
*							$tel
*							$dsa	
*	@version $Id: vecteur_enregistre.php 44 2008-04-16 06:55:34Z jcb $
*/							
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."adresse_ajout.php");
require($backPathToRoot."date.php");

$back = $_REQUEST['back'];
$vecteur=$_REQUEST['vecteur'];

// teste s'il existe un vecteur ayant le même nom
function vecteur_existe($nom,$connexion)
{
	if(strlen($vecteur) == 0)// uniquement si demande de création
	{
		$requete="SELECT Vec_Nom FROM vecteur WHERE Vec_Nom = '$_POST[nom]' AND org_ID = '$org_type'";
		$resultat = ExecRequete($requete,$connexion);
		$donnees = mysql_fetch_array($resultat);
		if($donnees)return true;
		else return false;
	}
}

/**
*	récupère les variables transmises
*/
$nom = Security::str2db($_REQUEST['nom']);
$engage = Security::str2db($_REQUEST['engage']);
$type_v = Security::str2db($_REQUEST['type_v']);
$v_type = Security::str2db($_REQUEST['v_type']);
$indicatif = Security::str2db($_REQUEST['indicatif']);
$tel = Security::str2db($_REQUEST['tel']);
$date_maj = uDateTime2MySql(time());
//$org_type = Security::str2db($_REQUEST['org_type']);
$org_type = Security::str2db($_REQUEST['orgID']);
$places_a = Security::str2db($_REQUEST['places_a']);
$places_c = Security::str2db($_REQUEST['places_c']);
$commune_id = Security::str2db($_REQUEST['commune_id']);
$localisation_type = Security::str2db($_REQUEST['localisation_type']);
$dsa = Security::str2db($_REQUEST['dsa']);
$baria = Security::str2db($_REQUEST['baria']);
$immatriculation = Security::str2db($_REQUEST['immatriculation']);
$lat_actuelle = Security::str2db($_REQUEST['lat_actuelle']);
$lng_actuelle = Security::str2db($_REQUEST['lng_actuelle']);
$centrale  = Security::str2db($_REQUEST['id_centrale']);
$adresse = recupere_adresse();

if(strlen($vecteur)>0)
{	// update du vecteur
	$requete="UPDATE vecteur SET 
								Vec_Nom = '$nom',
								Vec_Engage = '$engage',
								Vec_Etat = '$type_v',
								Vec_Type = '$v_type',
								Vec_Indicatif = '$indicatif',
								Vec_Tel = '$tel',
								Vec_Maj = '$date_maj',
								org_ID = '$org_type',
								Vec_place_assise = '$places_a',
								Vec_place_couche = '$places_c',
								com_ID = '$commune_id',
								localisation_ID = '$localisation_type',
								dsa = '$dsa',
								evenement_ID = '$_SESSION[evenement]',
								Vec_immatriculation = '$immatriculation',
								adresse_ID = '$adresse',
								lat = '$lat_actuelle',
								lng = '$lng_actuelle',
								centrale_ID = '$centrale',
								baria = '$baria'
							WHERE Vec_ID = '$vecteur'";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete."<br>\n");
	header("Location:".$back."?ttvecteur=".$vecteur);
}
else
{
	if(!vecteur_existe($nom,$connexion))
	{	// Création du vecteur
		$requete2="INSERT INTO vecteur VALUES (
						'',
						'$nom',
						'$engage',
						'$type_v',
						'$v_type',
						'$indicatif',
						'$tel',
						'$date_maj',
						'$org_type',
						'$places_a',
						'$places_c',
						'$commune_id',
						'$localisation_type',
						'$dsa',
						'$_SESSION[evenement]',
						'$immatriculation',
						'$adresse',
						'$lat_actuelle',
						'$lng_actuelle',
						'$centrale',
						'$baria'
						)";
		$resultat = ExecRequete($requete2,$connexion);
		//print($requete2);
		$vecteur = mysql_insert_id();
		header("Location:".$back."?ttvecteur=$vecteur");
	}
	else
	{
		print("Un vecteur du même nom existe déjà... ");
		print("<A HREF = \"$back\">Continuer");
	}
		
}
?>