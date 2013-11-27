<?php
/**
  *	affectation_enregistre.php
  */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../"; 
require($backPathToRoot."dbConnection.php");
include($backPathToRoot."login/init_security.php");
include($backPathToRoot."date.php");

/**
  *	récupération sécurisée des données
  */
  
  $personnelID = Security::esc2Db($_REQUEST[personnelID]);
  $affectationID = Security::esc2Db($_REQUEST[affectationID]);
  $heure_alerte = Security::esc2Db(fdate2usdatetime($_REQUEST[h1]));
  $heure_arrive = Security::esc2Db(fdate2usdatetime($_REQUEST[h2]));
  $heure_depart = Security::esc2Db(fdate2usdatetime($_REQUEST[h3]));
  $vecteur =  Security::esc2Db($_REQUEST[vecteur_engage_ID]);
  $fonction =  Security::esc2Db($_REQUEST[id_fonction]);
  $localisation =  Security::esc2Db($_REQUEST[localisation_type]);
  $remarque =  Security::esc2Db($_REQUEST[rem]);
  $p1 =  Security::esc2Db($_REQUEST[p1]);
  $p2 =  Security::esc2Db($_REQUEST[p2]);
  $tel1 =  Security::esc2Db($_REQUEST[tel1]);

/**
  *	Si $affectationID existe, c'est une mise à jour
  */
  
  $requete="INSERT INTO perso_affectation
  				VALUES ('$personnelID', '$heure_alerte', '$heure_arrive', '$heure_depart', '$vecteur', '$fonction', '$localisation', '$remarque','$p1','$p2','$tel1')
				ON DUPLICATE KEY
				UPDATE `personnel_ID` = '$personnelID',
						`heure_alerte` = '$heure_alerte',
						`heure_arrive` = '$heure_arrive',
						`heure_depart` = '$heure_depart',
						`vecteur_ID` = '$vecteur',
						`fonction_ID` = '$fonction',
						`location_ID` = '$localisation',
						remarque = '$remarque',
						portatif1 = '$p1',
						portatif2 = '$p2',
						tel1 = '$tel1'
				";
		ExecRequete($requete,$connexion);
		//$personnelID = mysql_insert_id();
/* 
if($affectationID != '')
{
	$requete = "UPDATE `pma`.`perso_affectation` SET 
		`personnel_ID` = '$personnelID',
		`heure_alerte` = '$heure_alerte',
		`heure_arrive` = '$heure_arrive',
		`heure_depart` = '$heure_depart',
		`vecteur_ID` = '$vecteur',
		`fonction_ID` = '$fonction',
		`location_ID` = '$localisation' 
		WHERE `perso_affectation`.`affectation_ID` = '$affectationID'
		LIMIT 1 ";
	$resultat = ExecRequete($requete,$connexion);
	
}
*/
/**
  *	Sinon c'est une creation
  */
  /*
else
{
	$requete = "INSERT INTO `pma`.`perso_affectation` (
		`affectation_ID` ,
		`personnel_ID` ,
		`heure_alerte` ,
		`heure_arrive` ,
		`heure_depart` ,
		`vecteur_ID` ,
		`fonction_ID` ,
		`location_ID` ,
		`remarque`)
	VALUES (
		NULL , '$personnelID', '$heure_alerte', '$heure_arrive', '$heure_depart', '$vecteur', '$fonction', '$localisation', '$remarque'
		)";
	$resultat = ExecRequete($requete,$connexion);
	$affectationID = mysql_insert_id();
} 
*/
/**
  *	retour à liste des intervenants
  */	
  
print($requete.'<br>');
header("Location: intervenants_arrive.php");
?>