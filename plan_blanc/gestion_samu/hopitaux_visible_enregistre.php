<?php
/**
*	hopitaux_visible_enregistre.php
*/
session_start();
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
$listeID = 4;//NE PAS MODIFIER

// on r�cup�re le tableau des cases coch�es 
$visible = $_REQUEST['visible'];

// on le lin�arise pour le rendre compatible avec la m�thode IN de mysql 
$comma_separated = implode("','", $visible);

// on efface toutes les valeurs 
$requete = "DELETE FROM hopital_visible WHERE org_ID = '$_SESSION[organisation]' AND liste_ID = '$listeID' ";
$resultat = ExecRequete($requete,$connexion);
// on met � 1 les enregistrements dont l'ID est dans le tableau lin�aris�
for($i=0;$i<sizeof($visible);$i++)
{
	$requete = "INSERT INTO hopital_visible VALUES('$visible[$i]','$_SESSION[organisation]','$listeID')";
	$resultat = ExecRequete($requete,$connexion);
}
mysql_close();
header('Location:hopitaux_affiche.php');
exit;
?>