<?php
/**
*	send_message.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."date.php");

$monTexte = Security::esc2Db($_REQUEST['msg']);
if($monTexte) // pour ne pas enregistrer une phrase vide
{
	$timestamp = date("Y-m-j H:i:s");// format compatible mysql
	$irq = 1; //une info
	$visible = 'o';
	// si c'est une réponse, on reécupère l'identifiant de la question
	$question_ID = $_REQUEST[idQuestion];
	//$monTexte = addslashes($montexte);
	$query = "INSERT INTO livrebord
	 		VALUES('','$_SESSION[organisation]','$_SESSION[member_id]','$timestamp','$monTexte','$visible','$_SESSION[localisation]','$irq')";
	$result = ExecRequete($query,$connexion);
	if($_REQUEST[iqr]=="3") // c'est une réponse => mettre à jour livrebord_QR
	{
		$reponse_ID = mysql_insert_id();
		$requete = "INSERT INTO livrebordQR VALUES('','$question_ID','$reponse_ID')";
		$result = ExecRequete($requete,$connexion);
	}
}
header("Location: menu1.php");
?>