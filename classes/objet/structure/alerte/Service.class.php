<?php
require_once $BackToRoot."classes/objet/structure/Service.class.php";

/**
 * Cet objet represente un Service
 * 
 * @package Objet_Sturcture_Alerte
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Sturcture_Alerte_Service extends Objet_Structure_Service{
	/**
	 * Date de dernière mise à jour de la structure
	 * @var (int, timestamp)
	 */
	private $dateMaj;
	
	public function getDateMaj(){
		return $this->dateMaj;
	}
	public function setDateMaj($_dateMaj){
		$this->dateMaj = $_dateMaj;
	}
}
?>