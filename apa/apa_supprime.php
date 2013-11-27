<?php
/**
* apa_supprime.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["auto_apa"])
{
	print("<H2>Vous n'êtes pas autorisé à accéder à cette zone</H2><BR>");
	echo "<a href = \"langue.php\"><H1>Continuer</H1></a><br>";
	exit();
}
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");// paramètres privés de connexion
$vecteur = $_REQUEST[ttvecteur];
$requete = "DELETE FROM vecteur WHERE Vec_ID = '$vecteur'";
ExecRequete($requete,$connexion);
header("Location:apa_moyens.php");
print($vecteur);
?>