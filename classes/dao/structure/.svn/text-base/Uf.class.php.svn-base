<?php
require_once $BackToRoot."classes/objet/structure/Uf.class.php";
require_once $BackToRoot."classes/objet/structure/alerte/Uf.class.php";

require_once $BackToRoot."classes/objet/exception/SqlException.class.php";
require_once $BackToRoot."classes/objet/exception/StructureNotFoundException.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";
require_once $BackToRoot."classes/dao/structure/Etablissement.class.php";
/**
 * Accès aux données pour une structure de type uf
 * 
 * @package Dao_Structure
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Dao_Structure_Uf{
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
	 * Cherche une UF à l'aide de son code
	 * @param _code (string): code de l'UF
	 * @return Un objet de type "Objet_Structure_Uf" si trouvé
	 */
	public static function ChercheParCode(&$_etablissement, $_code){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare("
			SELECT uf_ID, uf_code, uf_nom from uf where uf_code=? AND Hop_ID=?"
		);
		$vPreparedStatment->execute(array($_code, $_etablissement->getId()));
    	
		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    		$vUf = new Objet_Structure_Uf;
    		$vUf->setId($vLigneObj->uf_ID);
    		$vUf->setCode($vLigneObj->uf_code);
    		$vUf->setNom($vLigneObj->uf_nom);

    		return $vUf;
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
    		
    		$vPreparedStatment = $vConnexion->prepare(
    			"SELECT uf_ID, uf_code, uf_nom from uf where uf_code=? AND Hop_ID IN ".$vWhereIdEtablissement
    		);
    		$vPreparedStatment->execute(array($_code));
    		
    		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    			$vUf = new Objet_Structure_Uf;
    			$vUf->setId($vLigneObj->uf_ID);
    			$vUf->setCode($vLigneObj->uf_code);
    			$vUf->setNom($vLigneObj->uf_nom);

    			return $vUf;
    		}
    	}
    	throw new Objet_Exception_StructureNotFoundException ("UF non trouv&eacute; pour le code ".$_code);
	}
	
	/**
	 * Mise à jour d'une UF de type SAU
	 * @param _etablissement (Objet_Structure_Etablissement): Etablissement de mise à jour
	 * @param _sauService (Objet_Structure_Sau_Service): service de mise à jour
	 * @param _sauUf (Objet_Structure_Sau_Uf): uf de mise à jour
	 * @param _jour (int, timestamp): date de mise à jour
	 * @return (bool) true si le service est mis à jour
	 */
	public static function MajSauUf(&$_etablissement, &$_sauService, &$_sauUf, $_jour){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vOrganismeId = "NULL";
		if ($_etablissement->getOrganisme() != NULL){
			$vOrganismeId = $_etablissement->getOrganisme()->getId();
		}
    	
     	$vVeilleSauId = Dao_Structure_Uf::chercheSauUf ($_sauUf, $_jour);
		if ($vVeilleSauId == NULL){
			// ajout d'un nouvel indicateur pour cet établissement
			$vPreparedStatment = $vConnexion->prepare(
				"INSERT INTO veille_SAU (uf_ID, date, inf_1an, sup_75an, passage, hosp, uhcd, transfert,
					service_ID, org_ID) VALUES (?, FROM_UNIXTIME(?), ?, ?, ?, ?, ?, ?, ?, ?)"
			);
			$vPreparedStatment->execute(array($_sauUf->getId(), $_jour, $_sauUf->getNbUrgMoins1an(), 
				$_sauUf->getNbUrgPlus75ans(), $_sauUf->getNbUrgence(), $_sauUf->getNbHospitalisation(), 
				$_sauUf->getNbTransUhcd(), $_sauUf->getNbTransAutre(), $_sauService->getId(), $vOrganismeId));
		}
		else {
			// mise à jour de l'indicateur existant
			$vPreparedStatment = $vConnexion->prepare(
				"UPDATE veille_SAU SET inf_1an=?, sup_75an=?, passage=?, hosp=?, uhcd=?, transfert=?, 
				service_ID=?, org_ID=? WHERE veille_SAU_ID=?"
			);
			$vPreparedStatment->execute(array($_sauUf->getNbUrgMoins1an(), $_sauUf->getNbUrgPlus75ans(),
				$_sauUf->getNbUrgence(), $_sauUf->getNbHospitalisation(), $_sauUf->getNbTransUhcd(),
				$_sauUf->getNbTransAutre(), $_sauService->getId(), $vOrganismeId, $vVeilleSauId));
		}
		
		$vConnexion = null;
    	return true;
	}
	
	/**
	 * Cherche l'UF SAU pour une date donnée
	 * @param _sauUf (Objet_Structure_Sau_Uf): service de mise à jour
	 * @param _date (int, timestamp): date de mise à jour
	 * @return (int) ID du service dans la table
	 */
	private static function ChercheSauUf (&$_sauUf, $_date){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare(
			"SELECT veille_SAU_ID FROM veille_SAU WHERE date=FROM_UNIXTIME(?) AND uf_ID=?"
		);
		$vPreparedStatment->execute(array($_date, $_sauUf->getId()));
    	
    	$vVeilleId = NULL;
    	if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    		return $vLigneObj->veille_SAU_ID;
    	}
    	
    	$vConnexion = null;
		return NULL;
	}
	
	/**
	 * Met à jour le journal des UF pour les lits
	 * @param _etablissement (Objet_Structure_Etablissement): Etablissement de mise à jour
	 * @param _litService (Objet_Structure_Lit_Service): service de mise à jour
	 * @param _litUf (Objet_Structure_Lit_Uf): UF de mise à jour
	 * @param _date (int, timestamp): date de mise à jour
	 * @return (bool) true si la mise à jour est effectuée
	 */
	public static function MajLitUf(&$_etablissement, &$_litService, &$_litUf, $_date){
		$vConnexion = Dao_Pool::getConnexionPdo();
    	
    	$vVeilleUfId = Dao_Structure_Uf::chercheLitsUfJournal ($_litUf, $_date);
		if ($vVeilleUfId == NULL){
			// ajout d'un nouvel indicateur pour cet établissement
			$vPreparedStatment = $vConnexion->prepare("
				INSERT INTO journal_uf (uf_ID, service_ID, date, heure, date_ts, lits_installes, lits_ouverts,
					lits_dispo, lits_fermes, lits_sup, lits_occupes, lits_permissions, places_dispo) 
				VALUES (?, ?, FROM_UNIXTIME(?), FROM_UNIXTIME(?, '%H:%i:%s'),?, ?, ?, ?, ?, ?, ?, ?, ?)"
			);
			$vPreparedStatment->execute(array($_litUf->getId(), $_litService->getId(), $_date, $_date, $_date,
				$_litUf->getLitsInstalles(), $_litUf->getLitsOuverts(), $_litUf->getLitsDisponibles(),
				$_litUf->getLitsFermes(), $_litUf->getLitsSupplementaires(), $_litUf->getLitsOccupes(),
				$_litUf->getPermissions(), $_litUf->getPlaces_disponibles()));
		}
		else {
			// TODO: Vérifier s'il y a des modifications à effectuer
			// mise à jour de l'indicateur existant
			$vPreparedStatment = $vConnexion->prepare(
				"UPDATE journal_uf SET date=FROM_UNIXTIME(?), heure=FROM_UNIXTIME(?, '%H:%i:%s') , date_ts=?, lits_installes=?, lits_ouverts=?, 
					lits_dispo=?, lits_fermes=?, lits_sup=?, lits_occupes=?, lits_permissions=?, places_dispo=? 
				WHERE journal_ID=?"
			);
			$vPreparedStatment->execute(array($_date, $_date, $_date, $_litUf->getLitsInstalles(), $_litUf->getLitsOuverts(),
			$_litUf->getLitsDisponibles(), $_litUf->getLitsFermes(), $_litUf->getLitsSupplementaires(),
			$_litUf->getLitsOccupes(), $_litUf->getPermissions(), $_litUf->getPlaces_disponibles(), $vVeilleUfId));
		}
		
		$vConnexion = null;
		return true;
	}
	
	/**
	 * Cheche la disponibilité des lits pour une UF et une date
	 * @param _litUf (Objet_Structure_Lit_Uf): UF de mise à jour
	 * @param _date (int, timestamp): date de mise à jour
	 * @return (ind) ID de la disponibilité dans la table
	 */
	public static function chercheLitsUfJournal(&$_litUf, $_date){
		$vConnexion = Dao_Pool::getConnexionPdo();
    		
    	$vPreparedStatment = $vConnexion->prepare("SELECT journal_ID FROM journal_uf WHERE date=? AND heure IS NULL AND uf_ID=?");
    	$vPreparedStatment->execute(array($_date, $_litUf->getId()));
    	
    	if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
    		return $vLigneObj->journal_ID;
    	}
    	
    	$vConnexion = null;
    	return NULL;
	}
	
	/**
	 * Retourne la liste des UF en retard
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement dont on cherche la liste
	 * @param $_limite (Objet_Structure_Etablissement): établissement dont on cherche la liste
	 * @return Objet_Structure_Uf
	 */
	public function ListeRetardUf(&$_etablissement, $_limite){
		$vConnexion = Dao_Pool::getConnexionPdo();
		
		$vPreparedStatment = $vConnexion->prepare(
				"SELECT U1.uf_ID, U1.uf_code, U1.uf_nom, unix_timestamp(concat(UJ1.date, ' ', UJ1.heure)) AS date from uf U1, journal_uf UJ1, (SELECT U2.uf_ID, MAX(unix_timestamp(concat(UJ2.date, ' ', UJ2.heure))) AS mdate FROM uf U2, journal_uf UJ2 WHERE U2.uf_ID = UJ2.uf_ID AND U2.Hop_ID=? GROUP BY UJ2.uf_ID) RES WHERE UJ1.uf_ID=RES.uf_ID AND RES.mdate=unix_timestamp(concat(UJ1.date, ' ', UJ1.heure)) AND UJ1.uf_ID=U1.uf_ID AND U1.uf_ouverte='1' AND unix_timestamp(concat(UJ1.date, ' ', UJ1.heure)) < ?");
		$vPreparedStatment->execute(array($_etablissement->getId(), $_limite));

		$vListeUfRetard = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
		 	$vUf = new Objet_Sturcture_Alerte_Uf;
		 	$vUf->setId($vLigneObj->uf_ID);
		 	$vUf->setCode($vLigneObj->uf_code);
		 	$vUf->setNom($vLigneObj->uf_nom);
		 	$vUf->setDateMaj($vLigneObj->date);
		 	
		 	$vListeUfRetard[] = $vUf;
		}
		
		$vConnexion = null;
		return $vListeUfRetard;
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
		
		$vSql = "SELECT LUJ.date_ts AS date, H.Hop_ID, U.uf_ID, U.DISCIPLINE_ARH_CODE, LUJ.lits_dispo
			FROM hopital H, service S, uf U, journal_uf LUJ
			WHERE H.Hop_ID IN (".$vListe.")
				AND U.DISCIPLINE_ARH_CODE IN (".$vListeSqlDisciplineId.")
				AND S.Hop_ID = H.Hop_ID
				AND U.service_ID = S.service_ID
				AND LUJ.uf_ID = U.uf_ID
				AND LUJ.date_ts BETWEEN UNIX_TIMESTAMP(?) AND UNIX_TIMESTAMP(?)
			ORDER BY LUJ.date_ts ASC";
		
		$vPreparedStatment = $vConnexion->prepare($vSql);
		$vPreparedStatment->execute(array($_dateDebut, $_dateFin));
		
		$vTmpDonnees = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vDateTs = $vLigneObj->date;
			$vEtablissementId = $vLigneObj->Hop_ID;
			$vUfId = $vLigneObj->uf_ID;
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
			if (!isset($vTmpDonneesDateEtb[$vUfId])){
				$vTmpDonneesDateEtb[$vUfId] = array();
			}
			$vTmpDonneesDateEtbServ = &$vTmpDonneesDateEtb[$vUfId];
			
			// données
			$vTmpDonneesDateEtbServ[0] = $vCdeDiscipline;
			$vTmpDonneesDateEtbServ[1] = $vLitsDisponibles;
		}
		
		return $vTmpDonnees;
	}
	
	/**
	 * Cherche les dernières mise àjour des uf pour la liste des services données
	 * @param $_organisme (Objet_Structure_Organisme): organisme dont on cherche la liste
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement dont on cherche la liste
	 * @param $_listeService (Objet_Structure_Lit_Service[]): liste des service dont on cherche la liste
	 * @return Rien, c'est la liste des servcies qui est complété
	 */
	public function ChercheListeUfDerJournalParService(&$_organisme, &$_etablissement, &$_listeService){
		$vConnexion = Dao_Pool::getConnexionPdo();
	}
}
?>