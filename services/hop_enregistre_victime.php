<?php
/**
*	hop_enregistre_victime.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_service'])header("Location:logout.php");
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");

$noVictime = Security::esc2Db($_REQUEST['noVictime']);// manque MAJUSCULE 
$nip = Security::esc2Db($_REQUEST['nip']);// manque MAJUSCULE
$victimeID = Security::esc2Db($_REQUEST['victimeID']);
$nom = Security::esc2Db($_REQUEST['nom']);
$prenom = Security::esc2Db($_REQUEST['prenom']);
$date = uDateTime2MySql(time());
// nb Localisation_ID = 7 = hôpital 
	$requete = "UPDATE victime SET 
						Hop_ID = '$_SESSION[Hop_ID]', 
						service_ID = '$_SESSION[service]',
						nip = '$nip',
						heure_maj = '$date',
						nom = '$nom',
						prenom = '$prenom',
						localisation_ID = 7
						WHERE victime_ID = '$victimeID'";
		ExecRequete($requete,$connexion);
	
	// mise à jour de la table victime_gravite
		$requete="INSERT INTO victime_gravite VALUES (
		'$victimeID',
		'',
		'$_SESSION[organisation]',
		'$date',
		''
		)";
		$resultat = ExecRequete($requete,$connexion);
header("Location:hop_affiche_victime.php?noVictime=$noVictime");
?>