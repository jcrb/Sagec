<?php
/**
*	geolocalise.php
*	met à jour les tables de sagec comportant des éléments de géolocalisation
* 	@package Sagec
* 	@author JCB
*	@version $Id$
*/
require("../../pma_connect.php");
require("../../pma_connexion.php");
require("../../pma_requete.php");
require("adresse.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

/**
*	mise à jour de la table mg67
*/
function maj_mg67()
{
	global $connexion;
	$requete = "SELECT med_ID, med_adresse, ville_nom
					FROM mg67, ville
					WHERE mg67.lat = 0
					AND mg67.ville_ID = ville.ville_ID";
	$resultat = ExecRequete($requete,$connexion);
	while($rep=mySql_fetch_array($resultat))
	{
		$adresse = $rep['med_adresse'].",".$rep['ville_nom'];
		$localisation = localise($adresse);
		$parts = explode(',',$localisation);
		print($localisation."<br>");
		if($parts[0] != 200)
			analyse_erreur($parts[0]);
		else
		{
			$requete2 = "UPDATE mg67 SET
							lat = $parts[2],
							lng = $parts[3]
							WHERE med_ID = $rep[med_ID]";
			ExecRequete($requete2,$connexion);
		}
	} 
}

 maj_mg67();
 
?>