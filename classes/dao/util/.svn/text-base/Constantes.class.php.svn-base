<?php
require_once $BackToRoot."classes/metier/util/host.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";

/**
 * Accès aux constantes stokées en base 
 * 
 * @package Dao_Util
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */

class Dao_Util_Constantes{
	/**
	 * Cherche l'ensemble des constantes associées à la clé
	 * @param $_cle
	 * @return unknown_type
	 */
	public static function LectureConstante($_cle){
		$vConnexion = Dao_Pool::getConnexionPdo(); // lève un PDOException s'il y a un problème à la connexion
		
		$vPreparedStatment = $vConnexion->prepare("SELECT cle_valeur FROM cles WHERE cle_nom=? AND cle_host=?");
		$vPreparedStatment->execute(array($_cle, Metier_Util_Host::getHostCourt()));
		
		$vListeConstante = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vListeConstante[] = $vLigneObj->cle_valeur;
		}
		return $vListeConstante;
	}
}
?>