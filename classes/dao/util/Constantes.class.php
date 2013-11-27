<?php
require_once $BackToRoot."classes/metier/util/host.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";

/**
 * Acc�s aux constantes stok�es en base 
 * 
 * @package Dao_Util
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */

class Dao_Util_Constantes{
	/**
	 * Cherche l'ensemble des constantes associ�es � la cl�
	 * @param $_cle
	 * @return unknown_type
	 */
	public static function LectureConstante($_cle){
		$vConnexion = Dao_Pool::getConnexionPdo(); // l�ve un PDOException s'il y a un probl�me � la connexion
		
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