<?php
/**
  *	message_delete.php
  */
  session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);	
	$backPathToRoot = "../../";
	require($backPathToRoot."dbConnection.php");
	$deleteMessage = $_REQUEST['messageID'];
	//$requete = "DELETE FROM livrebord_service WHERE LBS_ID = '$deleteMessage'";
	$requete = "UPDATE livrebord_service SET LBS_visible = 'n' WHERE LBS_ID = '$deleteMessage'";
	$result = ExecRequete($requete,$connexion);
	 header("Location: message_lire.php");
?>