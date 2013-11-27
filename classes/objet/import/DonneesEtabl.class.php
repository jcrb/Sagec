<?php
/**
 * Cet objet représente les données pour un établissement
 * 
 * @package Objet_Import
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Import_DonneesEtabl{
	/**
	 * Etablissement conerné par l'import
	 * @var Objet_Structure_Etablissement
	 */
	private $etablissement;
	/**
	 * Liste des indicateurs
	 * @var Objet_Import_IndicateurJour[]
	 */
	private $listeIndicateurJour = array();
	/**
	 * Liste des SAU
	 * @var Objet_Import_SauJour[]
	 */
	private $listeSauJour = array();
	/**
	 * Liste des SAMU
	 * @var Objet_Import_SamuJour[]
	 */
	private $listeSamuJour = array();
	/**
	 * Liste des occupation des lits[]
	 * @var Objet_Import_LisJour[]
	 */
	private $listeLitsJour = array();
	
	public function setEtablissement(&$_etablissement){
		$this->etablissement = $_etablissement;
	}
	public function &getEtablissement(){
		return $this->etablissement;
	}
	
	public function ajouterIndicateurJour(&$_indicateurJour){
		$this->listeIndicateurJour[] = $_indicateurJour;
	}
	public function &getListeIndicateurJour(){
		return $this->listeIndicateurJour;
	}
	
	public function ajouterSauJour(&$_sauJour){
		$this->listeSauJour[] = $_sauJour;
	}
	public function &getListeSauJour(){
		return $this->listeSauJour;
	}
	
	public function ajouterSamuJour(&$_samuJour){
		$this->listeSamuJour[] = $_samuJour;
	}
	public function &getListeSamuJour(){
		return $this->listeSamuJour;
	}
	
	public function ajouterLitsJour(&$_litsJour){
		$this->listeLitsJour[] = $_litsJour;
	}
	public function &getListeLitsJour(){
		return $this->listeLitsJour;
	}
}
?>