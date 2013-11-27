<?php
/**
 * Cet objet represente une discipline. Elle est utilisé pour effectuer des regroupements pour l'ARH
 * 
 * @package Object_Sturcture
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */

class Objet_Structure_DisciplineArh {
	/**
	 * Code de la discimpline (on peut voir cette variable comme le nom court)
	 * @var string
	 */
	private $code;
	/**
	 * Description de la descipline (on peut voir cette variable comme un nom long)
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