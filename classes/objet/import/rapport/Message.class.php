<?php
/**
 * Cet objet represente un message pour le rapport finale
 * 
 * Lvl 0 = Info (à afficher)
 * Lvl 1 = Debug
 * Lvl 2 = Info
 * Lvl 3 = Warning
 * Lvl 4 = Error
 * 
 * @package Objet_Import_Rapport
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Import_Rapport_Message{
	/**
	 * Niveau de log
	 * @var int
	 */
	private $niveau;
	/**
	 * Message du log
	 * @var string
	 */
	private $message;
	
	public function getNiveau(){
		return $this->niveau;
	}
	public function setNiveau($_niveau){
		$this->niveau = $_niveau;
	}
	
	public function getMessage(){
		return $this->message;
	}
	public function setMessage($_message){
		$this->message = $_message;
	}
}
?>