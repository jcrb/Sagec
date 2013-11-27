<?php
/**
  *	evenement_enregistre.php
  */
  	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
	$backPathToRoot = "../../";
	require $backPathToRoot."dbConnection.php";
	include_once($backPathToRoot."login/init_security.php");
	
	echo $_REQUEST['titre'];
?>