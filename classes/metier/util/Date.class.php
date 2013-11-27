<?php
/**
 * Traitement autour des dates
 * 
 * @package Metier_Import
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */

class Metier_Util_Date{
	/**
	 * Converti une chaîne de caractère en date.
	 * Nous supposont que la date est au format YYYY-MM-JJ
	 * @param _date (string): date à convertir
	 * @return timestamp correspondant à la date
	 */
	public static function StringDateVersTimestamp ($_date){
	
		date_default_timezone_set("Europe/Paris");
		
		$vDate = trim($_date);
		$vNbOccur = substr_count($vDate, " ");
		
		if ($vNbOccur == 1){
			// c'est un format date / heure
			// pour simplifier on suppose que la date est au format JJ/MM/AAAA HH:MM:SS (à compléter s'il y a d'autres cas)
			
			list($vDateDate, $vDateHeure) = split(" ", $vDate, 2);
			list($vJour, $vMois, $vAnnee) = split ("/", $vDateDate, 3);
			$vTabHeure = split(":", $vDateHeure);
			
			$vHeure = $vTabHeure[0];
			$vMinute = $vTabHeure[1];
			if (count($vTabHeure) > 2){
				$vSeconde = $vTabHeure[2];
			}
			else {
				$vSeconde = 0;
			}
			
			return mktime ($vHeure, $vMinute, $vSeconde, $vMois, $vJour, $vAnnee);
		}
		else {
			// c'est juste la date
			
			// recherche des séparateurs
			$vTabSeparateur = array();
			for ($vCpt =0; $vCpt < strlen($vDate); $vCpt ++){
				if (!ctype_digit($vDate[$vCpt])){
					$vTabSeparateur[] = $vCpt;
				}
			}
			
			// représentation des séparateur en chaîne
			$vImgSep = "";
			foreach ($vTabSeparateur as $vSep){
				$vImgSep .= strval($vSep);
			}
			
			// traitement de la date
			switch ($vImgSep) {
				case "":
					// il n'y a pas de séparateur. 
					if (strlen($_date) == 8){
						// On suppose que la date est au format AAAAMMJJ
						$vAnnee = intval(substr($_date, 0, 4));
			    		$vMois = intval(substr($_date, 4, 2));
			    		$vJour = intval(substr($_date, 6, 2));
					}
					else {
						// On suppose que la date est au format AAMMJJ
						$vAnnee = intval(substr($_date, 0, 2));
				    	$vMois = intval(substr($_date, 2, 2));
				    	$vJour = intval(substr($_date, 4, 2));
				    	
					}
					break;
				case "47":
					// On suppose que la date est au format AAAA/MM/JJ
					$vAnnee = intval(substr($_date, 0, 4));
		    		$vMois = intval(substr($_date, 5, 2));
		    		$vJour = intval(substr($_date, 8, 2));
					break;
				case "25":
					// On suppose que la date est au format JJ/MM/AAAA
					$vJour = intval(substr($_date, 0, 2));
		    		$vMois = intval(substr($_date, 3, 2));
		    		$vAnnee = intval(substr($_date, 6, 4));
					break;
				case "4":
					// On suppose que la date est au format AAAA/MM
					$vAnnee = intval(substr($_date, 0, 4));
		    		$vMois = intval(substr($_date, 5, 2));
		    		$vJour = 1;
					break;
				case "2":
					// On suppose que la date est au format AA/MM
					$vAnnee = intval(substr($_date, 0, 2));
		    		$vMois = intval(substr($_date, 3, 2));
		    		$vJour = 1;
					break;
				default:
					// on ne sais pas convertir
					break;
			};
			
			//TODO: Attention au cas "pas de conversion"
			if ($vMois != 0 && $vAnnee < 100){
				if ($vAnnee < 50){
		    		$vAnnee += 2000;
		    	}
		    	else {
		    		$vAnnee += 1900;
		    	}
			}
	
			return mktime (0, 0 ,0, $vMois, $vJour, $vAnnee);
		}
	}
	
	/**
	 * Retourne le début de la journée
	 * @param $_timestamp (int, timestamp)
	 * @return (int, timestamp)
	 */
	public static function DebutJour ($_timestamp){
		date_default_timezone_set("Europe/Paris");
		
		$vDate = date('d/m/Y H:i:s', $_timestamp);
		list($vDateDate, $vDateHeure) = split(' ', $vDate);
		
		list($vHeure, $vMinute, $vSeconde) = split (':', $vDateHeure);
		
		$vTimestampDebut = $_timestamp - intval($vHeure) *60 *60 - intval($vMinute) *60 - intval($vSeconde);
		
		return $vTimestampDebut;
	}
	
	/**
	 * Converti un timestamp en chaine de caractère lisible
	 * @param $_timstamp
	 * @return string
	 */
	public static function TimestampDateVersString ($_timestamp){
		date_default_timezone_set("Europe/Paris");
		
		$vDate = date('d/m/Y H:i:s', $_timestamp);
		return $vDate;
	}
	
	/**
	 * Transforme un timstamp en datetime mysql
	 * @param $_timstamp(int)
	 * @return string
	 */
	public static function TimestampVersMysqlDateTime($_timstamp){
		date_default_timezone_set("Europe/Paris");
		return date ('Y-m-d H:i:s', $_timstamp); //YYYY-MM-DD HH:MM:SS
	}
	
	/**
	 * Transforme une date standard (JJ/MM/AAAA hh:mm:ss) en datetime mysql
	 * @param $_stringDate(string)
	 * @return string
	 */
	public static function StringDateVersMysqlDateTime($_stringDate){
		return Metier_Util_Date::TimestampVersMysqlDateTime(Metier_Util_Date::StringDateVersTimestamp($_stringDate));
	}
	
	/**
	 * Transforme un timstamp en date mysql
	 * @param $_timstamp(int)
	 * @return string
	 */
	public static function TimestampVersMysqlDate($_timstamp){
		date_default_timezone_set("Europe/Paris");
		return date ('Y-m-d', $_timstamp); //YYYY-MM-DD HH:MM:SS
	}
	
	/**
	 * Transforme une date standard (JJ/MM/AAAA hh:mm:ss) en datetime mysql
	 * @param $_stringDate(string)
	 * @return string
	 */
	public static function StringDateVersMysqlDate($_stringDate){
		return Metier_Util_Date::TimestampVersMysqlDate(Metier_Util_Date::StringDateVersTimestamp($_stringDate));
	}
}
?>