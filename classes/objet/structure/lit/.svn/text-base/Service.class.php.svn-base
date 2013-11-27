<?php
require_once $BackToRoot."classes/objet/structure/Service.class.php";

/**
 * Cet objet represente un service de type SAU
 * 
 * @package Object_Sturcture_Sau
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Structure_Lit_Service  extends Objet_Structure_Service{
	/**
	 * Type INVS du service
	 * @var int
	 */
	private $typeInvs;
	/**
	 * Nombre de lits installé
	 * @var int
	 */
	private $litsInstalles =0;
	/**
	 * Nombre de lits ouverts
	 * @var int
	 */
	private $litsOuverts =0;
	/**
	 * Nombre de lits occupés
	 * @var int
	 */
	private $litsOccupes =0;
	/**
	 * Nombre de lits supplémentaires
	 * @var int
	 */
	private $litsSupplementaires =0;
	/**
	 * Nombre de lits disponibles
	 * @var int
	 */
	private $litsDisponibles =0;
	/**
	 * Nombre de lits fermés
	 * @var int
	 */
	private $litsFermes =0;
	/**
	 * permission ???
	 * @var int
	 */
	private $permissions =0;
	
	/**
	 * Date de mise à jour
	 * @var int, timestamp
	 */
	private $dateMaj;
	
	/**
	 * Places disponibles
	 * @var int
	 */
	private $placesDispo =0;
	
	/**
	 * Places autorisées
	 * @var int
	 */
	private $placesAuto =0;
	/**
	 * Lits de réanimation
	 * @var int
	 */
	private $litsSpe1 =0;
	/**
	 * Lits adultes 
	 * @var int
	 */
	private $litsSpe2 =0;
	/**
	 * Lits enfants
	 * @var int
	 */
	private $litsSpe3 =0;
	/**
	 * Lits adultes non ventilés
	 * @var int
	 */
	private $litsSpe4 =0;
	/**
	 * Lits adultes ventilés
	 * @var int
	 */
	private $litsSpe5 =0;
	/**
	 * Lits enfants non ventilés
	 * @var int
	 */
	private $litsSpe6 =0;
	/**
	 * Lits enfants ventilés
	 * @var int
	 */
	private $litsSpe7 =0;
	/**
	 * Nombre de respirateur
	 * @var int
	 */
	private $litsRespirateur =0;
	/**
	 * Lits d'isolement
	 * @var int
	 */
	private $litsIsolement =0;

	public function addUf($_uf){
		if (!isset ($this->listeUf)){
			$this->listeUf = array();
		}
		$this->listeUf[] = $_uf;
	}
	
	function __construct($_service = null) {
		if (isset($_service)){
			$this->setId($_service->getId());
			$this->setCode($_service->getCode());
			$this->setNom($_service->getNom());
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
	
	public function getPermissions(){
		return $this->permissions;
	}
	public function setPermissions($_permissions){
		$this->permissions = $_permissions;
	}
	
	public function getDateMaj(){
		return $this->dateMaj;
	}
	public function setDateMaj($_dateMaj){
		$this->dateMaj = $_dateMaj;
	}
	
	public function getPlacesDispo(){
		return $this->placesDispo;
	}
	public function setPlacesDispo($_placesDispo){
		$this->placesDispo = $_placesDispo;
	}
	
	public function getPlacesAuto(){
		return $this->placesAuto;
	}
	
	public function setPlacesAuto($_placesAuto){
		$this->placesAuto = $_placesAuto;
	}
	
	public function getLitsSpe1(){
		return $this->litsSpe1;
	}
	public function setLitsSpe1($_litsSpe1){
		$this->litsSpe1 = $_litsSpe1;
	}
	
	public function getLitsSpe2(){
		return $this->litsSpe2;
	}
	public function setLitsSpe2($_litsSpe2){
		$this->litsSpe2 = $_litsSpe2;
	}
	
	public function getLitsSpe3(){
		return $this->litsSpe3;
	}
	public function setLitsSpe3($_litsSpe3){
		$this->litsSpe3 = $_litsSpe3;
	}
	
	public function getLitsSpe4(){
		return $this->litsSpe4;
	}
	public function setLitsSpe4($_litsSpe4){
		$this->litsSpe4 = $_litsSpe4;
	}
	
	public function getLitsSpe5(){
		return $this->litsSpe5;
	}
	public function setLitsSpe5($_litsSpe5){
		$this->litsSpe5 = $_litsSpe5;
	}
	
	public function getLitsSpe6(){
		return $this->litsSpe6;
	}
	public function setLitsSpe6($_litsSpe6){
		$this->litsSpe6 = $_litsSpe6;
	}
	
	public function getLitsSpe7(){
		return $this->litsSpe7;
	}
	public function setLitsSpe7($_litsSpe7){
		$this->litsSpe7 = $_litsSpe7;
	}
	
	public function getLitsRespirateur(){
		return $this->litsRespirateur;
	}
	public function setLitsRespirateur($_litsRespirateur){
		$this->litsRespirateur = $_litsRespirateur;
	}
	
	public function getLitsIsolement(){
		return $this->litsIsolement;
	}
	public function setLitsIsolement($_litsIsolement){
		$this->litsIsolement = $_litsIsolement;
	}
}
?>