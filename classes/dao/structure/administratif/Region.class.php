<?php
require_once $BackToRoot."classes/objet/structure/administratif/Region.class.php";
require_once $BackToRoot."classes/objet/structure/administratif/Pays.class.php";

require_once $BackToRoot."classes/objet/exception/SqlException.class.php";
require_once $BackToRoot."classes/objet/exception/StructureNotFoundException.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";

/**
 * Accès aux données pour une structure de type region
 * 
 * @package Dao_Structure_Administratif
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Dao_Structure_Administratif_Region{
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
	 * Retourne la liste des régions pour un pays si celui ci est donné en paramètre
	 * @return Object_Sturcture_Administratif_Region[]
	 * /!\ PDOException
	 */
	public static function &ListeRegion(){
		$vConnexion = Dao_Pool::getConnexionPdo(); // lève un PDOException s'il y a un problème à la connexion
		
		$vPreparedStatment = $vConnexion->prepare("SELECT region_ID, region_nom from region");
		$vPreparedStatment->execute();
		
		$vListeRegion = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vRegion = new Objet_Sturcture_Administratif_Region;
		 	$vRegion->setId($vLigneObj->region_ID);
		 	$vRegion->setCode($vLigneObj->region_ID);
		 	$vRegion->setNom($vLigneObj->region_nom);
		 	
		 	$vListeRegion[] = $vRegion;
		}
		return $vListeRegion;
	}
	
	/**
	 * Retourne la région correspondant au code passé en parametre.
	 * @param $_codeRegion
	 * @return Object_Sturcture_Administratif_Region ou NULL si aucunne région ne correspond au code
	 * /!\ PDOException
	 */
	public function ChercheRegionParCode($_codeRegion){
		$vConnexion = Dao_Pool::getConnexionPdo(); // lève un PDOException s'il y a un problème à la connexion
		
		$vPreparedStatment = $vConnexion->prepare("SELECT region_ID, region_nom from region WHERE region_ID=?");
		$vPreparedStatment->execute(array($_codeRegion));
		$vPreparedStatment->execute();
		
		$vRegion = new Objet_Sturcture_Administratif_Region;
		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vRegion->setId($vLigneObj->region_ID);
		 	$vRegion->setCode($vLigneObj->region_ID);
		 	$vRegion->setNom($vLigneObj->region_nom);
		 	return $vRegion;
		}
		else {
			return NULL;
		}
	}
}
?>