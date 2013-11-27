<?php
/**
*	specialite_visible_enregistre.php
*/
session_start();
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");

if($_REQUEST[ok]=="valider")
{
	// on récupère le tableau des cases cochées 
	$visible = $_REQUEST['visible'];
	// on le linéarise pour le rendre compatible avec la méthode IN de mysql 
	$comma_separated = implode("','", $visible);
	// on efface toutes les valeurs de la colonne pb_spe_visible de la table 
	$requete = "UPDATE planblanc_specialite SET pb_spe_visible = '0'";
	$resultat = ExecRequete($requete,$connexion);
	// on met à 1 les enregistrements dont l'ID est dans le tableau linéarisé
	$requete = "UPDATE planblanc_specialite SET pb_spe_visible = '1' WHERE pb_spe_ID IN('$comma_separated')";
	$resultat = ExecRequete($requete,$connexion);
	mysql_close();
	header('Location:specialites_affiche.php');
	exit;
}
else
{
	header('Location:specialite_nouvelle.php');
}

?>