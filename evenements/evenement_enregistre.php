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
  * programme: 			evenement_enregistre.php
  * date de cr�ation: 	12/02/2010
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

require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

print_r($_REQUEST);

$nom = Security::str2db($_REQUEST['nom']);
$date1 = Security::str2db($_REQUEST['date1']);
$heure1 = Security::str2db($_REQUEST['heure1']);
$samu = Security::str2db($_REQUEST['samu']);
$sdis = Security::str2db($_REQUEST['sdis']);
$rem = Security::str2db($_REQUEST['rem']);

$type = Security::str2db($_REQUEST['typeID']);
$stype = Security::str2db($_REQUEST['soustypeID']);
$categorie = Security::str2db($_REQUEST['categorieID']);
$certitude = Security::str2db($_REQUEST['certitudeID']);
$gravite = Security::str2db($_REQUEST['graviteID']);
$niveau = Security::str2db($_REQUEST['niveauID']);
$severite = Security::str2db($_REQUEST['severiteID']);
$phase = Security::str2db($_REQUEST['phaseID']);
$status = Security::str2db($_REQUEST['statusID']);
$id = $_REQUEST['id'];
$cod = Security::str2db($_REQUEST['cod']);
$actif = Security::str2db($_REQUEST['actif']);
if($actif=='on')$actif=1; else $actif=0;
$ppi = Security::str2db($_REQUEST['ppi_id']);
$transit = Security::str2db($_REQUEST['transit']);
$localisation = Security::str2db($_REQUEST['localisation']);
$dos = Security::str2db($_REQUEST['dos']);
$cos = Security::str2db($_REQUEST['cos']);
$dsm = Security::str2db($_REQUEST['dsm']);
$dirvent = Security::str2db($_REQUEST['dirvent']);
$vitvent = Security::str2db($_REQUEST['vitvent']);
$nebul = Security::str2db($_REQUEST['nebul']);

print('Ev�nement ID: '.$id);
// nouvel �v�nement
if($id < 1) //print('Nouvel �v�nement');
{
	$requete = "INSERT INTO evenement(
						evenement_ID,
						evenement_nom,
						evenement_date1,
						evenement_heure1,
						evenement_victime,
						last_update,
						evenement_date2,
						evenement_heure2,
						evenement_actif,
						dossier_samu,
						dossier_sdis,
						comment,
						ppi_ID,
						pt_transit,
						localisation,
						dos,
						cos,
						dsm,
						vitvent,
						dirvent,
						nebul,
						type,
						soustype,
						categorie
						)
					VALUES(
						'',
						'$nom',
						'$date1',
						'$heure1',
						'$victimes',
						'$last',
						'$date2',
						'$heure2',
						'$actif',
						'$samu',
						'$sdis',
						'$rem',
						'$ppi',
						'$pt_transit',
						'$localisation',
						'$dos',
						'$cos',
						'$dsm',
						'$vitvent',
						'$dirvent',
						'$nebul',
						'$type',
						'$stype',
						'$categorie'
						)
					";
	$resultat = ExecRequete($requete,$connexion);
	$id =  mysql_insert_id();
	print('essai <br>'.$requete);
}
else
{
	$requete2 = "UPDATE evenement
					SET pt_transit = '$transit',
						dossier_samu = '$samu',
						dossier_sdis = '$sdis',
						comment = '$rem',
						localisation = '$localisation',
						ppi_ID = '$ppi',
						dos = '$dos',
						cos = '$cos',
						dsm = '$dsm',
						vitvent = '$vitvent',
						dirvent = '$dirvent',
						nebul = '$nebul',
						evenement_actif = '$actif',
						type = '$type',
						soustype = '$stype',
						categorie = '$categorie'
					WHERE evenement_ID = $id
					";
	$resultat = ExecRequete($requete2,$connexion);
	print('essai <br>'.$requete2);
}

// si �v�nement actif modifier la table alerte
if($actif == '1')//print(' �v�nement actif');
{
	$requete3 = "UPDATE alerte SET evenement_ID = '$id'";
	$resultat = ExecRequete($requete3,$connexion);
	//print('essai <br>'.$requete3);
}

header("Location: evenement_new.php?evenementID=$id");

?>
