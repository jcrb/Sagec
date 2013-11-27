<?php
require_once $BackToRoot."classes/objet/structure/sau/Aggregation.class.php";

require_once $BackToRoot."classes/objet/exception/SqlException.class.php";
require_once $BackToRoot."classes/objet/exception/StructureNotFoundException.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";

/**
 * Accès aux données SAU de veille sanitaire
 * 
 * @package Dao_Structure
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Dao_Veille_Sau{
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
    
    public function ChercheDonneesSauParRegion($_region, $_dateDebut, $_dateFin){
    	
    }
    
    public function ChercheDonneesSauParDepartement($_departement, $_dateDebut, $_dateFin){
    	
    }
    
    public function ChercheDonnesSauParEtablissement($_etablissement, $_dateDebut, $_dateFin){
    	
    }
    
    public function ChercheDonnesSauParService($_service,  $_dateDebut, $_dateFin){
    	
    }
}
?>