<?php
/**
  *	manif_lettre.php
  *
  *	crée le courrier d'accompagnement
  *	au format .pdf via latex
  */
  session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");

	$id = $_REQUEST['id'];
 	$requete = "SELECT * FROM manifestation WHERE manif_ID = '$manifID'";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
	
	/**
	  *
	  */
	$cmd_texFile = "commandes.tex";
	$fp = fopen($cmd_texFile,'w');
	
	$output = "/home/jcb/html/sagec3/manifestation/";
	$input = "/home/jcb/html/sagec3/manifestation/letex1.tex";
	
	//exec('/usr/bin/pdflatex  -file-line-error -output-directory '.$output.' '.$input);
	
	echo 'Page en cours de création...';
	
	ConstructionWorker.gif
?>

<img src=../images/ConstructionWorker.gif>