<?php
/**
  *	ressource_save.php
  */

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

$nom = Security::str2db($_REQUEST['nom']);
$ressource_type = Security::str2db($_REQUEST['resTypeId']);
$freq = Security::str2db($_REQUEST['freq']);
$visible = Security::str2db($_REQUEST['visible']);
$ordre = Security::str2db($_REQUEST['ordre']);
$id = Security::str2db($_REQUEST['ressourceID']);

if($id > 0)
{
	$requete = "UPDATE `pma`.`ror_ressource` SET `ressource_nom` = '$nom',`ressource_type_ID` = '$ressource_type',`report_frequency`='$freq',
	`visible`='$visible',`display_order`='$ordre'
	WHERE `ror_ressource`.`ror_ressource_ID` ='$id' LIMIT 1";
}
else
{
	$requete = "INSERT INTO `pma`.`ror_ressource` (`ror_ressource_ID` ,`ressource_type_ID` ,
	`ressource_nom` ,`report_frequency` ,`visible` ,`display_order`)
	VALUES ('', '$ressource_type', '$nom', '$freq', '$visible', '$ordre') ";
	$id = mysql_insert_id();
}

//echo $requete;
ExecRequete($requete,$connexion);
header("Location:ressource_liste.php");