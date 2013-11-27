<?php
require_once $BackToRoot."classes/objet/import/RpuActe.class.php";

/**
 * Acces aux donnés pour les actes codées en CCAM
 * 
 * @package Dao_Veille
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author NOLDDOMI
 *
 */
class Dao_Veille_Acte{
	/**
	 * Cherche l'acte correspondant au code
	 * @param $_code
	 * @return unknown_type
	 */
	public static function ChercheActeParCode($_code){
		
		if (strlen(trim($_code)) == 0)
			return null;
			
		$vActe = new Objet_Import_RpuActe;
		
		$vActe->setCode($_code);
		
		return $vActe;
	}
}
?>