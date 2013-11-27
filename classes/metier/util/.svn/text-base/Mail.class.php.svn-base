<?php
if (!isset($BackToRoot)){
	$BackToRoot="../../../SAGEC67/";
}

class Metier_Util_Mail{
	/**
	 * transforme une liste d'adresse email pour l'utilisation
	 * @param $_listeAdresse
	 * @return unknown_type
	 */
	public static function ConcatMailAdresse(&$_listeAdresse){
		$vEstPremierPassage = true;
		
		$vAdresses = "";
		foreach ($_listeAdresse as $vAdresse){
			if (!$vEstPremierPassage){
				$vAdresses .= ", ";
			}
			if ($vAdresse instanceof Object_Personne_PersonneCpAlerte){
				$vAdresses .= $vAdresse->getMail();
			}
			else {
				$vAdresses .= $vAdresse;
			}
			
			$vEstPremierPassage = false;
		}
		return $vAdresses;
	}
}
?>