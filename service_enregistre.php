<?php
/*----------------------------------------- SAGEC --------------------------------------------------------
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
/**
*	programme: 		service_enregistre.php
*	date de création: 	18/08/2003
*	auteur:			jcb
*	description:
*	@version:		1.6 $Id: service_enregistre.php 31 2008-02-12 18:02:26Z jcb $
*	maj le:			24/06/2005
*/

/**
lit_spe1	nb de lits de déchoc si SAU, nb lits de réa si service de brûlés
lit_spe2	nb de lits HTCD si SAU, nb lits chrirurgicaux si service brûlés
Ajout de la journalisation des lits
*/

//=======================================================================================================*/
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");

require_once("dbConnection.php");
require_once("login/init_security.php");
//require("pma_requete.php");

// teste s'il existe un tuple lits associé au service
// $resultat est vide si n'existe pas
function Lits_existe($service_id,$connexion)
{
	global $connexion;
	$requete="SELECT * FROM lits WHERE service_ID = '$service_id'";
	$resultat = ExecRequete($requete,$connexion);
	$i = LigneSuivante($resultat);
	//print("RESULTAT: ".$i."\n");
	//print("service: ".$service_id."\n");
	return $i;
}

function Create_Lits($connexion,$id_service,$ID_hopital,$lits,$lits_sup,$lits_lib,$lits_vides)
{
	//$requete="SELECT service_ID FROM service WHERE service_nom = '$nom_service'";
	//$resultat = ExecRequete($requete,$connexion);
	//$i = LigneSuivante($resultat);
	$lits_occ = $lits - $lits_vides;
	$lits_dispo = $lits + $lits_supp - $lits_occ - $lits_cata;
	$date_maj = time();
	$requete2="INSERT INTO lits VALUES ('',
					'$id_service',
					'$ID_hopital',
					'$lits',
					'$lits_sup',
					'$lits_occ',
					'$lits_lib',
					'',
					'$lits_dispo',
					'$date_maj',
					'$_GET[respi]',
					'',
					'$_GET[isole]',
					'$_GET[spe1]',
					'$_GET[spe2]',
					'$_GET[spe3]',
					'$_GET[spe4]',
					'$_GET[spe5]',
					'$_GET[spe6]',
					'$_GET[spe7]',
					'$_GET[dialyse]',
					'$_GET[lits_reserve]',
					'$_GET[instal]',
					'$_GET[lits_ferme]',
					'$_GET[places_auto]',
					'$_GET[places_dispo]'
					)";
	$resultat = ExecRequete($requete2,$connexion);
	// mise à jour du journal
	$requete="INSERT INTO lits_journal VALUES('$date_maj','$id_service','$lits_dispo','$_SESSION[member_id]')";
	$resultat = ExecRequete($requete,$connexion);
	if($_GET['places_auto']>0)
	{
		$requete="INSERT INTO places_journal VALUES('$date_maj','$id_service','$_GET[places_dispo]','$_SESSION[member_id]')";
		$resultat = ExecRequete($requete,$connexion);
	}
}

function Update_Lits($connexion,$maj,$ID_hopital,$lits,$lits_sup,$lits_lib,$lits_vides)
{
	$date_maj = time();
	$lits_occ = $lits - $lits_vides;
	$lits_dispo = $lits + $lits_supp - $lits_occ - $lits_cata;
	$requete="UPDATE lits SET service_ID = '$maj',
				Hop_ID = '$ID_hopital',
				lits_sp = '$lits',
				lits_supp = '$lits_sup',
				lits_occ = '$lits_occ',
				lits_liberable = '$lits_lib',
				lits_dispo = '$lits_dispo',
				lits_respi = '$_GET[respi]',
				date_maj = '$date_maj',
				lits_pneg = '$_GET[isole]',
				lit_spe1 = '$_GET[spe1]',
				lit_spe2 = '$_GET[spe2]',
				lit_spe3 = '$_GET[spe3]',
				lit_spe4 = '$_GET[spe4]',
				lit_spe5 = '$_GET[spe5]',
				lit_spe6 = '$_GET[spe6]',
				lit_spe7 = '$_GET[spe7]',
				lits_dialyse = '$_GET[dialyse]',
				lits_reserve = '$_GET[lits_reserve]',
				lits_installe = '$_GET[instal]',
				lits_ferme =  '$_GET[lits_ferme]',
				places_auto = '$_GET[places_auto]',
				places_dispo = '$_GET[places_dispo]'
		WHERE service_ID = '$maj'";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete."<br>\n");
	//print("date: ".$date_maj."<br>\n");
	// mise à jour du journal
	$requete="INSERT INTO lits_journal VALUES('$date_maj','$maj','$lits_dispo','$_SESSION[member_id]')";
	$resultat = ExecRequete($requete,$connexion);
}

