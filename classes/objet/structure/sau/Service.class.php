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
class Objet_Structure_Sau_Service  extends Objet_Structure_Service{
	/**
	 * Nombre d'urgences
	 * @var int
	 */
	private $nbUrgence =0;
	/**
	 * Nombre d'urgences de moins de 1 an
	 * @var int
	 */
	private $nbUrgMoins1an =0;
	/**
	 * Nombre d'urgence de plus de 75 ans
	 * @var int
	 */
	private $nbUrgPlus75ans =0;
	/**
	 * Nombre d'hospitalisation
	 * @var int
	 */
	private $nbHospitalisation =0;
	/**
	 * Nombre de transfert en UHCD
	 * @var int
	 */
	private $nbTransUhcd =0;
	/**
	 * Nombre de transfert vers d'autres services hospitaliers
	 * @var int
	 */
	private $nbTransAutre =0;
	
	function __construct($_service = null) {
		if (isset($_service)){
			$this->setId($_service->getId());
			$this->setCode($_service->getCode());
			$this->setNom($_service->getNom());
		}
	}
	
	public function getNbUrgence(){
		return $this->nbUrgence;
	}
	public function setNbUrgence($_nbUrgence){
		$this->nbUrgence = $_nbUrgence;
	}
	
	public function getNbUrgMoins1an(){
		return $this->nbUrgMoins1an;
	}
	public function setNbUrgMoins1an($_nbUrgMoins1an){
		$this->nbUrgMoins1an = $_nbUrgMoins1an;
	}
	
	public function getNbUrgPlus75ans(){
		return $this->nbUrgPlus75ans;
	}
	public function setNbUrgPlus75ans($_nbUrgPlus75ans){
		$this->nbUrgPlus75ans = $_nbUrgPlus75ans;
	}
	
	public function getNbHospitalisation(){
		return $this->nbHospitalisation;
	}
	public function setNbHospitalisation($_nbHospitalisation){
		$this->nbHospitalisation = $_nbHospitalisation;
	}
	
	public function getNbTransUhcd(){
		return $this->nbTransUhcd;
	}
	public function setNbTransUhcd($_nbTransUhcd){
		$this->nbTransUhcd = $_nbTransUhcd;
	}
	
	public function getNbTransAutre(){
		return $this->nbTransAutre;
	}
	public function setNbTransAutre($_nbTransAutre){
		$this->nbTransAutre = $_nbTransAutre;
	}
}
?>