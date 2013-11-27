<?php
require_once $BackToRoot."classes/dao/pool.class.php";

/**
 * Gestion des filtres
 * @package Dao
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author NOLDDOMI
 *
 */
class Dao_Filtre{
	/**
	 * Cherche les éléments d'un filtre
	 * @param $_sql
	 * @return String[] (cle =>ID, valeur =>LIBELLE)
	 */
	public static function ChercheElementFiltre($_sql){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare($_sql);
		$vPreparedStatment->execute();
		
		$vListeElement = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vListeElement[$vLigneObj->ID] = $vLigneObj->LIBELLE;
		}
		return $vListeElement;
	}
}
?>