/**
* Création d'un organisme a minima
* @param $hop_id identifiant de l'hopital 
* @return $org_ID
*/
function create_organisme($hop_id)
{
	global $connexion;
	$organisme_type = 12;/** hopital */
	// récupère le nom de l'hôpital
	$requete = "SELECT Hop_nom FROM hopital WHERE Hop_ID = '$hop_id'";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mySql_Fetch_Array($resultat);
	
	$requete = "INSERT INTO organisme (org_ID,org_nom, organisme_type_ID) VALUES ('','$rep[0]','$organisme_type')";
	$resultat = ExecRequete($requete,$connexion);
	return mysql_insert_id();
}

$maj = $_GET['maj'];

/**
*	Création d'un nouveau service
*/
if(isset($_GET['ID_hopital']) && !$_GET['maj'])
{
	/** on recherche l'organisme dont dépend le service */
	$requete = "SELECT org_ID FROM hopital WHERE Hop_ID = '$_GET[ID_hopital]'";
	//print($requete."<br>");
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
	$orgID = $rep['org_ID'];
	if(!$orgID)
		$orgID = create_organisme($_GET[ID_hopital]);
		
	$_GET['tel']=str_replace(".", "", $_GET['tel']);//compacte le n°
	$_GET['fax']=str_replace(".", "", $_GET['fax']);//compacte le n°
	$requete="INSERT INTO service VALUES('',
					'$orgID',
					'$_GET[ID_hopital]',
					'$_GET[type_s]',
					'$_GET[nom]',
					'$_GET[code]',
					'$_GET[tel]',
					'$_GET[fax]',
					'$_GET[etage]',
					'$_GET[batiment]',
					'$_GET[ascenceur]',
					'$_GET[priorite]',
					'$_GET[alerte]',
					'$_GET[h_alerte]',
					'$_GET[ID_specialite]',
					'$_GET[adulte]',
					'$_GET[enfant]',
					'$_GET[age]',
					'$_GET[samu]',
					'$_GET[id_groupe]',
					'$_GET[id_discipline]'
					)";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete."<br>");
	$maj = mysql_insert_id();
	Create_Lits($connexion,$maj,$_GET['ID_hopital'],$_GET['lits'],$_GET['lits_sup'],$_GET['lits_lib'],$_GET['lits_vides']);
}
else
{
	$_GET['tel']=str_replace(".", "", $_GET['tel']);//compacte le n°
	$_GET['fax']=str_replace(".", "", $_GET['fax']);//compacte le n°
	$requete="UPDATE service SET 	Hop_ID = '$_GET[ID_hopital]',
					org_ID = '$_GET[orgID]',
					Type_ID = '$_GET[type_s]',
					service_nom = '$_GET[nom]',
					service_code = '$_GET[code]',
					service_tel = '$_GET[tel]',
					service_fax = '$_GET[fax]',
					service_etage = '$_GET[etage]',
					service_batiment ='$_GET[batiment]',
					service_ascenceur ='$_GET[ascenceur]',
					Priorite_Alerte = '$_GET[priorite]',
					Service_Alerte = '$_GET[alerte]',
					heure_alerte = '$_GET[h_alerte]',
					specialite_ID = '$_GET[ID_specialite]',
					service_adulte = '$_GET[adulte]',
					service_enfant = '$_GET[enfant]',
					age_min = '$_GET[age]',
					samu_id = '$_GET[samu]',
					service_groupe_ID = '$_GET[id_groupe]',
					service_discipline_ID = '$_GET[id_discipline]'
				WHERE service_ID = '$_GET[maj]'";
	$resultat = ExecRequete($requete,$connexion);
	
	if(Lits_existe($_GET['maj'],$connexion))
		Update_Lits($connexion,$_GET['maj'],$_GET['ID_hopital'],$_GET['lits'],$_GET['lits_sup'],$_GET['lits_lib'],$_GET['lits_vides']);
	else
		Create_Lits($connexion,$_GET['nom'],$_GET['ID_hopital'],$_GET['lits'],$_GET['lits_sup'],$_GET['lits_lib'],$_GET['lits_vides']);
}
//print($requete);
header("Location:services.php?ttservice=$maj&back=$_GET[back]&orgID=$_GET[orgID]&type_service=$_GET[type_service]");
?>
