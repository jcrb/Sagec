<?php
/**
  *	liste_victime.php
  */
	session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot="../";
require($backPathToRoot."html.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
include_once($backPathToRoot."dbConnection.php");
$langue = $_SESSION['langue'];

	$pma = $_REQUEST[pma];
	$requete = "SELECT * FROM victime WHERE localisation_ID = '$pma'";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print($rub['no_ordre'].'<br>');
	}
?>