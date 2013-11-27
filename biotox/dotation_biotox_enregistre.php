<?php
/**
  * materiel_biotox_enregistre.php
  *
  */
  session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//
$backPathtoRoot = "./../";
require($backPathtoRoot."dbConnection.php");
require($backPathtoRoot."date.php");
require($backPathtoRoot."login/init_security.php");//print_r($_REQUEST);

$dotation_ID = $_REQUEST['dotationID'];
//$nom = Security::str2db($_REQUEST['']);
$marque = $_REQUEST['marque'];
if($marque < 1) $marque = 1;
$fournisseur = $_REQUEST['type_fournisseur'];
if($fournisseur < 1) $fournisseur = 6;
$acheteur =  $_REQUEST['type_acheteur'];
if($acheteur < 1) $acheteur = 8;
$qte = Security::str2db($_REQUEST['qte']);
$ville = $_REQUEST['type_ville'];
$rem = Security::str2db($_REQUEST['rem']);
$date1 = Security::str2db(fdate2usdate($_REQUEST['date1']));
$date2 = Security::str2db(fdate2usdate($_REQUEST['date2']));
$stock = $_REQUEST['type_stockage'];
$materielID = $_REQUEST['type_materiels'];
$date_inventaire = Security::str2db(fdate2usdate($_REQUEST['date_inventaire']));

if($dotation_ID != null) // mise à jour
{
	//$requete = "UPDATE materiel SET materiel_nom = '$nom' WHERE materiel_ID = '$materielID'";
	//ExecRequete($requete,$connexion);
	$requete = "UPDATE dotation SET
								ville_ID = '$ville',
								materiel_ID = '$materielID',
								dotation_qte = '$qte',
								fournisseur_ID = '$fournisseur',
								acheteur_ID = '$acheteur',
								date_achat = '$date1',
								marque_ID = '$marque',
								peremption = '$date2',
								stockage_ID = '$stock',
								rem = '$rem',
								date_inventaire = '$date_inventaire'
					WHERE dotation_ID = '$dotation_ID'";
	ExecRequete($requete,$connexion);
	echo $requete;
}
else
{
	//$requete = "INSERT INTO materiel VALUES('',$nom)";
	//$resultat = ExecRequete($requete,$connexion);
	//$materiel_ID = mysql_insert_id();
	$requete = "INSERT INTO dotation (dotation_ID,ville_ID,materiel_ID,dotation_qte,fournisseur_ID,acheteur_ID,date_achat,marque_ID,peremption,stockage_ID,rem,date_inventaire)
					VALUES('','$ville','$materielID','$qte','$fournisseur','$acheteur','$date1','$marque','$date2','$stock','$rem','$date_inventaire')";
	$resultat = ExecRequete($requete,$connexion);
}
header("Location:dotation_biotox.php?dotation_id=$dotation_ID");

?>