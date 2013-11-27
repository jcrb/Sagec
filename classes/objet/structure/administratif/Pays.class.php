<?php

/**
 * Cet objet represente un pays
 * 
 * @package Object_Sturcture_Administratif
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Object_Sturcture_Administratif_Pays{
	/**
	 * Identifiant du  pays dans la base de données
	 * @var int
	 */
	private $id;
	/**
	 * Nom du pays
	 * @var string
	 */
	private $nom;
	/**
	 * Code ISO du pays sur 2 caractères
	 * @var string
	 */
	private $iso2;
	/**
	 * Code ISO du pays sur 3 caratères
	 * @var string
	 */
	private $iso3;
	
	public function getId(){
		return $this->id;	
	}
	public function setId($_id){
		$this->id = $_id;
	}
	
	public function getNom(){
		return $this->nom;
	}
	public function setNom($_nom){
		$this->nom = $_nom;
	}
	
	public function getIso2(){
		return $this->iso2;
	}
	public function setIso2($_iso2){
		$this->iso2 = $_iso2;
	}
	
	public function getIso3(){
		return $this->iso3;
	}
	public function setIso3($_iso3){
		$this->iso3 = $_iso3;
	}
}

?>