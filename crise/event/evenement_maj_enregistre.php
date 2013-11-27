<?php
/**
  *	evenement_maj_enregistre.php
  */
	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
	$backPathToRoot = "../../";
	require $backPathToRoot."dbConnection.php";
	
$type = $_REQUEST['typeID'];
$type = $_REQUEST['stypeID'];
$type = $_REQUEST['categorieID'];
$type = $_REQUEST['certitudeID'];
$type = $_REQUEST['graviteID'];
$type = $_REQUEST['niveauID'];
$type = $_REQUEST['phaseID'];
$type = $_REQUEST['statusID'];

?>