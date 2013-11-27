<?php
/**
  *	sdis_config_enregistre.php
  *
  */
  
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";

require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."utilitairesHTML.php");

$pma =  explode(";",$_REQUEST['id_pma']);
$pma_id = $pma[0];
$pma_nom = $pma[1];
$poste = $_REQUEST['status_type'];

/** mise à jour des données de session */
$_SESSION['PMA_ID'] = $pma_id;
$_SESSION['poste'] = $poste;

$file = $backPathToRoot."pma.ini";
$fp = fopen($file,"w");
fwrite($fp,": Fichier de configuration\n");
fwrite($fp,": les lignes commençant par :sont des commentaires\n");
fwrite($fp,"\n");
fwrite($fp,"[Configuration]\n");
fwrite($fp,"pma_ID = ".$pma_id."\n");
fwrite($fp,"pma_nom = ".$pma_nom."\n");
fwrite($fp,"pma_saisie = ".$poste."\n");
fclose($fp);
header("Location:sdis_config.php");
?>