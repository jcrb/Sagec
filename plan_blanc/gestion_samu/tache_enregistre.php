<?php
/**
*	tache_enregistre.php
*/
session_start();
$backPathToRoot = "../../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."date.php");
$tacheID = $_REQUEST['tacheID'];

$nom = Security::str2db($_REQUEST[nom]);
$priorite = Security::str2db($_REQUEST[priorite]);
$comment = Security::str2db($_REQUEST[comment]);
$message = Security::str2db($_REQUEST[message]);

if($tacheID)
{
	$requete = "UPDATE tache SET
					tache_nom = '$nom',
					tache_priorite = '$priorite',
					tache_comment = '$comment',
					tache_message = '$message'
					WHERE tache_ID = '$tacheID'
					";
	ExecRequete($requete,$connexion);
}
else
{
	$requete = "INSERT INTO tache(`tache_ID` ,`tache_nom` ,`tache_priorite` ,`tache_comment`,`tache_message`)
					VALUES (NULL , '$nom', '$priorite', '$comment','$message')";
	ExecRequete($requete,$connexion);
	$tacheID = mysql_insert_id ();
}

//header('Location:tache_nouvelle.php?tacheID=$tacheID');
header('Location:checklist.php');
?>
