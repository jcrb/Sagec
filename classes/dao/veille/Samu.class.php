<?php
require_once $BackToRoot."classes/objet/import/SamuJour.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";
/**
 * Acc�s aux donn�es SAMU de veille sanitaire
 * 
 * @package Dao_Veille
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Dao_Veille_Samu{
	/**
	 * Mise � jour du SAMU de veille sanitaire
	 * @param _etablissement (Objet_Structure_Etablissement): objet �tablissement
	 * @param $_samu (Objet_Import_SamuJour): donn�es SAMU � mettre � jour
	 * @return (bool) true si la donn�es est mise � jour est mis � jour
	 */
	public static function MajSamuVeille (&$_etablissement, &$_samu){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vServiceSamuId = Dao_Structure_Service::ChercheSamuParEtablissement($_etablissement);
    	
    	$vVeilleSamuId = Dao_Veille_Samu::chercheSamuVeille ($vServiceSamuId, $_samu->getJour());
		if ($vVeilleSamuId == NULL){
			// ajout d'un nouvel indicateur pour cet �tablissement
			$vPreparedStatment = $vConnexion->prepare(
				"INSERT INTO veille_samu (date, service_ID, nb_affaires, nb_primaires, nb_secondaires, 
					nb_neonat, nb_tiih, nb_vsav, conseils, nb_med) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
			);
			$vPreparedStatment->execute(array($_samu->getJour(), $vServiceSamuId, $_samu->getNbAffaires(), 
				$_samu->getNbPrimaire(), $_samu->getNbSecondaire(), $_samu->getNbNeonat(), $_samu->getNbTiih(),
				$_samu->getNbAmbu(), $_samu->getNbConseil(), $_samu->getNbEnvoieMed()));
		}
		else {
			// TODO: V�rifier s'il y a des modifications � effectuer
			// mise � jour de l'indicateur existant
			$vPreparedStatment = $vConnexion->prepare(
				"UPDATE veille_samu SET nb_affaires=?, nb_primaires=?, nb_secondaires=?, nb_neonat=?, 
					nb_tiih=?, nb_vsav=?, conseils=?, nb_med=? WHERE veille_samu_ID=?"
			);
			$vPreparedStatment->execute(array($_samu->getNbAffaires(), $_samu->getNbPrimaire(), $_samu->getNbSecondaire(),
				$_samu->getNbNeonat(), $_samu->getNbTiih(), $_samu->getNbAmbu(), $_samu->getNbConseil(),
				$_samu->getNbEnvoieMed(), $vVeilleSamuId));
		}
		return true;
	}
	
	/**
	 * Cherche les donn�e SAMU pour l'�tablissement et la date donn�e
	 * @param _etablissement (Objet_Structure_Etablissement): objet �tablissement
	 * @param _date (int, timestamp):  date de mise � jour de la donn�e SAMU
	 * @return (int) ID de l'enregistrement en base
	 */
	public static function ChercheSamuVeille ($_serviceId, $_date){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare(
			"SELECT veille_samu_ID FROM veille_samu WHERE service_ID=? AND date=FROM_UNIXTIME(?)"
		);
		$vPreparedStatment->execute(array($_serviceId, $_date));
    	
    	if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    		return $vLigneObj->veille_samu_ID;
    	}
		
    	return NULL;
	}
}
?>