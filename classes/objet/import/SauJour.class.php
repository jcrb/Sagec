<?php
/**
 * Indicateurs SAU journalier
 * 
 * @package Objet_Import
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Import_SauJour{
	/**
	 * Date de l'indicateur
	 * @var int (timestamp)
	 */
	private $jour;
	/**
	 * Liste des services SAU
	 * @var Objet_Structure_Sau_Service[]
	 */
	private $listeService = array();
	
	public function getJour(){
		return $this->jour;
	}
	public function setJour($_jour){
		$this->jour = $_jour;
	}
	
	public function ajouterService($_service){
		$this->listeService[] = $_service;
	}
	public function &getListeService(){
		return $this->listeService;
	}
}
?>