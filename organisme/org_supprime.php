<?php
/**
*	org_supprime.php
*	nécessite de supprimer les enregistrement dans les tables
*	- adresse
*	- contact
*	- organisme
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
if(! $_SESSION['auto_sagec'])header("Location:".$backPathToRoot."logout.php");
$langue = $_SESSION['langue'];
require($backPathToRoot."dbConnection.php");

$orgID = $_REQUEST['orgID'];

$requete = "SELECT adresse_ID FROM organisme WHERE org_ID='$orgID'";
$resultat = ExecRequete($requete,$connexion);
$rub = mysql_fetch_array($resultat);

// destruction de l'adresse
$requete = "DELETE FROM adresse WHERE ad_ID = '$rub[adresse_ID]'";
ExecRequete($requete,$connexion);


// destruction des contacts
$requete = "DELETE FROM contact WHERE identifiant_contact='$orgID' AND nature_contact_ID = 2";
ExecRequete($requete,$connexion);


// destruction de l'organisme 
$requete = "DELETE FROM organisme WHERE org_ID = '$orgID'";
ExecRequete($requete,$connexion);


print("<a href=\"liste_org2.php?ok=valider&organisme_type=$_REQUEST[back]\">Retour</a>");
?>