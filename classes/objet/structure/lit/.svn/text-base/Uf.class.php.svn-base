<?php
require_once $BackToRoot."classes/objet/structure/Uf.class.php";

/**
 * Cet objet represente un service de type SAU
 * 
 * @package Object_Sturcture_Sau
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Structure_Lit_Uf  extends Objet_Structure_Uf{
	/**
	 * Type INVS du service
	 * @var int
	 */
	private $typeInvs;
	/**
	 * Nombre de lits installé
	 * @var int
	 */
	private $litsInstalles;
	/**
	 * Nombre de lits ouverts
	 * @var int
	 */
	private $litsOuverts;
	/**
	 * Nombre de lits occupés
	 * @var int
	 */
	private $litsOccupes;
	/**
	 * Nombre de lits supplémentaires
	 * @var int
	 */
	private $litsSupplementaires;
	/**
	 * Nombre de lits disponibles
	 * @var int
	 */
	private $litsDisponibles;
	/**
	 * Nombre de lits fermés
	 * @var int
	 */
	private $litsFermes;
	/**
	 * Nombre de place disponibles
	 * @var int
	 */
	private $places_disponibles;
	/**
	 * permission ???
	 * @var int
	 */
	private $permissions;
	
	function __construct($_uf = null) {
		if (isset($_uf)){
			$this->setId($_uf->getId());
			$this->setCode($_uf->getCode());
			$this->setNom($_uf->getNom());
		}
	}
	
	public function getTypeInvs(){
		return $this->typeInvs;
	}
	public function setTypeInvs($_typeInvs){
		$this->typeInvs = $_typeInvs;
	}
	
	public function getLitsInstalles(){
		return $this->litsInstalles;
	}
	public function setLitsInstalles($_litsInstalles){
		$this->litsInstalles = $_litsInstalles;
	}
	
	public function getLitsOuverts(){
		return $this->litsOuverts;
	}
	public function setLitsOuverts($_litsOuverts){
		$this->litsOuverts = $_litsOuverts;
	}
	
	public function getLitsOccupes(){
		return $this->litsOccupes;
	}
	public function setLitsOccupes($_litsOccupes){
		$this->litsOccupes = $_litsOccupes;
	}
	
	public function getLitsSupplementaires(){
		return $this->litsSupplementaires;
	}
	public function setLitsSupplementaires($_litsSupplementaires){
		$this->litsSupplementaires = $_litsSupplementaires;
	}
	
	public function getLitsDisponibles(){
		return $this->litsDisponibles;
	}
	public function setLitsDisponibles($_litsDisponibles){
		$this->litsDisponibles = $_litsDisponibles;
	}
	
	public function getLitsFermes(){
		return $this->litsFermes;
	}
	public function setLitsFermes($_litsFermes){
		$this->litsFermes = $_litsFermes;
	}
	
	public function getPlaces_disponibles(){
		return $this->places_disponibles;
	}
	public function setPlaces_disponibles($_places_disponibles){
		$this->places_disponibles = $_places_disponibles;
	}
	
	public function getPermissions(){
		return $this->permissions;
	}
	public function setPermissions($_permissions){
		$this->permissions = $_permissions;
	}
}
?>