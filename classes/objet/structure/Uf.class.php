<?php
/**
 * Cet objet represente une unit� fonctionnelle
 * 
 * @package Object_Sturcture
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Structure_Uf{
/**
	 * Identifiant de l'UF (utilis� par la base de donn�es)
	 * @var int
	 */
	private $id;
	/**
	 * Code associ� � l'UF
	 * @var string
	 */
	private $code;
	/**
	 * Nom de l'UF
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