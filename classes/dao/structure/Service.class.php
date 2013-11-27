<?php
require_once $BackToRoot."classes/objet/structure/Service.class.php";
require_once $BackToRoot."classes/objet/structure/lit/Service.class.php";
require_once $BackToRoot."classes/objet/structure/alerte/Service.class.php";

require_once $BackToRoot."classes/objet/exception/SqlException.class.php";
require_once $BackToRoot."classes/objet/exception/StructureNotFoundException.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";
require_once $BackToRoot."classes/dao/structure/Etablissement.class.php";

/**
 * Accès aux données pour une structure de type service
 * 
 * @package Dao_Structure
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Dao_Structure_Service{
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
	 * Cherche un service à l'aide de son code
	 * @param _code (string): code du service
	 * @return Un objet de type "Objet_Structure_Service" si trouvé
	 */
	public static function ChercheParCode(&$_etablissement, $_code){
		$vConnexion = Dao_Pool::getConnexionPdo();  // lève un PDOException s'il y a un problème à la connexion
		
		$vPreparedStatment = $vConnexion->prepare("SELECT service_ID, service_code, service_nom from service where service_code=? AND Hop_ID=?");
		$vPreparedStatment->execute(array($_code, $_etablissement->getId()));
    	
		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vService = new Objet_Structure_Sau_Service;
    		$vService->setId($vLigneObj->service_ID);
    		$vService->setCode($vLigneObj->service_code);
    		$vService->setNom($vLigneObj->service_nom);
    		
    		return $vService;
		}
    	else {
    		// on regarde dans les services des autres établissements de l'organisme
    		$vListeEtablissements = Dao_Structure_Etablissement::chercheAutreEtablissementParFiness($_etablissement->getFiness());
    		
    		$estPremBoucle = true;
    		$vWhereIdEtablissement = "(";
    		foreach ($vListeEtablissements as $vEtablissement){
    			if (!$estPremBoucle)
    				$vWhereIdEtablissement .= ", ";
    			$vWhereIdEtablissement .= $vEtablissement->getId();
    			$estPremBoucle = false;
    		}
    		$vWhereIdEtablissement .= ")";
    		
    		$vPreparedStatment = $vConnexion->prepare("SELECT service_ID, service_code, service_nom from service where service_code=? AND Hop_ID IN ".$vWhereIdEtablissement);
    		$vPreparedStatment->execute(array($_code));
    		
	    	if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    			$vService = new Objet_Structure_Sau_Service;
    			$vService->setId($vLigneObj->service_ID);
    			$vService->setCode($vLigneObj->service_code);
    			$vService->setNom($vLigneObj->service_nom);
    			
    			return $vService;
    		}
    	}
    	throw new Objet_Exception_StructureNotFoundException ("Service non trouv&eacute; pour le code ".$_code);
	}
	
	/**
	 * Cherche un service à l'aide de son code
	 * @param _etablissement (Objet_Structure_Etablissement): Etablissement dont on cherche le service
	 * @return (int) Id du service de SAMU
	 */
	public static function ChercheSamuParEtablissement (&$_etablissement){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare("SELECT S.service_ID FROM service S, type_service T, hopital H 
			WHERE S.Type_ID=T.Type_ID AND T.type_nom='SAMU' AND S.Hop_ID=H.Hop_ID AND H.Hop_finess=?"
		);
		$vPreparedStatment->execute(array($_etablissement->getFiness()));
    	
		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    		return $vLigneObj->service_ID;
    	}
    	else {
    		// recherche du service de type samu pour le même organisme (cf. fichier de mulhouse)
    		$vListeEtablissements = Dao_Structure_Etablissement::chercheAutreEtablissementParFiness($_etablissement->getFiness());
    		
    		$estPremBoucle = true;
    		$vWhereIdEtablissement = "(";
    		foreach ($vListeEtablissements as $vEtablissement){
    			if (!$estPremBoucle)
    				$vWhereIdEtablissement .= ", ";
    			$vWhereIdEtablissement .= $vEtablissement->getId();
    			$estPremBoucle = false;
    		}
    		$vWhereIdEtablissement .= ")";
    		
    		$vPreparedStatment = $vConnexion->prepare("SELECT S.service_ID FROM service S, type_service T 
    			WHERE S.Type_ID=T.Type_ID AND T.type_nom='SAMU' AND S.Hop_ID IN ".$vWhereIdEtablissement
    		);
    		$vPreparedStatment->execute();
    		
    		$vListeEtablissement = array();
    		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    			$vListeEtablissement[] = $vLigneObj->service_ID;
    		}
    		
    		$vNbEtablissement = count($vListeEtablissement);
    		if ($vNbEtablissement == 1){
    			return $vListeEtablissement[0];
    		}
    		
    		if ($vNbEtablissement > 1){
    			// mettre un warning
    			return $vListeEtablissement[0];
    		}
    	}
    	throw new Objet_Exception_StructureNotFoundException ("Service SAMU non trouv&eacte; pour l'&eacute;tablissement ".$_etablissement->getFiness());
	}
	
	/**
	 * Mise à jour du service de type SAU
	 * @param _etablissement (Objet_Structure_Etablissement): Etablissement de mise à jour
	 * @param _sauService (Objet_Structure_Sau_Service): service de mise à jour
	 * @param _date (int, timestamp): date de mise à jour
	 * @return (bool) true si le service est mis à jour
	 */
	public static function MajSauService(&$_etablissement, &$_sauService, $_date){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vEntre1et75ans = $_sauService->getNbUrgence() - $_sauService->getNbUrgMoins1an() - $_sauService->getNbUrgPlus75ans();
    	
    	$vVeilleSauId = Dao_Structure_Service::chercheSauService ($_sauService, $_date);
		if ($vVeilleSauId == NULL){
			// ajout d'un nouvel indicateur pour cet établissement
			$vPreparedStatment = $vConnexion->prepare(
				"INSERT INTO veille_sau ( service_ID, date, inf_1_an, sup_75_an, entre1_75,
					hospitalise, uhcd, transfert) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)"
				);
			$vPreparedStatment->execute(array($_sauService->getId(), $_date, $_sauService->getNbUrgMoins1an(), 
				$_sauService->getNbUrgPlus75ans(), $vEntre1et75ans, $_sauService->getNbHospitalisation(),
				$_sauService->getNbTransUhcd(), $_sauService->getNbTransAutre()));
		}
		else {
			// TODO: Vérifier s'il y a des modifications à effectuer
			// mise à jour de l'indicateur existant
			$vPreparedStatment = $vConnexion->prepare(
				"UPDATE veille_sau SET inf_1_an=?, sup_75_an=?, entre1_75=?, hospitalise=?, uhcd=?, 
					transfert=? WHERE veille_ID=?"
			);
			$vPreparedStatment->execute(array($_sauService->getNbUrgMoins1an(), $_sauService->getNbUrgPlus75ans(),
				$vEntre1et75ans, $_sauService->getNbHospitalisation(), $_sauService->getNbTransUhcd(),
				$_sauService->getNbTransAutre(), $vVeilleSauId));
		}
    	return true;
	}
	
	/**
	 * Cherche le service SAU pour une date donnée
	 * @param _sauService (Objet_Structure_Sau_Service): service de mise à jour
	 * @param _date (int, timestamp): date de mise à jour
	 * @return (int) ID du service dans la table
	 */
	private static function ChercheSauService (&$_sauService, $_date){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare("SELECT veille_ID FROM veille_sau WHERE date=? AND service_ID=?");
    	$vPreparedStatment->execute(array($_date, $_sauService->getId()));

    	if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    		return $vLigneObj->veille_ID;
    	}
    	return NULL;
	}
	
	/**
	 * Mise à jour du service de type Lit
	 * @param _etablissement (Objet_Structure_Etablissement): Etablissement de mise à jour
	 * @param _litService (Objet_Structure_Lit_Service): service de mise à jour
	 * @param _date (int, timestamp): date de mise à jour
	 * @return (bool) true si le service est mis à jour
	 */
	public static function MajLitService(&$_etablissement, &$_litService, $_date){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		// mise à jour de la table lits (vue à une instant T)
    	$vLitsServiceId = Dao_Structure_Service::ChercheLitServiceActuelle($_litService);
    	if ($vLitsServiceId == NULL){
    		$vPreparedStatment = $vConnexion->prepare("
    			INSERT INTO lits (service_ID, Hop_ID, lits_sp, lits_supp, lits_occ, lits_dispo, lits_installe, 
    				lits_ferme, date_maj, places_auto, places_dispo, lit_spe1, lit_spe2, lit_spe3,
    				lit_spe4, lit_spe5, lit_spe6, lit_spe7, lits_respi, lits_pneg) VALUES (?, ?, ?, ?, ?, ?, ?, 
    				?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    		);
    		$vPreparedStatment->execute(array($_litService->getId(), $_etablissement->getId(), $_litService->getLitsInstalles(),
    			$_litService->getLitsSupplementaires(), $_litService->getLitsOccupes(), $_litService->getLitsDisponibles(),
    			$_litService->getLitsOuverts(), $_litService->getLitsFermes(), $_date, $_litService->getPlacesAuto(), 
    			$_litService->getPlacesDispo(), $_litService->getLitsSpe1(), $_litService->getLitsSpe2(), 
    			$_litService->getLitsSpe3(), $_litService->getLitsSpe4(), $_litService->getLitsSpe5(), $_litService->getLitsSpe6(), 
    			$_litService->getLitsSpe7(), $_litService->getLitsRespirateur(), $_litService->getLitsIsolement()));
    	}
    	else {
    		// TODO: Vérifier s'il y a des modifications à effectuer
    		$vPreparedStatment = $vConnexion->prepare("
    			UPDATE lits SET lits_sp=?, lits_supp=?, lits_occ=?, lits_dispo=?, lits_installe=?, lits_ferme=?, 
    				date_maj=?, places_auto=?, places_dispo=?, lit_spe1=?, lit_spe2=?, lit_spe3=?,
    				lit_spe4=?, lit_spe5=?, lit_spe6=?, lit_spe7=?, lits_respi=?, lits_pneg=?  WHERE lits_ID=?"
    		);
    		$vPreparedStatment->execute(array($_litService->getLitsInstalles(),
    			$_litService->getLitsSupplementaires(), $_litService->getLitsOccupes(), $_litService->getLitsDisponibles(),
    			$_litService->getLitsOuverts(), $_litService->getLitsFermes(), $_date,
    			$_litService->getPlacesAuto(), $_litService->getPlacesDispo(), $_litService->getLitsSpe1(), 
    			$_litService->getLitsSpe2(), $_litService->getLitsSpe3(), $_litService->getLitsSpe4(), $_litService->getLitsSpe5(),
    			$_litService->getLitsSpe6(), $_litService->getLitsSpe7(), $_litService->getLitsRespirateur(), 
    			$_litService->getLitsIsolement(), $vLitsServiceId)); 
    	}
    	
    	// mise à jour de la table lits_journal (historique des mise à jour)
    	$vExiste = Dao_Structure_Service::ChercheLitServiceJournal($_litService, $_date);
		if (!$vExiste){
			// ajout d'un nouveau service dans l'historique pour cet date
			
			$vPreparedStatment = $vConnexion->prepare("
				INSERT INTO lits_journal (service_ID, lits_dispo, date) VALUES (?, ?, ?)"
			);
			$vPreparedStatment->execute(array($_litService->getId(), $_litService->getLitsDisponibles(), $_date));
		}
		else {
			// TODO: Vérifier s'il y a des modifications à effectuer
			// mise à jour de l'indicateur existant
			$vPreparedStatment = $vConnexion->prepare("
				UPDATE lits_journal SET lits_dispo=? WHERE date=? AND service_ID=?"
			);
			$vPreparedStatment->execute(array($_litService->getLitsDisponibles(), $_date, $_litService->getId()));
		}
    	return true;
	}
	
	/**
	 * Cherche le service Lit pour une date donnée (photo à l'instant T)
	 * @param _sauService (Objet_Structure_Lit_Service): service de mise à jour
	 * @param _date (int, timestamp): date de mise à jour
	 * @return (int) ID du service dans la table
	 */
	private static function ChercheLitServiceActuelle (&$_litService){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare("SELECT lits_ID FROM lits WHERE service_ID=?");
		$vPreparedStatment->execute(array($_litService->getId()));
    	
		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			return $vLigneObj->lits_ID;
		}
    	return NULL;
	}
	
	/**
	 * Cherche le service Lit dans le journal pour une date donnée
	 * @param _sauService (Objet_Structure_Lit_Service): service de mise à jour
	 * @param _date (int, timestamp): date de mise à jour
	 * @return (boolean) true si la ligne ligne existe déjà dans la base de donnée
	 */
	private static function ChercheLitServiceJournal (&$_litService, $_date){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare(
			"SELECT date, service_ID FROM lits_journal WHERE date=? AND service_ID=?"
		);
		$vPreparedStatment->execute(array($_date, $_litService->getId()));
    	
		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    		return true;
    	}
    	return false;
	}
	
	/**
	 * Retourne la liste des services en retard
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement dont on cherche la liste
	 * @param $_limite (Objet_Structure_Etablissement): établissement dont on cherche la liste
	 * @return Objet_Structure_Service[]
	 */
	public function ListeRetardService(&$_etablissement, $_limite){
		$vConnexion = Dao_Pool::getConnexionPdo();
    		
    	$vPreparedStatment = $vConnexion->prepare(
    			"SELECT S1.service_ID, S1.service_code, S1.service_nom, LJ1.date from service S1, lits_journal LJ1, (SELECT LJ2.service_ID, MAX(LJ2.date) AS mdate FROM service S2, lits_journal LJ2 WHERE S2.service_ID=LJ2.service_ID AND S2.Hop_ID=? GROUP BY LJ2.service_ID) RES WHERE LJ1.service_ID=RES.service_ID AND LJ1.date=RES.mdate AND S1.service_ID=LJ1.service_ID AND S1.est_actif='o' AND LJ1.date < ?");
    	$vPreparedStatment->execute(array($_etablissement->getId(), $_limite));

    	$vListeServicesRetard = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
		 	$vService = new Objet_Sturcture_Alerte_Service;
		 	$vService->setId($vLigneObj->service_ID);
		 	$vService->setCode($vLigneObj->service_code);
		 	$vService->setNom($vLigneObj->service_nom);
		 	$vService->setDateMaj($vLigneObj->date);
		 	
		 	$vListeServicesRetard[] = $vService;
		}
		return $vListeServicesRetard;
	}
	
	/**
	 * Cherche la liste des lits disponibles des services d'un établissesment
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement dont on cherche la liste
	 * @return Objet_Structure_Lit_Service[code]
	 */
	public function &ChercheListeServiceDerJournalParEtab(&$_organisme, &$_etablissement, &$_service){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vWhereStructure = null;
		$vParam = array();
		if ($_organisme != null){
			$vWhereStructure = "O.org_ID=?";
			$vParam[] = $_organisme->getId();
		}
		else {
			if ($_etablissement != null){
				$vWhereStructure = "H.Hop_ID=?";
				$vParam[] = $_etablissement->getId();
			}
			else {
				$vWhereStructure = "S.service_ID=?";
				$vParam[] = $_service->getId();
			}
		}
		
		//$vPreparedStatment = $vConnexion->prepare("SELECT distinct(S2.service_ID), S2.service_code, S2.service_nom, J2.date AS maj, J2.lits_dispo, L.lits_sp, L.lits_supp, L.lits_occ, L.lits_installe, L.lits_ferme, T.type_nom, L.places_auto, L.places_dispo, L.lit_spe1, L.lit_spe2, L.lit_spe3, L.lit_spe4, L.lit_spe5, L.lit_spe6, L.lit_spe7, L.lits_respi, L.lits_pneg FROM lits_journal J2, service S2, lits L, type_service T, (SELECT J.service_ID, max(J.date) as date FROM lits_journal J, (select S.service_ID FROM service S, hopital H, organisme O WHERE ".$vWhereStructure." AND S.Hop_ID=H.Hop_ID AND H.org_ID=O.org_ID) R2 WHERE  J.date < UNIX_TIMESTAMP() AND J.service_ID=R2.service_ID GROUP BY J.service_ID) RES WHERE RES.service_ID=S2.service_ID AND RES.date=J2.date AND RES.service_ID=J2.service_ID AND L.service_ID=RES.service_ID AND S2.type_ID=T.type_ID AND S2.est_actif='o' ORDER BY S2.service_nom");		
		$vPreparedStatment = $vConnexion->prepare("SELECT S.service_ID, S.service_code, S.service_nom, LU.LAST_DATE AS maj, LJ1.lits_dispo, L.lits_sp, L.lits_supp, L.lits_occ, L.lits_installe, L.lits_ferme, T.type_nom, L.places_auto, L.places_dispo, L.lit_spe1, L.lit_spe2, L.lit_spe3, L.lit_spe4, L.lit_spe5, L.lit_spe6, L.lit_spe7, L.lits_respi, L.lits_pneg
				FROM organisme O, hopital H, service S, type_service T, lits L 
					LEFT JOIN (SELECT LJ.service_ID, MAX(LJ.date) AS LAST_DATE FROM lits_journal LJ WHERE LJ.date <UNIX_TIMESTAMP() GROUP BY LJ.service_ID) LU ON LU.service_ID = L.service_ID 
					LEFT JOIN lits_journal LJ1 ON LJ1.service_ID = L.service_ID AND LU.LAST_DATE = LJ1.date
				WHERE ".$vWhereStructure." 
					AND H.org_ID=O.org_ID
					AND S.Hop_ID=H.Hop_ID
					AND L.service_ID = S.service_ID
					AND S.type_ID=T.type_ID
					AND S.est_actif='o' 
				ORDER BY S.service_nom");
		$vPreparedStatment->execute($vParam);
		
		$vListeServiceLits = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vServiceLits = new Objet_Structure_Lit_Service;
			
			$vServiceLits->setId($vLigneObj->service_ID);
			$vServiceLits->setCode($vLigneObj->service_code);
			$vServiceLits->setNom($vLigneObj->service_nom);
			$vServiceLits->setTypeInvs($vLigneObj->type_nom);
			
			$vServiceLits->setLitsDisponibles($vLigneObj->lits_dispo);
			$vServiceLits->setLitsInstalles($vLigneObj->lits_sp);
			$vServiceLits->setLitsSupplementaires($vLigneObj->lits_supp);
			$vServiceLits->setLitsOccupes($vLigneObj->lits_occ);
			$vServiceLits->setLitsOuverts($vLigneObj->lits_installe);
			$vServiceLits->setLitsFermes($vLigneObj->lits_ferme);
			$vServiceLits->setDateMaj($vLigneObj->maj);
			
			$vServiceLits->setPlacesAuto($vLigneObj->places_auto);
			$vServiceLits->setPlacesDispo($vLigneObj->places_dispo);
			$vServiceLits->setLitsSpe1($vLigneObj->lit_spe1);
			$vServiceLits->setLitsSpe2($vLigneObj->lit_spe2);
			$vServiceLits->setLitsSpe3($vLigneObj->lit_spe3);
			$vServiceLits->setLitsSpe4($vLigneObj->lit_spe4);
			$vServiceLits->setLitsSpe5($vLigneObj->lit_spe5);
			$vServiceLits->setLitsSpe6($vLigneObj->lit_spe6);
			$vServiceLits->setLitsSpe7($vLigneObj->lit_spe7);
			$vServiceLits->setLitsRespirateur($vLigneObj->lits_respi);
			$vServiceLits->setLitsIsolement($vLigneObj->lits_pneg);
			
			$vListeServiceLits[strval($vLigneObj->service_ID)] = $vServiceLits;
		}
		
		return $vListeServiceLits;
	}
	
	/**
	 * Cherche les informations de lits (disponible?) pour un établissement et une période
	 * @param $_etablissements (Objet_Structure_Etablissement[]): liste des établissements concernés
	 * @param $_listeDisciplinesId (int[]): liste des code discipline concerné
	 * @param $_dateDebut (timestamp, int): début de plage
	 * @param $_dateFin (timestamp, int): fin de plage
	 * @return Tableau avec:
	 * 		date (string: format mysql) - Tableau avec
	 *	 		Id etablissement (int)- Tableau avec
	 * 				Id service (int) - Tableau avec
	 * 					0 - code discipline
	 * 					1 - nombre de lits disponibles
	 */
	public function &ChercheListeLitsParDateEtablissement(&$_etablissements, $_listeDisciplinesId, $_dateDebut, $_dateFin){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		// créer la liste des établissements
		$vListe = "";
		foreach ($_etablissements as $vEtablissement){
			if (strlen($vListe)>0){
				$vListe .= ",";
			}
			$vListe .= $vEtablissement->getId();
		}
		
		// créer la liste de discipline
		$vListeSqlDisciplineId = "";
		foreach ($_listeDisciplinesId as $vDisciplineId){
			if (strlen($vListeSqlDisciplineId)>0){
				$vListeSqlDisciplineId .= ",";
			}
			$vListeSqlDisciplineId .= "'".$vDisciplineId."'";
		}
		
		$vSql = "SELECT LSJ2.date, H2.Hop_ID, S2.service_ID, S2.DISCIPLINE_ARH_CODE, LSJ2.lits_dispo
			FROM hopital H2, service S2, lits_journal LSJ2,
			(	SELECT S1.service_ID 
				FROM hopital H, service S1 
					LEFT JOIN uf U ON U.service_ID = S1.service_ID 
				WHERE S1.Hop_ID=H.Hop_ID 
					AND S1.est_actif='o' 
					AND U.uf_ID IS NULL 
					AND S1.DISCIPLINE_ARH_CODE IN (".$vListeSqlDisciplineId.")
					AND H.Hop_ID IN (".$vListe.")) R1
			WHERE R1.service_ID = S2.service_ID
				AND H2.Hop_ID = S2.Hop_ID
				AND LSJ2.service_ID = S2.service_ID
				AND LSJ2.date BETWEEN UNIX_TIMESTAMP(?) AND UNIX_TIMESTAMP(?)
			ORDER BY LSJ2.date ASC";

		$vPreparedStatment = $vConnexion->prepare($vSql);
		$vPreparedStatment->execute(array($_dateDebut, $_dateFin));
		
		$vTmpDonnees = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vDateTs = $vLigneObj->date;
			$vEtablissementId = $vLigneObj->Hop_ID;
			$vServiceId = $vLigneObj->service_ID;
			$vCdeDiscipline = $vLigneObj->DISCIPLINE_ARH_CODE;
			$vLitsDisponibles = $vLigneObj->lits_dispo;
			
			$vDate = Metier_Util_Date::TimestampVersMysqlDate($vDateTs);
			
			// date
			if (!isset($vTmpDonnees[$vDate])){
				$vTmpDonnees[$vDate] = array();
			}
			$vTmpDonneesDate = &$vTmpDonnees[$vDate];
			
			// ID hopital
			if (!isset($vTmpDonneesDate[$vEtablissementId])){
				$vTmpDonneesDate[$vEtablissementId] = array();
			}
			$vTmpDonneesDateEtb = &$vTmpDonneesDate[$vEtablissementId];
			
			// ID service
			if (!isset($vTmpDonneesDateEtb[$vServiceId])){
				$vTmpDonneesDateEtb[$vServiceId] = array();
			}
			$vTmpDonneesDateEtbServ = &$vTmpDonneesDateEtb[$vServiceId];
			
			// données
			$vTmpDonneesDateEtbServ[0] = $vCdeDiscipline;
			$vTmpDonneesDateEtbServ[1] = $vLitsDisponibles;
		}
		
		return $vTmpDonnees;
	}
}
?>