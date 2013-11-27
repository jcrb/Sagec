<?php
require_once $BackToRoot."classes/objet/structure/TypeStructure.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";
/**
 * Accès aux données pour une structure de type type service / uf
 * 
 * @package Dao_Structure
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Dao_Structure_TypeStructure{
	private static $instance;
	/**
	 * Singleton pour l'accès aux données
	 * @return
	 */
    public static function getInstance() 
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        
        return self::$instance;
    }
    
    /**
     * Retourne la liste des type de structure
     * @return Objet_Structure_TypeStructure[]
     */
    public function &ListeTypeStructure(){
    	$vConnexion = Dao_Pool::getConnexionPdo();
    	
    	$vPreparedStatment = $vConnexion->prepare("SELECT Type_ID, type_nom, type_nom_complet FROM type_service ORDER BY type_nom");
    	$vPreparedStatment->execute();
    	
    	$vListeTypeStructure = array();
    	while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    		$vTypeStructure = new Objet_Structure_TypeStructure;
    		
    		$vTypeStructure->setId($vLigneObj->Type_ID);
    		$vTypeStructure->setCode($vLigneObj->type_nom);
    		$vTypeStructure->setNom($vLigneObj->type_nom_complet);
    		
    		$vListeTypeStructure[] = $vTypeStructure;
    	}
    	return $vListeTypeStructure;
    }
}
?>