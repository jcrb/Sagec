<?php
/**
 * Diagnostique principal ou associé (codage CIM10)
 * 
 * @package Objet_Import
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Import_RpuDiagnostique{
	/**
	 * Code de l'acte dans la base
	 * @var string
	 */
	private $code;
	/**
	 * Description de l'acte
	 * @var unknown_type
	 */
	private $description;
	
	public function getCode(){
		return $this->code;
	}
	public function setCode($_code){
		$this->code = $_code;
	}
	
	public function getDescription(){
		return $this->description;
	}
	public function setDescription($_description){
		$this->description = $_description;
	}
}
?>