<?php
/**
*	hop_visible_enregistre.php
*/
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
$path="../";
$listeID = 1;//NE PAS MODIFIER
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require($path."pma_requete.php");
require($path."pma_connect.php");
require($path."pma_connexion.php");
$connexion = connexion(NOM,PASSE,BASE,SERVEUR);
$action = $_REQUEST['action'];
$value = $_REQUEST['value'];

if($action == "insert")
		$requete = "INSERT INTO hopital_visible VALUES('$value','$_SESSION[organisation]','$listeID')";
else
	$requete = "DELETE FROM hopital_visible WHERE hop_ID = '$value' AND org_ID = '$_SESSION[organisation]' AND liste_ID = '$listeID'   LIMIT 1";
ExecRequete($requete,$connexion);
?>