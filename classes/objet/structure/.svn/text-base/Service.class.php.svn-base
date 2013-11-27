<?php
require_once $BackToRoot."classes/objet/structure/Uf.class.php";

/**
 * Cet objet represente un service
 * 
 * @package Object_Sturcture
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Structure_Service{
	/**
	 * Identifiant du service (utilisé par la base de données)
	 * @var int
	 */
	private $id;
	/**
	 * Code associé au service
	 * @var string
	 */
	private $code;
	/**
	 * Nom du service
	 * @var string
	 */
	private $nom;
	/**
	 * Liste des UF associer à ce service
	 * @var Objet_Structure_Uf[];
	 */
	private $listeUf;
	
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
	
	public function &getListeUf(){
		return $this->listeUf;
	}
	public function ajouterUf(&$_uf){
		$this->listeUf[] = $_uf;
	}
}
?>