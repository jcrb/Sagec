<?php
/**
 * Cet objet represente un type de structure (service / uf)
 * 
 * @package Object_Sturcture
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */

class Objet_Structure_TypeStructure{
	/**
	 * Identifiant du type de structure (utilisé par la base de données)
	 * @var int
	 */
	private $id;
	/**
	 * Code associé au type de structure
	 * @var string
	 */
	private $code;
	/**
	 * Nom du type de structure
	 * @var string
	 */
	private $nom;
	
	public function getId(){
		return $this->id;
	}
	public function setId($_id){
		$this->id = $_id;
	}
	
	public function getCode(){
		return $this->code;
	}
	public function setCode($_code){
		$this->code = $_code;
	}
	
	public function getNom(){
		return $this->nom;
	}
	public function setNom($_nom){
		$this->nom = $_nom;
	}
}
?>