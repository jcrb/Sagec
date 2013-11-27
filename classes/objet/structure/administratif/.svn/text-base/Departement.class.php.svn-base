<?php
require_once $BackToRoot."classes/objet/structure/administratif/Region.class.php";

/**
 * Cet objet represente un département
 * 
 * @package Object_Sturcture_Administratif
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Object_Sturcture_Administratif_Departement{
	/**
	 * Identifiant du département dans la base de données
	 * @var int
	 */
	private $id;
	/**
	 * Code du département (pour la france, utilisation du code INSEE)
	 * @var string
	 */
	private $code;
	/**
	 * Nom du département
	 * @var string
	 */
	private $nom;
	/**
	 * Région auquel appartien le département
	 * @var Object_Sturcture_Administratif_Region
	 */
	private $region;

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
	
	public function getRegion(){
		return $this->region;
	}
	public function setRegion(&$_region){
		$this->region = $_region;
	}
}
?>