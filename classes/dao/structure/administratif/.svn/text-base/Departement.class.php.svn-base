<?php
require_once $BackToRoot."classes/objet/structure/administratif/Departement.class.php";
require_once $BackToRoot."classes/objet/structure/administratif/Region.class.php";

require_once $BackToRoot."classes/objet/exception/SqlException.class.php";
require_once $BackToRoot."classes/objet/exception/StructureNotFoundException.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";

/**
 * Accès aux données pour une structure de type département
 * 
 * @package Dao_Structure_Administratif
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Dao_Structure_Administratif_Departement{
	/**
	 * Retourne la liste des départements pour unu region si celui ci est donnée en paramètre
	 * @param Object_Sturcture_Administratif_Region: juste les département de cette région
	 * @return Object_Sturcture_Administratif_Departement[]
	 * /!\ PDOException
	 */
	public static function &ListeDepartement(&$_region =null){
		$vConnexion = Dao_Pool::getConnexionPdo(); // lève un PDOException s'il y a un problème à la connexion
		
		$vSql = "SELECT D.departement_ID, D.departement_nom, R.region_ID, R.region_nom FROM departement D LEFT JOIN region R ON D.region_ID=R.Region_ID";
		$vParam = null;
		
		if (isset ($_region)){
			$vIdRegion = $_region->getId();
			if (isset($vIdRegion)){
				$vSql .= " WHERE R.region_ID = ?";
				$vParam = array($_region->getId());
			}
			else {
				$vNomRegion = $_region->getNom();
				if (isset($vNomRegion)){
					$vSql .= " WHERE R.region_nom = ?";
					$vParam = array($_region->getNom());
				}
			}
		}
		
		$vPreparedStatment = $vConnexion->prepare($vSql);
		$vPreparedStatment->execute($vParam);
		
		$vListeDepartement = array();
		$vListeRegion = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vDepartement = new Object_Sturcture_Administratif_Departement;
		 	$vDepartement->setId($vLigneObj->departement_ID);
		 	$vDepartement->setCode($vLigneObj->departement_ID);
		 	$vDepartement->setNom($vLigneObj->departement_nom);
		 	
		 	// gestion des régions
		 	if (isset ($vListeRegion[$vLigneObj->region_ID])){
		 		$vDepartement->setRegion($vListeRegion[$vLigneObj->region_ID]);
		 	}
		 	else {
		 		$vRegion = new Objet_Sturcture_Administratif_Region;
		 		$vRegion->setId($vLigneObj->region_ID);
		 		$vRegion->setCode($vLigneObj->region_ID);
		 		$vRegion->setNom($vLigneObj->region_nom);
		 		
		 		$vListeRegion[$vLigneObj->region_ID] = $vRegion;
		 		
		 		$vDepartement->setRegion($vRegion);
		 	}
		 	
		 	$vListeDepartement[] = $vDepartement;
		}
		return $vListeDepartement;
	}
}
?>