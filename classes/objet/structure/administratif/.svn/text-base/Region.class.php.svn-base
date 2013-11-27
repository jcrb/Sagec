<?php
require_once $BackToRoot."classes/objet/structure/administratif/Pays.class.php";

/**
 * Cet objet represente une région
 * 
 * @package Objet_Sturcture_Administratif
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Sturcture_Administratif_Region{
	/**
	 * Identifiant de la région dans la base de données
	 * @var int
	 */
	private $id;
	/**
	 * Code de la région (pour la france, utilisation du code INSEE)
	 * @var string
	 */
	private $code;
	/**
	 * Nom de la région
	 * @var string
	 */
	private $nom;
	/**
	 * pays auquel appartien la région
	 * @var Object_Sturcture_Administratif_Pays
	 */
	private $pays;

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
	
	public function getPays(){
		return $this->pays;
	}
	public function setPays(&$_pays){
		$this->pays = $_pays;
	}
}
?>