<?php
require_once $BackToRoot."classes/dao/structure/Service.class.php";
require_once $BackToRoot."classes/dao/structure/Uf.class.php";
require_once $BackToRoot."classes/dao/structure/TypeStructure.class.php";
require_once $BackToRoot."classes/dao/structure/DisciplineArh.class.php";
/**
 * Traitement lier au service
 * 
 * @package Metier
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */

class Metier_Service{
	private $serviceDao = null; // (Dao_Structure_Service)
	private $ufDao = null; // (Dao_Structure_Uf
	private $typeStructureDao = null; // (Dao_Structure_TypeStructure)
		
	/**
	 * Cherche la dernière disponibilité en lit du service pour un établissement donnée
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement dont on cherche la liste
	 * @return Objet_Structure_Lit_Service[code]
	 */
	public function &ChercheListeServiceDerJournalParEtab(&$_organisme, &$_etablissement, &$_service){
		$vServiceDao = $this->getServiceDao();
		
		$vListeServiceLit = $vServiceDao->ChercheListeServiceDerJournalParEtab($_organisme, $_etablissement, $_service);
		
		return $vListeServiceLit;
	}
	
	/**
	 * Met à jour la disponibilité en lit du service
	 * @param $_etablissement (Objet_Structure_Etablissement): Etablissement de mise à jour
	 * @param $_serviceLit (Objet_Structure_Lit_Service): service à mettre à jour
	 * @param $_date (int, timstamp)
	 * @return
	 */
	public function MajServiceLit(&$_etablissement, &$_serviceLit, $_date){
		Dao_Structure_Service::MajLitService($_etablissement, $_serviceLit, $_date);
	}
	
	/**
	 * Calcul la répatition des services par type de structure
	 * @param $_vListeServiceLit (Objet_Structure_Lit_Service): liste de service dont on cherche la répartition
	 * @return array[string][int]
	 */
	public function &ListeRepartitionServiceParTypeService ($_vListeServiceLit){
		$vTypeStructureDao = $this->getTypeStructureDao();
		$vListeTypeStructure = $vTypeStructureDao->ListeTypeStructure();
		
		$vListeRepartServiceParTypeService = array();
		
		// initialisation du tableau
		foreach ($vListeTypeStructure as $vTypeStructure){
			$vListeRepartServiceParTypeService[$vTypeStructure->getCode()] = 0;
		}
		
		// compter les types de service
		foreach ($_vListeServiceLit as $vServiceLit){
			$vListeRepartServiceParTypeService[$vServiceLit->getTypeInvs()] += 1;
		}
		
		return $vListeRepartServiceParTypeService;
	}
	
	/**
	 * Calcul le nombre de lits disponibles par type de services
	 * @param $_vListeServiceLit (Objet_Structure_Lit_Service): liste de service dont on cherche la répartition
	 * @return array[string][int]
	 */
	
	public function NbLitsDisponibleParTypeService($_vListeServiceLit){
		$vTypeStructureDao = $this->getTypeStructureDao();
		$vListeTypeStructure = $vTypeStructureDao->ListeTypeStructure();
		
		$vListeRepartServiceParTypeService = array();
		
		// initialisation du tableau
		foreach ($vListeTypeStructure as $vTypeStructure){
			$vListeRepartServiceParTypeService[$vTypeStructure->getCode()] = 0;
		}
		
		// compter les types de service
		foreach ($_vListeServiceLit as $vServiceLit){
			$vListeRepartServiceParTypeService[$vServiceLit->getTypeInvs()] += $vServiceLit->getLitsDisponibles();
		}
		
		return $vListeRepartServiceParTypeService;
	}
	
