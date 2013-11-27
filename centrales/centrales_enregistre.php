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
*	programme: 			centrales_enregistre.php																	
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

//Récupération automatique des paramètres adresse
//en passant par le filtre de sécurité des injections
$centraleID = $_REQUEST['centraleID'];
$date_maj = uDate2MySql(time());

// teste s'il existe un organisme ayant le meme nom
function centrale_existe($nom,$connexion)
{
	global $centraleID;
	if($_REQUEST['maj'] == 0)// uniquement si demande de création
	{
		$requete="SELECT centrale_nom, centrale_ID FROM centrale WHERE centrale_nom = '$nom'";
		$resultat = ExecRequete($requete,$connexion);
		$donnees = mysql_fetch_array($resultat);
		if($donnees){
			$centraleID = $donnees[centrale_ID];
			return true;
		}
		else return false;
	}
}

$nom = Security::esc2Db($_REQUEST['nom']);
$centrales_type_ID = Security::esc2Db($_REQUEST['centralesID']);
$orgID = Security::esc2Db($_REQUEST['orgID']);
$type = Security::esc2Db($_REQUEST['organisme_type']);
/**
$adresse = Security::esc2Db($_REQUEST['adresse_ID']);
$z1 = Security::esc2Db($_REQUEST['z1']);
$z2 = Security::esc2Db($_REQUEST['z2']);
$ville = Security::esc2Db($_REQUEST['id_ville']);
$zip = Security::esc2Db($_REQUEST['zip']);
$lat = Security::esc2Db($_REQUEST['latitude']);
$lng = Security::esc2Db($_REQUEST['longitude']);
*/
if(centrale_existe($nom,$connexion))	// MAJ 
{	// update du vecteur
	// MAJ de l'adresse 
	
	$adresse_ID = recupere_adresse();
	
	$requete="UPDATE centrale SET 
									centrale_nom = '$nom',
									centrale_type_ID = '$centrales_type_ID',
									centrale_adresse_ID = '$adresse_ID',
									org_ID = '$orgID',
									depart_moyen = '',
									permanent = ''
							WHERE centrale_ID = '$centraleID'";
	$resultat = ExecRequete($requete,$connexion);
	
	//print($requete."<br>");
	header("Location:centrales_main.php?centraleID=$centraleID&back=$_REQUEST[back]");
}
else
{
	if(!centrale_existe($nom,$connexion))
	{	// Création de l'organisme
		$adresse_ID = recupere_adresse();
		$requete2="INSERT INTO centrale (centrale_ID,centrale_nom,centrale_type_ID,centrale_adresse_ID,org_ID,depart_moyen, permanent)
									 VALUES ('',
												'$nom',
												'$centrales_type_ID',
												'$adresse_ID',
												'$orgID',
												'',
												''
												)";
		$resultat = ExecRequete($requete2,$connexion);
		$centraleID = mysql_insert_id();
		//print($requete2);
		header("Location:centrales_main.php?centraleID=$centraleID&back=$_REQUEST[back]");
	}
	else
	{
		print("Un organisme du même nom existe déjà... ");
		print("<A HREF = \"centrales_main.php?centraleID=$centraleID\">Continuer");
	}
}


?>
