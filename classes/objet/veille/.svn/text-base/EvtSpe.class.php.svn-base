<?php
require_once $BackToRoot."classes/objet/veille/EvtSpeChamp.class.php";
/**
 * Cet objet represente un évènement spécial
 * 
 * @package Objet_Veille
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Veille_EvtSpe{
	/**
	 * Identifiant de l'évènement dans la base
	 * @var int
	 */
	private $id;
	/**
	 * Nom de l'évènement (pour la partie administration)
	 * @var String
	 */
	private $nom;
	/**
	 * Description de l'évènement (pour la partie administration)
	 * @var String
	 */
	private $description;
	/**
	 * Titre pour le bandeau de saisie (en HTML)
	 * @var String
	 */
	private $titre;
	/**
	 * Texte explicatif pour le beandeau de saisie (en HTML=
	 * @var String
	 */
	private $detail;
	/**
	 * Liste des champs de saisie pour cet évènement
	 * @var Objet_Veille_EvtSpeChamp[]
	 */
	private $listeChamps;
	/**
	 * vrai si l'évènement est actif
	 * @var boolean
	 */
	private $actif;
	
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
	
	public function getDescription(){
		return $this->description;
	}
	public function setDescription($_description){
		$this->description = $_description;
	}
	
	public function getTitre(){
		return $this->titre;
	}
	public function setTitre($_titre){
		$this->titre = $_titre;
	}
	
	public function getDetail(){
		return $this->detail;
	}
	public function setDetail($_detail){
		$this->detail = $_detail;
	}
	
	public function getListeChamps(){
		return $this->listeChamps;
	}
	public function setListeChamps($_listeChamps){
		$this->listeChamps = $_listeChamps;
	}
	public function addChamp($_champ){
		if (!isset($this->listeChamps))
			$this->listeChamps = array();
		$this->listeChamps[] = $_champ;
	}
	
	public function isActif(){
		return $this->actif;
	}
	public function setActif($_actif){
		$this->actif = $_actif;
	}
}
?>