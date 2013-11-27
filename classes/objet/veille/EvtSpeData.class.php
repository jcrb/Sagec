<?php
/**
 * Cet objet represente une donnée d'un champ de saisie
 * 
 * @package Objet_Veille
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Veille_EvtSpeData{
	/**
	 * identifiant dans la base
	 * @var int
	 */
	private $id;
	/**
	 * etablissement concerné
	 * @var Objet_Structure_Etablissement
	 */
	private $etablissement;
	/**
	 * champ de saisie de l'évènement
	 * @var Objet_Veille_EvtSpeChamp
	 */
	private $champ;
	/**
	 * jour de la saisie
	 * @var Timestamp (int)
	 */
	private $jour;
	/**
	 * valeur saisie
	 * @var int
	 */
	private $valeur;
	
	public function getId(){
		return $this->id;
	}
	public function setId($_id){
		$this->id = $_id;
	}
	
	public function getEtablissement(){
		return $this->etablissement;
	}
	public function setEtablissement($_etablissement){
		$this->etablissement = $_etablissement;
	}
	
	public function getChamp(){
		return $this->champ;
	}
	public function setChamp($_champ){
		$this->champ = $_champ;
	}
	
	public function getJour(){
		return $this->jour;
	}
	public function setJour($_jour){
		$this->jour = $_jour;
	}
	
	public function getValeur(){
		return $this->valeur;
	}
	public function setValeur($_valeur){
		$this->valeur = $_valeur;
	}
}
?>