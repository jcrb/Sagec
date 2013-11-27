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
//----------------------------------------- SAGEC --------------------------------------------------------
//													//
//	programme: 		/gis/ville/ville_enregistre.php						//
//	date de création: 	18/08/2003								//
//	auteur:			jcb									//
//	description:		enregistre les caractéristiques d'une ville dont l'identifiant est 	//
//				transmis par la variable $_REQUEST[id_ville]
//	version:		1.0									//
//	maj le:			10/08/2004								//
//													//
//---------------------------------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//
$backPathtoRoot = "./../../";
require($backPathtoRoot."pma_connect.php");
require($backPathtoRoot."pma_connexion.php");
require($backPathtoRoot."pma_requete.php");
require($backPathtoRoot."login/init_security.php");
//
// teste s'il existe une ville ayant le même nom
function ville_existe($nom,$connexion)
{
	if($_REQUEST['id_ville'] == 0)// uniquement si demande de création
	{
		$requete="SELECT ville_nom FROM ville WHERE ville_ID = '$_REQUEST[id_ville]'";
		$resultat = ExecRequete($requete,$connexion);
		$donnees = mysql_fetch_array($resultat);
		if($donnees)return true;
		else return false;
	}
}
//====================================== Main ========================================
//
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$nom = Security::str2db($_REQUEST[nom]);
$insee = Security::str2db($_REQUEST[insee]);
$zip = Security::str2db($_REQUEST[zip]);
$X = Security::str2db($_REQUEST[X]);
$Y = Security::str2db($_REQUEST[Y]);
$long = Security::str2db($_REQUEST[long]);
$lat = Security::str2db($_REQUEST[lat]);

if($_REQUEST["bouton"]=="Enregistrer")
{
	if($_REQUEST["nom"] != "" || !ville_existe($_REQUEST['nom'],$connexion)) // ne pas enregistrer si pas de nom de ville
	{
		if($_REQUEST["id_ville"]==0)	// create
		{
			$requete="INSERT INTO ville (ville_ID,ville_nom,ville_insee,ville_zip,ville_lambertX,ville_lambertY,departement_ID,region_ID,zone_ID,pays_ID,ville_longitude,ville_latitude,
			territoire_sante,secteur_apa_ID,secteur_smur_ID,secteur_Adps_ID,zone_proximite) 
			VALUES ('',
				'$nom',
				'$insee',
				'$zip',
				'$X',
				'$Y',
				'$_REQUEST[departement]',
				'$_REQUEST[id_region]',
				'$_REQUEST[id_zone]',
				'$_REQUEST[id_pays]',
				'$_REQUEST[long]',
				'$_REQUEST[lat]',
				'$_REQUEST[id_territoire]',
				'$_REQUEST[secteur_apa_ID]',
				'$_REQUEST[smur_id]',
				'$_REQUEST[secteur_pds_ID]',
				'$_REQUEST[id_zone_p]'
			)";
		}
		else				// update
		{
			$requete="UPDATE ville SET
				ville_nom = '$nom',
				ville_insee = '$insee',
				ville_zip = '$zip',
				ville_lambertX = '$X',
				ville_lambertY = '$Y',
				departement_ID = '$_REQUEST[departement]',
				region_ID = '$_REQUEST[id_region]',
				zone_ID = '$_REQUEST[id_zone]',
				pays_ID = '$_REQUEST[id_pays]',
				ville_longitude = '$_REQUEST[long]',
				ville_latitude = '$_REQUEST[lat]',
				territoire_sante = '$_REQUEST[id_territoire]',
				secteur_apa_ID = '$_REQUEST[secteur_apa_ID]',
				secteur_smur_ID = '$_REQUEST[smur_id]',
				secteur_Adps_ID = '$_REQUEST[secteur_pds_ID]',
				zone_proximite = '$_REQUEST[id_zone_p]'
				WHERE ville_ID = '$_REQUEST[id_ville]'";
		}
		$resultat = ExecRequete($requete,$connexion);
		if($_REQUEST["id_ville"]==0)$_REQUEST["id_ville"] = mysql_insert_id();
	}
}
else if($_REQUEST["bouton"]=="Supprimer ")	// attention, conserver l'espace après supprimer
{
	$requete = "DELETE FROM ville where ville_ID = '$_REQUEST[id_ville]'";
	$resultat = ExecRequete($requete,$connexion);
	$_REQUEST["id_ville"] = 0;
}
elseif($_REQUEST["bouton"]=="Nouvelle ")
{
	$_REQUEST["id_ville"] = 0;
}
//print($requete);
header("Location:$_REQUEST[back]?id_ville=$_REQUEST[id_ville]");
?>
