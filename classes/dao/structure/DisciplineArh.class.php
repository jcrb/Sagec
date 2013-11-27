<?php
require_once $BackToRoot."classes/objet/structure/DisciplineArh.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";

/**
 * Accès aux disciplines pour regroupement ARH
 * 
 * @package Dao_Structure
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */

class Dao_Structure_DisciplineArh {
	/**
	 * Connexion à la base de données
	 * @var ??
	 */
	private $connexion = null;
	
	/**
	 * Cherche l'ensemble des disciplines (au sens ARH)
	 * @return Objet_Structure_DisciplineArh[]
	 */
	public function &ChercheDisciplines(){
		$vConnexion = $this->getConnexion();
		
		$vPreparedStatment = $vConnexion->prepare("SELECT A.CODE, A.DESC FROM DISCIPLINE_ARH A");
    	$vPreparedStatment->execute();
    	
    	$vListeDisciplines = array();
    	while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    		$vDisciplineArh = new Objet_Structure_DisciplineArh();
    		
    		$vDisciplineArh->setCode($vLigneObj->CODE);
    		$vDisciplineArh->setDescription($vLigneObj->DESC);
    		
    		$vListeDisciplines[] = $vDisciplineArh;
    	}
    	return $vListeDisciplines;
	}
	
	/**
	 * Cherche la discipline associée à ce code
	 * @param $_code (string): Code de la discipline
	 * @return Objet_Structure_DisciplineArh
	 */
	public function &ChercheDisciplineParCode($_code){
		$vConnexion = $this->getConnexion();
		
		$vPreparedStatment = $vConnexion->prepare("SELECT A.CODE, A.DESC FROM DISCIPLINE_ARH A WHERE A.CODE=?");
    	$vPreparedStatment->execute($_code);
    	
    	if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    		$vDisciplineArh = new Objet_Structure_DisciplineArh();
    		
    		$vDisciplineArh->setCode($vLigneObj->CODE);
    		$vDisciplineArh->setDescription($vLigneObj->DESC);
    		
    		return $vDisciplineArh;
    	}
    	throw new Objet_Exception_StructureNotFoundException ("Discipline non trouv&eacute; pour le code ".$_code);
	}
	
	public function getConnexion(){
		if (!isset($this->connexion)){
			$this->connexion = Dao_Pool::getConnexionPdo();
		}
		return $this->connexion;
	}
	
	public function setConnexion($_connexion){
		$this->connexion = $_connexion;
	}
}
?>