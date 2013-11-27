<?php
/**
 * Occupation journalier des lits 
 * 
 * @package Objet_Import
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Import_LitsJour{
	/**
	 * Date de l'indicateur
	 * @var int (timestamp)
	 */
	private $jour;
	/**
	 * Liste des services Lit
	 * @var Objet_Structure_Lit_Service[]
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