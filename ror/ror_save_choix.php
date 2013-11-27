<?php
/**
  *	ror_save_choix.php
  */

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");

/** type de localisation */
$location = $_REQUEST['locTypeId'];
/** type de ressource */
$ressourceType = $_REQUEST['resTypeId'];
/** liste des ressources sélectionnées */
$data = $_REQUEST['data'];

print_r($data);

/**
  * efface les enregistrements précédants pour ce type de localisation
  */
$requete = "DELETE FROM ror_locationtype_ressource
				WHERE ressourcetype_ID = '$ressourceType'
				AND locationtype_ID = '$location'
				";
$resultat = ExecRequete($requete,$connexion);

/**
  * mémorise les nouvelles données
  */
for($i=0;$i<sizeof($data);$i++)
{
	$requete = "INSERT INTO ror_locationtype_ressource(locationtype_ID,ressource_ID,ressourcetype_ID) VALUES('$location','$data[$i]','$ressourceType')";
	ExecRequete($requete,$connexion);
}

$back = "ror_select_ressource.php";
header("Location:".$back."?locTypeId=$location&resTypeId=$ressourceType");

?>