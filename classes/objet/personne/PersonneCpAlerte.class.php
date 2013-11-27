<?php
/**
 * Cet objet une "personne" en copie des mails d'alerte. Cela peut être une adresse mail générique.
 * 
 * @package Object_Personne
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Object_Personne_PersonneCpAlerte {
	/**
	 * Identifiant de la personne dans la base de données
	 * @var int
	 */
	private $id;
	/**
	 * Adresse mail (personne physique ou adresse générique)
	 * @var string
	 */
	private $mail;
	
	public function getId(){
		return $this->id;
	}
	public function setId($_id){
		$this->id = $_id;
	}
	
	public function getMail(){
		return $this->mail;
	}
	public function setMail($_mail){
		$this->mail = $_mail;
	}
}
?>