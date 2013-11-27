<?php
require_once $BackToRoot."classes/objet/structure/Organisme.class.php";

/**
 * Cet objet represente un établissement de santé
 * 
 * @package Object_Sturcture
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Structure_Etablissement{
	/**
	 * Identifiant de l'établissement
	 * @var int
	 */
	private $id;
	/**
	 * Nom de l'établissement
	 * @var string
	 */
	private $nom;
	/**
	 * Code FINESS de l'établissement (http://finess.sante.gouv.fr/)
	 * @var string
	 */
	private $finess;
	/**
	 * Organisme auquel appartient cette établissement
	 * @var Objet_Structure_Organisme
	 */
	private $organisme = NULL;
	
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
	
	public function getFiness(){
		return $this->finess;
	}
	public function setFiness($_finess){
		$this->finess = $_finess;
	}
	
	public function getOrganisme(){
		return $this->organisme;
	}
	public function setOrganisme($_organisme){
		$this->organisme = $_organisme;
	}
	
//	public static function xmlVersObj($_documentRoot) {
//     	$vNoeudEtablissement = $_documentRoot->xpath('//DESCSERV');
//     	
//     	$vNoedFiness = $vNoeudEtablissement[0]->xpath('./id_etab');
//     	if (count($vNoedFiness) == 0)
//     		return null;
//     	
//     	$vFiness = ''.$vNoedFiness[0];
//     	if (!isset ($vFiness) || strlen($vFiness) ==  0)
//     		return null;
//     	
//     	$importXmlDAO = ImportXmlDAO::getInstance();
//     	return $importXmlDAO->chercheEtablissementParFiness($vFiness);
//    }
}
?>