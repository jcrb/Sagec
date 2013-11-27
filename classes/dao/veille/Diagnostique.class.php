<?php
require_once $BackToRoot."classes/objet/import/RpuDiagnostique.class.php";

/**
 * Acces aux donnés pour les dignostiques codées en CIM10
 * 
 * @package Dao_Veille
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author NOLDDOMI
 *
 */
class Dao_Veille_Diagnostique{
	/**
	 * Cherche le diagnostique correspondant au code passé en paramètre
	 * @param $_code
	 * @return Objet_Import_RpuDiagnostique
	 */
	public static function ChercheDiagnostiqueParCode($_code){
		
		if (strlen(trim($_code)) == 0)
			return null;
			
		$vDiagnostique = new Objet_Import_RpuDiagnostique;
		
		$vDiagnostique->setCode($_code);
		
		return $vDiagnostique;
	}
}
?>