<?php
/**
 * Paramères d'un filtre 
 * @author NOLDDOMI
 *
 */
class Objet_filtre_Filtre{
	/**
	 * requête SQL pour générer la liste de choix
	 * @var String
	 */
	private $sqlListe;
	/**
	 * Id si aucun élément n'est selectionnée par défault
	 * @var String
	 */
	private $noSelectId;
	/**
	 * Libellé si aucun élément n'est sélectionné par défaut
	 * @var String
	 */
	private $noSelectLibelle;
	/**
	 * Id(s) à selectionner par defaut (pour le filre unitaire on prend le premier)
	 * @var String[]
	 */
	private $listeDefaultId;
	/**
	 * Liste des paramètres (dépendence vers les autres filtres)
	 * @var String[]
	 */
	private $listeParam;
	/**
	 * Clause where pour ce filtre
	 * @var String
	 */
	private $sqlWhere;
	/**
	 * Tous les élément s'il n'y a rien dans le filtre
	 * @var String
	 */
	private $inAll;
	
	public function getSqlListe(){
		return $this->sqlListe;
	}
	public function setSqlListe($_sqlListe){
		$this->sqlListe = $_sqlListe;
	}
	
	public function getNoSelectId(){
		return $this->noSelectId;
	}
	public function setNoSelectId($_noSelectId){
		$this->noSelectId = $_noSelectId;
	}
	
	public function getNoSelectLibelle(){
		return $this->noSelectLibelle;
	}
	public function setNoSelectLibelle($_noSelectLibelle){
		$this->noSelectLibelle = $_noSelectLibelle;
	}
	
	public function getListeDefaultId(){
		return $this->listeDefaultId;
	}
	public function setListeDefaultId($_listeDefaultId){
		$this->listeDefaultId = $_listeDefaultId;
	}
	public function addListeDefaultId($_defaultId){
		if (!isset($this->listeDefaultId)){
			$this->listeDefaultId = array();
		}
		$this->listeDefaultId[] = $_defaultId;
	}
	
	public function getListeParam(){
		return $this->listeParam;
	}
	public function setListeParam($_listeParam){
		$this->listeParam = $_listeParam;
	}
	public function addListeParam($_param){
		if (!isset($this->listeParam)){
			$this->listeParam = array();
		}
		$this->listeParam[] = $_param;
	}
	
	public function getSqlWhere(){
		return $this->sqlWhere;		
	}
	public function setSqlWhere($_sqlWhere){
		$this->sqlWhere = $_sqlWhere;
	}
	
	public function getInAll(){
		return $this->inAll;
	}
	public function setInAll($_inAll){
		$this->inAll = $_inAll;
	}
}
?>