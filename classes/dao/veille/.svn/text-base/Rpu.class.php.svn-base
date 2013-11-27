<?php
require_once $BackToRoot."classes/objet/import/Rpu.class.php";
require_once $BackToRoot."classes/objet/import/RpuActe.class.php";
require_once $BackToRoot."classes/objet/import/RpuDiagnostique.class.php";

require_once $BackToRoot."classes/metier/util/Date.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";
/**
 * Accès aux données SAMU de veille sanitaire
 * 
 * @package Dao_Veille
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Dao_Veille_Rpu{
	/**
	 * Enregistre le RPU dans la base de données
	 * @param $_rpu (Objet_Import_Rpu) Rapport d'un passage
	 * @return
	 */
	public static function MajRpu (&$_rpu){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		// enregistre le RPU
		$vPreparedStatment = $vConnexion->prepare(
			"INSERT INTO rpu(finess, date_extraction, date_jour, sexe, date_naissance, zip, ville, date_entree, mode_entree,
				provenance, transport, transport_pec, motif, ccmu, diag_principal, date_sortie,
				mode_sortie, destination, orientation) 
			VALUES(?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
			);
		
		$vTabParam = array();
		$vTabParam[] = $_rpu->getEtablissement()->getFiness();
		$vTabParam[] = $_rpu->getDateExtraction();
		$vTabParam[] = $_rpu->getSexe();
		$vTabParam[] = Metier_Util_Date::StringDateVersMysqlDate($_rpu->getDateNaissance());
		$vTabParam[] = $_rpu->getCodePostal();
		$vTabParam[] = $_rpu->getVille();
		$vTabParam[] = Metier_Util_Date::StringDateVersMysqlDateTime($_rpu->getDateEntree());
		$vTabParam[] = $_rpu->getModeEntree();
		$vTabParam[] = $_rpu->getProvenance();
		$vTabParam[] = $_rpu->getModeTransport();
		$vTabParam[] = $_rpu->getTransportPEC();
		$vTabParam[] = $_rpu->getMotif();
		$vTabParam[] = $_rpu->getGravite();
		$vDiagPrincipal = $_rpu->getDiagPrincipal();
		if (is_object($vDiagPrincipal)){
			$vTabParam[] = $vDiagPrincipal->getCode();
		}
		else{
			$vTabParam[] = 0;
		}
		$vTabParam[] = Metier_Util_Date::StringDateVersMysqlDateTime($_rpu->getDateSortie());;
		$vTabParam[] = $_rpu->getModeSortie();
		$vTabParam[] = $_rpu->getDestination();
		$vTabParam[] = $_rpu->getOrientation();
				
		$vPreparedStatment->execute($vTabParam);
				
		$vRpuId = $vConnexion->lastInsertId();
		
		// enregistre les diagnostiques associes
		foreach ($_rpu->getDiagAssocie() as $vDiagAssocie){
			$vPreparedStatment = $vConnexion->prepare("INSERT INTO rpu_diagAssocie(rpu_ID,diag_ID) VALUES(?, ?)");
			$vPreparedStatment->execute(array($vRpuId, $vDiagAssocie->getCode()));
		}
		
		// enregistre les actes
		foreach ($_rpu->getActes() as $vActe){
			$vPreparedStatment = $vConnexion->prepare("INSERT INTO rpu_actes (rpu_ID,acte_ID) VALUES(?, ?)");
			$vPreparedStatment->execute(array($vRpuId, $vActe->getCode()));
		}
	}
}
?>