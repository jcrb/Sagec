<?php
require_once $BackToRoot."classes/objet/veille/EvtSpe.class.php";
/**
 * Cet objet represente un champ pour la saisie d'un évènement spécial
 * 
 * @package Objet_Veille
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Veille_EvtSpeChamp{
	/**
	 * Identifant du champ
	 * @var int
	 */
	private $id;
	/**
	 * Evenement auquel appartient la zone de saisie
	 * @var Objet_Veille_EvtSpe
	 */
	private $evenement;
	/**
	 * Label à afficher avant la zone de saisie
	 * @var String
	 */
	private $label;
	/**
	 * Label court (pour récapitualtif)
	 * @var String
	 */
	private $labelCr;
	/**
	 * Déscription du champ
	 * @var String
	 */
	private $aide;
	/**
	 * Elément à ajouter dans le input pour la saisie (class par exemple)
	 * @var String
	 */
	private $input;
	/**
	 * Ordre d'affichage des champs
	 * @var int
	 */
	private $ordre;
	
	public function getId(){
		return $this->id;
	}
	public function setId($_id){
		$this->id = $_id;
	}
	
	public function getEvenement(){
		return $this->evenement;
	}
	public function setEvenement($_evenement){
		$this->evenement = $_evenement;
	}
	
	public function getLabel(){
		return $this->label;
	}
	public function setLabel($_label){
		$this->label = 	$_label;
	}
	
	public function getLabelCr(){
		return $this->labelCr;
	}
	public function setLabelCr($_labelCr){
		$this->labelCr = $_labelCr;
	}
	
	public function getAide(){
		return $this->aide;
	}
	public function setAide($_aide){
		$this->aide = $_aide;
	}
	
	public function getInput(){
		return $this->input;	
	}
	public function setInput($_input){
		$this->input = $_input;
	}
	public function getOrdre(){
		return $this->ordre;
	}
	public function setOrdre($_ordre){
		$this->ordre=$_ordre;
	}
}
?>