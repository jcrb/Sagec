<?php
require_once $BackToRoot."classes/objet/structure/Etablissement.class.php";

/**
 * Cet objet represente un Etablissement
 * 
 * @package Objet_Sturcture_Alerte
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Sturcture_Alerte_Etablissement extends Objet_Structure_Etablissement{
	/**
	 * Adresse email pour l'envoie de mail d'alerte
	 * @var string
	 */
	private $mail;
	/**
	 * Date de dernière mise à jour (pas encore utilisé)
	 * @var int, timestamp
	 */
	private $date;
	/**
	 * Vrai si l'alerte est active
	 * @var bool
	 */
	private $actif;
	
	public function getMail(){
		return $this->mail;
	}
	public function setMail($_mail){
		$this->mail = $_mail;
	}
	
	public function getDate(){
		return $this->date;
	}
	public function setDate($_date){
		$this->date = $_date;
	}
	
	public function estActif(){
		return $this->actif;
	}
	public function setActif($_actif){
		$this->actif = $_actif;
	}
}
?>