	/**
	 * regarde si le formulaire est modifié
	 * @param $_serviceLit (Objet_Structure_Lit_Service): objet serviceLit
	 * @param $_param (string[]): Paramètre de la requête
	 * @return bool
	 */
	public function modificationFormulaire(&$_serviceLit, &$_param){
		$vDonneModifiee = false; // true si des données sont modifiers

		if (isset($_REQUEST['lits_installe'])){
			if ($_REQUEST['lits_installe'] != $_serviceLit->getLitsInstalles() ){
				$_serviceLit->setLitsInstalles($_REQUEST['lits_installe']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['lits_ferme'])){
			if ($_REQUEST['lits_ferme'] != $_serviceLit->getLitsFermes() ){
				$_serviceLit->setLitsFermes($_REQUEST['lits_ferme']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['lits_supp'])){
			if ($_REQUEST['lits_supp'] != $_serviceLit->getLitsSupplementaires() ){
				$_serviceLit->setLitsSupplementaires($_REQUEST['lits_supp']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['lits_dispo'])){
			if ($_REQUEST['lits_dispo'] != $_serviceLit->getLitsDisponibles() ){
				$_serviceLit->setLitsDisponibles($_REQUEST['lits_dispo']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['places_dispo'])){
			if ($_REQUEST['places_dispo'] != $_serviceLit->getPlacesDispo() ){
				$_serviceLit->setPlacesDispo($_REQUEST['places_dispo']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['places_auto'])){
			if ($_REQUEST['places_auto'] != $_serviceLit->getPlacesAuto() ){
				$_serviceLit->setPlacesAuto($_REQUEST['places_auto']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['lit_spe1'])){
			if ($_REQUEST['lit_spe1'] != $_serviceLit->getLitsSpe1() ){
				$_serviceLit->setLitsSpe1($_REQUEST['lit_spe1']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['lit_spe2'])){
			if ($_REQUEST['lit_spe2'] != $_serviceLit->getLitsSpe2() ){
				$_serviceLit->setLitsSpe2($_REQUEST['lit_spe2']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['lit_spe3'])){
			if ($_REQUEST['lit_spe3'] != $_serviceLit->getLitsSpe3() ){
				$_serviceLit->setLitsSpe3($_REQUEST['lit_spe3']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['lit_spe4'])){
			if ($_REQUEST['lit_spe4'] != $_serviceLit->getLitsSpe4() ){
				$_serviceLit->setLitsSpe4($_REQUEST['lit_spe4']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['lit_spe5'])){
			if ($_REQUEST['lit_spe5'] != $_serviceLit->getLitsSpe5() ){
				$_serviceLit->setLitsSpe5($_REQUEST['lit_spe5']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['lit_spe6'])){
			if ($_REQUEST['lit_spe6'] != $_serviceLit->getLitsSpe6() ){
				$_serviceLit->setLitsSpe6($_REQUEST['lit_spe6']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['lit_spe7'])){
			if ($_REQUEST['lit_spe7'] != $_serviceLit->getLitsSpe7() ){
				$_serviceLit->setLitsSpe7($_REQUEST['lit_spe7']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['lits_respi'])){
			if ($_REQUEST['lits_respi'] != $_serviceLit->getLitsRespirateur()){
				$_serviceLit->setLitsRespirateur($_REQUEST['lits_respi']);
			}
			$vDonneModifiee = true;
		}
		if (isset($_REQUEST['lits_pneg'])){
			if ($_REQUEST['lits_pneg'] != $_serviceLit->getLitsIsolement()){
				$_serviceLit->setLitsIsolement($_REQUEST['lits_pneg']);
			}
			$vDonneModifiee = true;
		}
		
		return $vDonneModifiee;
	}
	
	private function getServiceDao(){
		if($this->serviceDao == null){
			$this->serviceDao = Dao_Structure_Service::getInstance();
		}
		return $this->serviceDao;
	}
	
	public function setServiceDao (&$_vSericeDao){
		$this->serviceDao = $_vSericeDao;
	}
	
	private function getUfDao(){
		if($this->ufDao == null){
			$this->ufDao = Dao_Structure_Uf::getInstance();
		}
		return $this->ufDao;
	}
	
	public function setUfDao (&$_vUfDao){
		$this->ufDao = $_vUfDao;
	}
	
	private function getTypeStructureDao(){
		if($this->typeStructureDao == null){
			$this->typeStructureDao = Dao_Structure_TypeStructure::getInstance();
		}
		return $this->typeStructureDao;
	}
	
	public function setTypeStructureDao(){
		return $this->typeStructureDao;
	}
	
	/**
	 * Agrège les données par discipline
	 * @param $_etablissements (Objet_Structure_Etablissement[]): liste des établissements concernés
	 * @param $_listeDisciplinesId (int[]): liste des code discipline concerné
	 * @param $_dateDebut (timestamp, int): début de plage
	 * @param $_dateFin (timestamp, int): fin de plage
	 * @return Tableau avec:
	 * 		date (string: format mysql) - Tableau avec
	 *	 		Id etablissement (int)- Tableau avec
	 * 				code discipline (string) - Tableau avec
	 * 					0 - nombre de lits disponibles
	 */
	public function &ChercheListeLitsParDateEtablissement (&$_etablissements, $_listeDisciplinesId, $_dateDebut, $_dateFin){
		$vServiceDao = $this->getServiceDao();
		
		$vTmpDonnees = $vServiceDao->ChercheListeLitsParDateEtablissement($_etablissements, $_listeDisciplinesId, $_dateDebut, $_dateFin);

		$vDonnees = array();
		foreach ($vTmpDonnees as $vDate => $vTmpDonneesDate){
			$vDonnees[$vDate] = array();
			$vDonneesDate = &$vDonnees[$vDate];
			
			foreach ($vTmpDonneesDate as $vEtablissementID => $vTmpDonneeDateEtb){
				$vDonneesDate[$vEtablissementID] = array();
				$vDonneesDateEtb = &$vDonneesDate[$vEtablissementID];
				
				foreach ($vTmpDonneeDateEtb as $vServiceId => $vTmpTabDonnees){

					$vCdeDiscipline = $vTmpTabDonnees[0];
					if (!isset($vCdeDiscipline) || strlen(trim($vCdeDiscipline)) == 0){
						$vCdeDiscipline = "NC";
					}
					$vLitsDisponibles = $vTmpTabDonnees[1];
					if (!isset($vDonneesDateEtb[$vCdeDiscipline])){
						$vDonneesDateEtb[$vCdeDiscipline] = array();
					}
					
					$vTabDonnees = &$vDonneesDateEtb[$vCdeDiscipline];
					
					if (isset($vTabDonnees[0])){
						$vTabDonnees[0] += $vLitsDisponibles;
					}
					else{
						$vTabDonnees[0] = $vLitsDisponibles;
					}
				}
			}
		}
		
		$vUfDao = $this->getUfDao();
		$vTmpDonnees = $vUfDao->ChercheListeLitsParDateEtablissement($_etablissements, $_listeDisciplinesId, $_dateDebut, $_dateFin);
		foreach ($vTmpDonnees as $vDate => $vTmpDonneesDate){
			if (!isset($vDonnees[$vDate])){
				$vDonnees[$vDate] = array();
			}
			$vDonneesDate = &$vDonnees[$vDate];
			
			foreach ($vTmpDonneesDate as $vEtablissementID => $vTmpDonneeDateEtb){
				if (!isset($vDonneesDate[$vEtablissementID])){
					$vDonneesDate[$vEtablissementID] = array();
				}
				$vDonneesDateEtb = &$vDonneesDate[$vEtablissementID];
				
				foreach ($vTmpDonneeDateEtb as $vServiceId => $vTmpTabDonnees){

					$vCdeDiscipline = $vTmpTabDonnees[0];
					if (!isset($vCdeDiscipline) || strlen(trim($vCdeDiscipline)) == 0){
						$vCdeDiscipline = "NC";
					}
					$vLitsDisponibles = $vTmpTabDonnees[1];
					if (!isset($vDonneesDateEtb[$vCdeDiscipline])){
						$vDonneesDateEtb[$vCdeDiscipline] = array();
					}
					
					$vTabDonnees = &$vDonneesDateEtb[$vCdeDiscipline];
					
					if (isset($vTabDonnees[0])){
						$vTabDonnees[0] += $vLitsDisponibles;
					}
					else{
						$vTabDonnees[0] = $vLitsDisponibles;
					}
				}
			}
		}
		return $vDonnees;
	}
	
	/**
	 * Cherche la liste des discipline ARH pour les services
	 * @return Objet_Structure_DisciplineArh[]
	 */
	public function &chercheListeDisciplineArh (){
		$vDisciplineArhDao = new Dao_Structure_DisciplineArh();
		
		return $vDisciplineArhDao->ChercheDisciplines();
	}
}
?>