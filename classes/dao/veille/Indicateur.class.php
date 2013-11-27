<?php
require_once $BackToRoot."classes/objet/import/IndicateurJour.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";
/**
 * Accès aux données pour les indicateurs de veille sanitaire
 * 
 * @package Dao_Structure
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Dao_Veille_Indicateur{
	/**
	 * Mise à jour de l'indicateur de veille sanitaire
	 * @param _etablissement (Objet_Structure_Etablissement): objet établissement
	 * @param _indicateur (Objet_Import_IndicateurJour): indicateur à mettre à jour
	 * @return (bool) true si l'indicateur est mis à jour
	 */
	public static function MajIndicateurVeille (&$_etablissement, &$_indicateur){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vOrganismeId = "NULL"; // NULL est un bout de la requête SQL
		if ($_etablissement->getOrganisme() != NULL){
			$vOrganismeId = $_etablissement->getOrganisme()->getId();
		}
		
    	$vVeilleDecesId = Dao_Veille_Indicateur::ChercheIndicateurVeille ($_etablissement, $_indicateur->getJour());
		if ($vVeilleDecesId == NULL){
			// ajout d'un nouvel indicateur pour cet établissement
			$vPreparedStatment = $vConnexion->prepare(
				"INSERT INTO veille_deces (date, deces_tot, deces_sup75, Hop_ID, org_ID) 
				VALUES (?, ?, ?, ?, ?)"
			);
			$vPreparedStatment->execute(array($_indicateur->getJour(), $_indicateur->getDeces(), $_indicateur->getDeces75a(),
				$_etablissement->getId(), $vOrganismeId));
		}
		else {
			// mise à jour de l'indicateur existant
			// TODO: Vérifier s'il y a des modifications à effectuer
			$vPreparedStatment = $vConnexion->prepare(
				"UPDATE veille_deces SET date=FROM_UNIXTIME(?),  deces_tot=?, deces_sup75=?, Hop_ID=?, org_ID=? 
				WHERE deces_ID=?"
			);
			$vPreparedStatment->execute(array($_indicateur->getJour(), $_indicateur->getDeces(), $_indicateur->getDeces75a(),
				$_etablissement->getId(), $vOrganismeId, $vVeilleDecesId));
		}
		return true;
	}
	
	/**
	 * cherche l'indicateur de veille pour une un établissement ou une date
	 * @param _etablissement (Objet_Structure_Etablissement): objet établissement
	 * @param _date (int, timestamp):  date de mise à jour de la veille
	 * @return (int) ID de l'enregistrement en base
	 */
	private static function ChercheIndicateurVeille (&$_etablissement, $_date){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare(
			"SELECT deces_ID FROM veille_deces WHERE Hop_ID=? AND date=FROM_UNIXTIME(?)"
		);
		$vPreparedStatment->execute(array($_etablissement->getId(), $_date));

		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    		$vLigneObj->deces_ID;
    	}
    	return NULL;
	}
}
?>