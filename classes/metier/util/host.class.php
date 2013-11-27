<?php
if (!isset($BackToRoot)){
	$BackToRoot="../../../SAGEC67/";
}

class Metier_Util_Host{
	/**
	 * Retourne le host court de l'ordinateur
	 * @return (string)
	 */
	public static function getHostCourt (){
		// environnement web
		if (isset($_SERVER["SERVER_NAME"])){
			$vHost = $_SERVER["SERVER_NAME"];
			
			list($vHostCourt, $vReste) = split("\.", $vHost, 2);
			return $vHostCourt;
		}
		
		// environnement shell unix
		if (isset($_SERVER["HOSTNAME"])){
			$vHost = $_SERVER["HOSTNAME"];
			
			list($vHostCourt, $vReste) = split("\.", $vHost, 2);
			return $vHostCourt;
		}
		
		// environnement shell windows
		if (isset($_SERVER["COMPUTERNAME"])){
			// actuellement l'environnement windows est juste pour le développement
			return "localhost";
		}
		
		// en parametre à l'application
		$vListeArgs = $_SERVER["argv"];
		for ($vCptArg =0;$vCptArg < count($vListeArgs); $vCptArg++){
			$vArg = $vListeArgs[$vCptArg];
			if (strncmp($vArg, "hostname", 8) == 0){ // recherche hostname
				return substr($vArg, 9);
			}
		}
		
		return "inconnu";
	}
}
?>
