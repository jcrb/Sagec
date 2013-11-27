<?php
/**
*	services_visible_enregistre.php
*/
session_start();
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
$listeID = 4;//NE PAS MODIFIER
$hopID = $_REQUEST[hopID];

// on récupère le tableau des cases cochées 
$visible = $_REQUEST['visible'];

// on le linéarise pour le rendre compatible avec la méthode IN de mysql 
$comma_separated = implode("','", $visible);

// on efface toutes les valeurs 
$requete = "DELETE FROM service_visible WHERE org_ID = '$_SESSION[organisation]' AND liste_ID = '$listeID' AND Hop_ID = '$hopID' ";
$resultat = ExecRequete($requete,$connexion);
// on met à 1 les enregistrements dont l'ID est dans le tableau linéarisé
for($i=0;$i<sizeof($visible);$i++)
{
	$requete = "INSERT INTO service_visible VALUES('$visible[$i]','$hopID','$_SESSION[organisation]','$listeID')";
	$resultat = ExecRequete($requete,$connexion);
}
mysql_close();
header("Location:services_selection.php?hopID=$hopID");
exit;
?>