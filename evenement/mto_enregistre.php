<?php
/**
*	mto_enregistre.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$path="./../ppi/";
$backPathToRoot="../";
require_once "../ppi/rose.php";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

$dirvent = $_REQUEST['dirvent']%360;
$ppi_ID = $_REQUEST['ppi_ID'];
$station = $_REQUEST['station'];
$date = $_REQUEST['date'];

$requete = "INSERT INTO mto(mto_ID,mto_date,ppi_ID,dirvent) 
				VALUES('','$date','$ppi_ID','$dirvent')
				";
			echo $requete;
			//$resultat = ExecRequete($requete,$connexion);
			
windRose($dirvent,$path);
print("La rose des vents a été modifiée<br>");
print("<br>");
print_r($_REQUEST);
?>