<?php
//----------------------------------------- SAGEC --------------------------------------------------------
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
//---------------------------------------------------------------------------------------------
//	programme: 		enregistre_victime.php
//	date de création: 	18/08/2003
//	auteur:			jcb
//	version:			1.3
//	maj le:			13/11/2004
//---------------------------------------------------------------------------------------------
/**
* enregistre_victime.php
* Crée ou met à jour un enregistrement de la table victime
* @author Jean-Claude Bartier
* @copyright 2003-2005 (Jean-Claude Bartier)
* @package SAGEC67
*/
session_start();
$backPathToRoot = "../";
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");

function enregistre_gravite($connexion,$victime_ID,$gravite,$localisation_ID,$heure)
{
	$requete="INSERT INTO victime_gravite VALUES (
		'$victime_ID',
		'$gravite',
		'$localisation_ID',
		'$heure',
		''
		)";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete);
}

$fichier= $_FILES['photo_victime']['name'];
$taille= $_FILES['photo_victime']['size'];
$tmp= $_FILES['photo_victime']['tmp_name'];
$type= $_FILES['photo_victime']['type'];
$erreur= $_FILES['photo_victime']['error'];

if($erreur == 0)
{
	$destination = "../photos/".$_POST[no_identification].".jpg";
	move_uploaded_file($tmp, $destination);
	chmod ($destination,07777);
}
//echo"nouveau nom => $destination. <br />";

$nom = Security::esc2Db(mb_strtoupper($_REQUEST['nom']));
$prenom = Security::esc2Db($_REQUEST['prenom']);
$no_identification = Security::esc2Db(mb_strtoupper($_REQUEST['no_identification']));
$sexe = Security::esc2Db($_REQUEST['sexe']);
$age1 = Security::esc2Db($_REQUEST['age1']);
$age2 = Security::esc2Db($_REQUEST['age2']);
$gravite = Security::esc2Db($_REQUEST['gravite']);
if(!$gravite) $gravite = 11;
$localisation_type = Security::esc2Db($_REQUEST['localisation_type']);
$ID_hopital = Security::esc2Db($_REQUEST['ID_hopital']);
$the_service = Security::esc2Db($_REQUEST['the_service']);
$heure_courante = Security::esc2Db($_REQUEST['heure_courante']);
$devenir = Security::esc2Db($_REQUEST['devenir']);
$vecteur_engage_ID = Security::esc2Db($_REQUEST['vecteur_engage_ID']);
$signes = Security::esc2Db($_REQUEST['signes']);
$lesions = Security::esc2Db($_REQUEST['lesions']);
$traitement = Security::esc2Db($_REQUEST['traitement']);
$deconta =  $_REQUEST['deconta'];
$N = Security::esc2Db($_REQUEST['N']);
$B = Security::esc2Db($_REQUEST['B']);
$C = Security::esc2Db($_REQUEST['C']);
$status_type = $_REQUEST['status_type'];
$victime_ID = $_REQUEST['victimeID'];
$nationalite = $_REQUEST['nationalite'];
if(!$nationalite) $nationalite = 999;
$naissance = Security::esc2Db($_REQUEST['naissance']);
$adresse1 = Security::esc2Db($_REQUEST['adresse1']);
$adresse2 = Security::esc2Db($_REQUEST['adresse2']);
$ville = Security::esc2Db($_REQUEST['ville']);

if($nationalite ==0) $nationalite = 999;
if($gravite ==0) $gravite = 11;

$date_actuelle = uDateTime2MySql(time());
	$requete="UPDATE victime SET 	nom = '$nom',
					prenom = '$prenom',
					no_ordre = '$no_identification',
					sexe = '$sexe',
					age1 = '$age1',
					age2 = '$age2',
					gravite = '$gravite',
					localisation_ID ='$localisation_type',
					Hop_ID ='$ID_hopital',
					service_ID ='$the_service',
					heure_maj = '$date_actuelle',
					medicalisation_ID = '$devenir',
					vecteur_ID = '$vecteur_engage_ID',
					signes = '$signes',
					lesions = '$lesions',
					traitement = '$traitement',
					deconta = '$deconta',
					conta_N = '$N',
					conta_B = '$B',
					conta_C = '$C',
					pays_ID = '$nationalite',
					naissance = '$naissance',
					adresse1 = '$adresse1',
					adresse2 = '$adresse2',
					ville = '$ville',
					evenement_ID = '$_SESSION[evenement]',
					status_ID = '$status_type'
					";
					if($destination)
						$requete.=",photo = '$destination' ";
	$requete.="WHERE victime_ID = '$victime_ID'";
	$resultat = ExecRequete($requete,$connexion);
	enregistre_gravite($connexion,$victimes,$gravite,$localisation_type,$heure_courante);

//print($requete);
header("Location:victime_saisie.php?identifiant=$no_identification");
?>
