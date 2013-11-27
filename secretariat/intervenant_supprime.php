<?php
/**
 *	intervenant_supprime.php
 */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$backPathToRoot = "../"; 
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."autorisations/droits.php");

if(est_autorise('DELETE_PERSONNEL'))
{
	$noDossier = $_REQUEST[intervenantID];
	//print("dossier: ".$noDossier."<br>");

	/**
	  * destruction définitive
	  * inactivée par défaut et remplacée par la mise à jour du champ visible qui passe à 'n'
	  
	// destrruection de l'adresse 
	$requete = "SELECT adresse_ID, photo from personnel WHERE Pers_ID = '$noDossier'";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
	$adresseID = $rep[adresse_ID];
	$requete = "DELETE FROM adresse WHERE ad_ID = '$adresseID'";
	ExecRequete($requete,$connexion);

	// destruction de la photo
	if($rep[photo] != "")
	{
		//print($rep[photo]."<br>");
		unlink($backPathToRoot.$rep[photo]);
	}

	// destruction de la fiche
	$requete = "DELETE FROM personnel WHERE Pers_ID = '$noDossier'";
	ExecRequete($requete,$connexion);
	//print($requete."<br>");
	// destruction des contacts
	$requete = "DELETE FROM contact WHERE identifiant_contact = '$noDossier' AND nature_contact_ID = 1";
	ExecRequete($requete,$connexion);
	//print($requete."<br>");
	*/
	
	/**
	  * on met à 'n' le champ visible pour masquer la personne
	  */
	$requete = "UPDATE personnel SET visible = 'n' WHERE Pers_ID = '$noDossier'";
	ExecRequete($requete,$connexion);
}
header("Location:"."intervenant_liste.php");
?>