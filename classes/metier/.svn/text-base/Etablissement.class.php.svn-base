<?php
require_once $BackToRoot."classes/dao/structure/Etablissement.class.php";
/**
 * Traitement lier à un établissement
 * 
 * @package Metier
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */

class Metier_Etablissement{
	private $etablissementDao = null; // (Dao_Structure_Service)
	
	/**
	 * Cherche les établissements correspondant à la liste d'ID 
	 * @param unknown_type $_listeId: int[] liste d'ID
	 * @return Objet_Structure_Etablissement[] (utilisation de l'Id comme indexe)
	 */
	public function ChercheEtablissementsParIds(&$_listeId){
		$vEtablissementDao = $this->getEtablissementDao();
		
		return $vEtablissementDao->ChercheEtablissementsParIds($_listeId);
	}
	
	public function getEtablissementDao(){
		if(!isset($this->etablissementDao)){
			$this->etablissementDao = Dao_Structure_Etablissement::getInstance();
		}
		return $this->etablissementDao;
	}
	
	public function setEtablissementDao (&$_etablissementDao){
		$this->etablissementDao = $_etablissementDao;
	}
}
?>