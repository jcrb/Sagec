<?php
//----------------------------------------- SAGEC ----------------------------------------------------
//	programme: 			googlemap_key.php	
//	date de cr�ation: 	28/04/2008
//	auteur:				dominique nold										
//	description:		permet de r�cup�rer le cl� google en fonction de l'environnement	
//	version:			1.0
//
//----------------------------------------------------------------------------------------------------
require($backPathToRoot."pma_connect.php");
require($backPathToRoot."pma_connexion.php");
require($backPathToRoot."pma_requete.php");

// ouverture d'une session
session_start();

function getGoogleMapKey (){

	// regarder si l'information est en session
	$googleMapKey = $_SESSION["googleMapKey"];
	
	if (!$googleMapKey){
		// lecture du nom du hostname
		$hostname = gethostbyaddr($_SERVER['SERVER_ADDR']);
		
		// lecture de la cl� correspondante dans la base de donn�es
		$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
		$requete = "SELECT cle_valeur
			FROM cles
			WHERE cle_nom='googlemap' AND cle_host='".$hostname."'";
		$resultat = ExecRequete($requete,$connexion);
		
		if ($i = LigneSuivante($resultat))
			$googleMapKey = $i->cle_valeur;
			
		if ($googleMapKey)
			// mettre le r�sultat en session
			$_SESSION["googleMapKey"] = $googleMapKey;
		else
			// mettre la production par defaut s'il y a un probl�me de lecture de la cl�
			$googleMapKey = "ABQIAAAAOiFPV0Y5zzLw7M6z-aRD5RS4M0VztE0O-QJMMgCt9di7cKfD1RRqOuGcbIuRW0zmeP9ety1-dA17AA";
	}
	return $googleMapKey;
}
?>
