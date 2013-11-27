<?php
require_once $BackToRoot."classes/objet/structure/Etablissement.class.php";
require_once $BackToRoot."classes/objet/veille/EvtSpe.class.php";
require_once $BackToRoot."classes/objet/veille/EvtSpeChamp.class.php";
require_once $BackToRoot."classes/objet/veille/EvtSpeData.class.php";
require_once $BackToRoot."classes/metier/util/Date.class.php";
require_once $BackToRoot."classes/dao/pool.class.php";
/**
 * Accès aux données pour la saisie d'évènements spéciaux
 * 
 * @package Dao_Structure
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Dao_Veille_EvenementSpecial{
	/**
	 * Cherche la liste des évènements à afficher pour cet etablissement
	 * @param Objet_Structure_Etablissement
	 * @return Objet_Veille_EvtSpe
	 */
	public static function ChercheEvtSpParEtablissement (&$_etablissement){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare(
			"SELECT E.ID, E.NOM, E.DESC, E.TITRE, E.DETAIL 
			FROM EVT_SP_HOP H, EVT_SP_DESC E 
			WHERE H.EVT_SP_ID=E.ID AND H.Hop_ID=? AND ACTIF=1");
		$vPreparedStatment->execute(array($_etablissement->getId()));
		
		$vListeEvenements = array();
		
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vEvenement = new Objet_Veille_EvtSpe;
			
			$vEvenement->setId($vLigneObj->ID);
			$vEvenement->setNom($vLigneObj->NOM);
			$vEvenement->setDescription($vLigneObj->DESC);
			$vEvenement->setTitre($vLigneObj->TITRE);
			$vEvenement->setDetail($vLigneObj->DETAIL);
			
			$vEvenement->setListeChamps(Dao_Veille_EvenementSpecial::ChercheChampsParEvenement($vEvenement));
			
			$vListeEvenements[] = $vEvenement;
		}
		
		return $vListeEvenements;
	}
	
	/**
	 * Cherche la liste des champs pour cet évènement
	 * @param Objet_Veille_EvtSpe
	 * @return Objet_Veille_EvtSpeChamp[]
	 */
	public static function ChercheChampsParEvenement(&$_evenement){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare("
			SELECT ID, LABEL, LABEL_CR, AIDE, INPUT, ORDRE 
			FROM EVT_SP_CHAMPS 
			WHERE EVT_SP_ID=? 
			ORDER BY ORDRE ASC;");
		$vPreparedStatment->execute(array($_evenement->getId()));
		
		$vListeChamps = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vChamp = new Objet_Veille_EvtSpeChamp;
			
			$vChamp->setId($vLigneObj->ID);
			$vChamp->setEvenement($_evenement);
			$vChamp->setLabel(stripcslashes($vLigneObj->LABEL));
			$vChamp->setLabelCr($vLigneObj->LABEL_CR);
			$vChamp->setAide($vLigneObj->AIDE);
			$vChamp->setInput($vLigneObj->INPUT);
			$vChamp->setOrdre($vLigneObj->ORDRE);
			
			$vListeChamps[$vLigneObj->ID] = $vChamp;
		}
		return $vListeChamps;
	}
	
	/**
	 * Lit la valeur d'un champs pour un hôpital et un jour donné
	 * @param $_data: Objet_Veille_EvtSpeData
	 * @return Objet_Veille_EvtSpeData
	 */
	public static function ChercheValeurPourJour (&$_data){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare("
			SELECT ID, VALEUR 
			FROM EVT_SP_DATA 
			WHERE HOP_ID=? AND EVT_SP_CHAMPS_ID=? AND JOUR=?");
		
		$vPreparedStatment->execute(array($_data->getEtablissement()->getId(), $_data->getChamp()->getId(), Metier_Util_Date::TimestampVersMysqlDate($_data->getJour())));
		
		$vData = null;
		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vData = new Objet_Veille_EvtSpeData();
			
			$vData->setId(intval($vLigneObj->ID));
			$vData->setValeur(intval($vLigneObj->VALEUR));
			
			$vData->setEtablissement($_data->getEtablissement());
			$vData->setChamp($_data->getChamp());
			$vData->setJour($_data->getJour());
		}
		return $vData;
	}
	
	/**
	 * Cherche toute les valeurs pour un jour et un évènement donnée
	 * @param $_jour: Date (timestamp)
	 * @param $_evenement: Objet_Veille_EvtSpe
	 * @param $_etablissement: Objet_Structure_Etablissement
	 * @return int[] (les indices des tableaux sont les ID des champs)
	 */
	public static function ChercheValeursPourJourEvenement(&$_jour, &$_evenement, &$_etablissement){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare("
			SELECT ED.EVT_SP_CHAMPS_ID, ED.VALEUR
			FROM EVT_SP_DATA ED, EVT_SP_CHAMPS EC
			WHERE 	ED.EVT_SP_CHAMPS_ID = EC.ID AND
					EC.EVT_SP_ID = ? AND
					ED.HOP_ID = ? AND
					ED.JOUR = ?");
		
		$vPreparedStatment->execute(array($_evenement->getId(), $_etablissement->getId(), Metier_Util_Date::TimestampVersMysqlDate($_jour)));
		
		$vData = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vData[$vLigneObj->EVT_SP_CHAMPS_ID] = 	$vLigneObj->VALEUR;
		}
		return $vData;
	}
	
	/**
	 * Met à jour (création où mise à jour de la valeur du champs)
	 * @param $_data: Objet_Veille_EvtSpeData
	 */
	public static function MajEvtSpChamp(&$_data){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vDataId = $_data->getId();
		if (isset ($vDataId)){
			// c'est une mise à jour
			$vPreparedStatment = $vConnexion->prepare("
				UPDATE EVT_SP_DATA
				SET VALEUR=?
				WHERE ID=?");
			$vPreparedStatment->execute(array($_data->getValeur(), $_data->getId()));
		}
		else {
			// c'est une insertion
			$vPreparedStatment = $vConnexion->prepare("
				INSERT INTO EVT_SP_DATA
				(HOP_ID, EVT_SP_CHAMPS_ID, JOUR, VALEUR) VALUES (?, ?, ?, ?)");
			$vPreparedStatment->execute(array($_data->getEtablissement()->getId(), $_data->getChamp()->getId(), Metier_Util_Date::TimestampVersMysqlDate($_data->getJour()), $_data->getValeur()));
			
			$_data->setId($vConnexion->lastInsertId());
		}
	}
	
	/**
	 * Cherche la liste des hôpitaux liés à cet évènement
	 * @param $_evenement: Objet_Veille_EvtSpe
	 * @return Objet_Structure_Etablissement[]
	 */
	public static function ChercheEtablissementsPourEvenement(&$_evenement){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare("
				SELECT H.Hop_ID, H.Hop_nom, H.Hop_finess
				FROM hopital H, EVT_SP_DESC EVT, EVT_SP_HOP EVT_H 
				WHERE H.Hop_ID = EVT_H.HOP_ID AND 
					EVT.ID = EVT_H.EVT_SP_ID AND 
					EVT.ID=?");
		$vPreparedStatment->execute(array($_evenement->getId()));
		
		$vListeEtablissement = array();
		
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vEtablissement = new Objet_Structure_Etablissement();
			
			$vEtablissement->setId($vLigneObj->Hop_ID);
			$vEtablissement->setNom($vLigneObj->Hop_nom);
			if (isset ($vLigneObj->Hop_finess)){
				$vEtablissement->setFiness($vLigneObj->Hop_finess);
			}
			else {
				// bug étrange !!!!
				$vEtablissement->setFiness($vLigneObj->H);
			}
			
			$vListeEtablissement[] = $vEtablissement;
		}
		
		return $vListeEtablissement;
	}
	
	/**
	 * Cherche l'ensemble des données pour un évènement
	 * 
	 * @param $_evenement: Objet_Veille_EvtSpe
	 * @return tableau (String => tableau (String => tableau (String => int)))
	 * 		String 1 - date du jour
	 * 		String 2 - identifiant de l'établissement de santé
	 * 		String 3 - identifiant du champ
	 * 		int - valeur du champ 
	 */
	public static function ChercheDonneesPourEvenement(&$_evenement){
		// lecture des structure
		$vListeEtablissement = Dao_Veille_EvenementSpecial::ChercheEtablissementsPourEvenement($_evenement);
		$vListeChamps = Dao_Veille_EvenementSpecial::ChercheChampsParEvenement($_evenement);
		
		// lecture des données
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare("
			SELECT H.Hop_ID, EVT_C.ID AS CHAMP_ID, EVT_D.JOUR, EVT_D.VALEUR
			FROM hopital H, EVT_SP_DESC EVT, EVT_SP_HOP EVT_H, EVT_SP_CHAMPS EVT_C, EVT_SP_DATA EVT_D
			WHERE H.Hop_ID = EVT_H.HOP_ID AND
				EVT.ID = EVT_H.EVT_SP_ID AND
				
				EVT.ID = EVT_C.EVT_SP_ID AND
				EVT_C.ID = EVT_D.EVT_SP_CHAMPS_ID AND
				EVT_D.Hop_ID = H.Hop_ID AND
				
				EVT.ID=?
				
			ORDER BY EVT_D.JOUR ASC, EVT_C.ORDRE ASC");
		
		$vPreparedStatment->execute(array($_evenement->getId()));
		
		$vListeJourData = array();
		
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			// jour
			$vJour = $vLigneObj->JOUR;
			$vListeEtablissementData =& $vListeJourData[$vJour];
			if (!isset($vListeEtablissementData)){
				$vListeEtablissementData = array();
				$vListeJourData[$vJour] = $vListeEtablissementData;
			}
				
			// établissement de santé
			$vIdEtablissement = $vLigneObj->Hop_ID;
			$vListeDonneesData =& $vListeEtablissementData[$vIdEtablissement];
			if (!isset($vListeDonneesData)){
				$vListeDonneesData = array();
				$vListeHopitaux[$vIdEtablissement] = $vListeDonneesData;
			}

			// données
			$vListeDonneesData[$vLigneObj->CHAMP_ID] = intval($vLigneObj->VALEUR);
		}
		
		return $vListeJourData;
	}
	
	/**
	 * Cherche la liste des évènements spéciaux
	 * @return Objet_Veille_EvtSpe[]
	 */
	public static function ListeEvenement (){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare("
			SELECT E.ID, E.NOM, E.DESC, E.TITRE, E.DETAIL, E.ACTIF
			FROM EVT_SP_DESC E");
		$vPreparedStatment->execute();
		
		$vListeEvenement = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vEvenement = new Objet_Veille_EvtSpe();

			$vEvenement->setId($vLigneObj->ID);
			$vEvenement->setNom($vLigneObj->NOM);
			$vEvenement->setDescription($vLigneObj->DESC);
			$vEvenement->setTitre($vLigneObj->TITRE);
			$vEvenement->setDetail($vLigneObj->DETAIL);
			$vEvenement->setActif($vLigneObj->ACTIF == 1);
			
			$vListeEvenement[] = $vEvenement;
		}
		
		return $vListeEvenement;
	}
	
	/**
	 * Créer ou met à jour un évènement
	 * @param Objet_Veille_EvtSpe
	 */
	public static function MajEvenement (&$_evenement){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vActif = "0";
		if ($_evenement->isActif()){
			$vActif = "1";
		}
		
		if ($_evenement->getId() == 0){
			// c'est un nouveau élement
			$vPreparedStatment = $vConnexion->prepare("INSERT INTO EVT_SP_DESC (NOM, `DESC`, TITRE, DETAIL, ACTIF) VALUES (?, ?, ?, ?, ?)");
			$vPreparedStatment->execute(array($_evenement->getNom(), $_evenement->getDescription(), $_evenement->getTitre(), $_evenement->getDetail(), $vActif));
			
			$_evenement->setId($vConnexion->lastInsertId());
		}
		else {
			// c'est une mise à jour
			$vPreparedStatment = $vConnexion->prepare("UPDATE EVT_SP_DESC SET NOM=?, `DESC`=?, TITRE=?, DETAIL=?, ACTIF=? WHERE ID=?");
			$vPreparedStatment->execute(array($_evenement->getNom(), $_evenement->getDescription(), $_evenement->getTitre(), $_evenement->getDetail(), $vActif, $_evenement->getId()));
		}
	}
	
	/**
	 * Créer ou met à jour un champ
	 * @param Objet_Veille_EvtSpe
	 */
	public static function MajChamp (&$_evenement, &$_champ){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		if ($_champ->getId() == 0){
			// c'est un nouveau élement
			$vPreparedStatment = $vConnexion->prepare("INSERT EVT_SP_CHAMPS (EVT_SP_ID, LABEL, INPUT, ORDRE) VALUES (?, ?, ?, ?)");
			$vPreparedStatment->execute(array($_evenement->getId(), $_champ->getLabel(), $_champ->getInput(), $_champ->getOrdre()));
			
			$_champ->setId($vConnexion->lastInsertId());
		}
		else {
			// c'est une mise à jour
			$vPreparedStatment = $vConnexion->prepare("UPDATE EVT_SP_CHAMPS SET LABEL=?, INPUT=?, ORDRE=? WHERE ID=?");
			$vPreparedStatment->execute(array($_champ->getLabel(), $_champ->getInput(), $_champ->getOrdre(), $_evenement->getId()));
		}
	}
	
	/**
	 * Compléte l'object évènement passé en paramètre
	 * @param $_evenement: Objet_Veille_EvtSpe
	 */
	public static function ChercheEvenementParID (&$_evenement){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare("
			SELECT E.ID, E.NOM, E.DESC, E.TITRE, E.DETAIL, E.ACTIF
			FROM EVT_SP_DESC E
			WHERE E.ID=?");
	
		$vPreparedStatment->execute(array($_evenement->getId()));
		
		$vListeEvenement = array();
		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$_evenement->setNom($vLigneObj->NOM);
			$_evenement->setDescription($vLigneObj->DESC);
			$_evenement->setTitre($vLigneObj->TITRE);
			$_evenement->setDetail($vLigneObj->DETAIL);
			$_evenement->setActif($vLigneObj->ACTIF == 1);
		}
	}
	
	/**
	 * Vérifie si l'évènement est associé à l'établissement
	 * @param $_etablissement: Objet_Structure_Etablissement
	 * @param $_evenement: Objet_Veille_EvtSpe
	 * @return true si l'association existe
	 */
	public static function VerifieEvtSp(&$_etablissement, &$_evenement){
		$vConnexion = Dao_Pool::getConnexionPdo();
		$vPreparedStatment = $vConnexion->prepare("
			SELECT COUNT(*) AS NB
			FROM EVT_SP_HOP
			WHERE HOP_ID=? AND EVT_SP_ID=?");
		
		$vPreparedStatment->execute(array($_etablissement->getId(), $_evenement->getId()));
		
		
		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			if ($vLigneObj->NB == "0"){
				return false;
			}
			else{
				return true;
			}
		}
		else {
			return false;
		}
	}
	
	/**
	 * Met en place l'association entre l'évènement et l'établissement
	 * @param $_etablissement: Objet_Structure_Etablissement
	 * @param $_evenement: Objet_Veille_EvtSpe
	 */
	public static function AjoutEvtSpEtablissement(&$_etablissement, &$_evenement){
		if (!Dao_Veille_EvenementSpecial::VerifieEvtSp($_etablissement, $_evenement)){
			$vConnexion = Dao_Pool::getConnexionPdo();
			$vPreparedStatment = $vConnexion->prepare("
				INSERT INTO EVT_SP_HOP (HOP_ID, EVT_SP_ID) VALUES (?, ?)");
			
			$vPreparedStatment->execute(array($_etablissement->getId(), $_evenement->getId()));
		}
	}
	
	/**
	 * Supprime l'association entre l'évènement est l'établissement
	 * @param $_etablissement: Objet_Structure_Etablissement
	 * @param $_evenement: Objet_Veille_EvtSpe
	 */
	public static function SupprEvtSpEtablissement(&$_etablissement, &$_evenement){
		if (Dao_Veille_EvenementSpecial::VerifieEvtSp($_etablissement, $_evenement)){
			$vConnexion = Dao_Pool::getConnexionPdo();
			$vPreparedStatment = $vConnexion->prepare("
				DELETE FROM  EVT_SP_HOP WHERE HOP_ID=? AND EVT_SP_ID=?");
			
			$vPreparedStatment->execute(array($_etablissement->getId(), $_evenement->getId()));
		}
	}
}
?>