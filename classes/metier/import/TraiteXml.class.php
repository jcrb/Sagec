<?php
require_once $BackToRoot."classes/objet/import/DonneesEtabl.class.php";
require_once $BackToRoot."classes/objet/import/IndicateurJour.class.php";
require_once $BackToRoot."classes/objet/import/SauJour.class.php";
require_once $BackToRoot."classes/objet/import/SamuJour.class.php";
require_once $BackToRoot."classes/objet/import/LitsJour.class.php";
require_once $BackToRoot."classes/objet/structure/sau/Service.class.php";
require_once $BackToRoot."classes/objet/structure/sau/Uf.class.php";
require_once $BackToRoot."classes/objet/structure/lit/Service.class.php";
require_once $BackToRoot."classes/objet/structure/lit/Uf.class.php";

require_once $BackToRoot."classes/objet/exception/SqlException.class.php";
require_once $BackToRoot."classes/objet/exception/StructureNotFoundException.class.php";

require_once $BackToRoot."classes/metier/util/Date.class.php";

require_once $BackToRoot."classes/dao/structure/Etablissement.class.php";
require_once $BackToRoot."classes/dao/structure/Service.class.php";
require_once $BackToRoot."classes/dao/structure/Uf.class.php";
require_once $BackToRoot."classes/dao/veille/Indicateur.class.php";
require_once $BackToRoot."classes/dao/veille/Samu.class.php";

/**
 * Transforme un arbre au format XML en objets
 * 
 * @package Metier_Import
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */

class Metier_Import_TraiteXml{
	/**
	 * Cache pour les services
	 * @var array[array[]]
	 */
	private static $serviceCache = array();
	/**
	 * cache pour les UF (on par du principe que un établissement n'utilise pas 2x le même UF
	 * @var array[array[]]
	 */
	private static $ufCache = array();
	/**
	 * Traire le fichier XML passé en paramètre
	 * @param $_fichier (string): fichier à raiter
	 * @return (Objet_Import_DonneesEtabl)
	 */
	public static function TraiteFichier($_fichier){
		$vDonneesEtablissement = new Objet_Import_DonneesEtabl;
		
		$vDocumentRoot = simplexml_load_file($_fichier);
		
		// lecture de l'établissement associé au fichier XML
		if (!Metier_Import_TraiteXml::XmlEtablissementVersObj($vDonneesEtablissement, $vDocumentRoot)){
			// L'application ne trouve pas l'établissement associé au code FINESS
			return false;
		}
		
		// lecture des indicateurs
		Metier_Import_TraiteXml::XmlIndicateurVersObj($vDonneesEtablissement, $vDocumentRoot);
		
		// lectures des données SAU
		Metier_Import_TraiteXml::XmlSauVersObj($vDonneesEtablissement, $vDocumentRoot);
		
		// lecture des données SAMU
		Metier_Import_TraiteXml::XmlSamuVersObj($vDonneesEtablissement, $vDocumentRoot);
		
		// lectures des disponibilités en lits
		Metier_Import_TraiteXml::XmlLitsVersObj($vDonneesEtablissement, $vDocumentRoot);
		
		// Sauvegarde des indicateurs
		Metier_Import_TraiteXml::ObjIndicateurVersDb($vDonneesEtablissement);
		
		// Sauvegarder des données SAU
		Metier_Import_TraiteXml::ObjSauVersDb($vDonneesEtablissement);
		
		// sauvegarde des données SAMU
		Metier_Import_TraiteXml::ObjSamuVersDb($vDonneesEtablissement);
		
		// sauvegrade des disponibilités en lit
		Metier_Import_TraiteXml::ObjLitVersDb($vDonneesEtablissement);
		
		Metier_Import_Rapport::ajouterMessage ($vDonneesEtablissement->getEtablissement(), 0, 0, "Fichier ".$_fichier." trait&eacute;");
		
		return $vDonneesEtablissement;
	}
	
	/**
	 * Sauvegarde une UF Lit dans la base de données
	 * @param _DonneesEtablissement (Objet_Structure_Etablissement): Données de l'établissement
	 * @param $_litService (Objet_Structure_Lit_Service): Service Lit
	 * @param $_litUf (Objet_Structure_Lit_Uf): Uf Lit à enregistrer
	 * @return (bool) true si l'enregistement est effectué
	 */
	public static function ObjLitUfVersDb (&$_etablissement, &$_litService, &$_litUf, $_jour){
		try {
			Dao_Structure_Uf::MajLitUf($_etablissement, $_litService, $_litUf, $_jour);
		}
		catch (Objet_Exception_SqlException $vException) {
			Metier_Import_Rapport::ajouterMessage ($_etablissement, $_jour, 4, $vException->getMessage());
		}
	}
	
	/**
	 * Sauvegarde le service Lit dans la base de données
	 * @param _DonneesEtablissement (Objet_Structure_Etablissement): Données de l'établissement
	 * @param $_litService (Objet_Structure_Lit_Service): Service Lit à enregistrer
	 * @return (bool) true si l'enregistement est effectué
	 */
	public static function ObjLitServiceVersDb (&$_etablissement, &$_litService, $_jour){
		try {
			Dao_Structure_Service::MajLitService($_etablissement, $_litService, $_jour);
		}
		catch (Objet_Exception_SqlException $vException) {
			Metier_Import_Rapport::ajouterMessage ($_etablissement, $_jour, 4, $vException->getMessage());
		}
		if ($_litService->getListeUf() != null){ // la liste des Uf est null si l'UF n'est pas trouvé dans la liste
			foreach ($_litService->getListeUf() as $vLitUf){
				Metier_Import_TraiteXml::ObjLitUfVersDb($_etablissement, $_litService, $vLitUf, $_jour);
			}
		}
	}
	
	/**
	 * Sauvegarde les données Lit dans la base de données
	 * @param _DonneesEtablissement (Objet_Import_DonneesEtabl): Données de l'établissement
	 * @return (bool) true si l'enregistement est effectué
	 */
	public static function ObjLitVersDb(&$_DonneesEtablissement){
		foreach ($_DonneesEtablissement->getListeLitsJour() as $vLitJour){
			foreach ($vLitJour->getListeService() as $vLitService) {
				Metier_Import_TraiteXml::ObjLitServiceVersDb($_DonneesEtablissement->getEtablissement(), $vLitService, $vLitJour->getJour());
			}
		}
	}
	
	/**
	 * Sauvegarde une UF SAU dans la base de données
	 * @param _DonneesEtablissement (Objet_Structure_Etablissement): Données de l'établissement
	 * @param $_sauService (Objet_Structure_Sau_Service): Service SAU
	 * @param $_sauUf (Objet_Structure_Sau_Uf): Uf SAU à enregistrer
	 * @return (bool) true si l'enregistement est effectué
	 */
	public static function ObjSauUfVersDb (&$_etablissement, &$_sauService, &$_sauUf, $_jour){
		try {
			Dao_Structure_Uf::MajSauUf($_etablissement, $_sauService, $_sauUf, $_jour);
		}
		catch (Objet_Exception_SqlException $vException) {
			Metier_Import_Rapport::ajouterMessage ($_etablissement, $_jour, 4, $vException->getMessage());
		}
	}
	
	/**
	 * Sauvegarde le service SAU dans la base de données
	 * @param _DonneesEtablissement (Objet_Structure_Etablissement): Données de l'établissement
	 * @param $_sauService (Objet_Structure_Sau_Service): Service SAU à enregistrer
	 * @return (bool) true si l'enregistement est effectué
	 */
	public static function ObjSauServiceVersDb (&$_etablissement, &$_sauService, $_jour){
		try {
			Dao_Structure_Service::MajSauService($_etablissement, $_sauService, $_jour);
		}
		catch (Objet_Exception_SqlException $vException) {
			Metier_Import_Rapport::ajouterMessage ($_etablissement, $_jour, 4, $vException->getMessage());
		}
		
		$vListeUf = $_sauService->getListeUf();
		if (isset($vListeUf)){
			foreach ($vListeUf as $vSauUf){
				Metier_Import_TraiteXml::ObjSauUfVersDb($_etablissement, $_sauService, $vSauUf, $_jour);
			}
		}
	}
	
	/**
	 * Sauvegarde les données SAU dans la base de données
	 * @param _DonneesEtablissement (Objet_Import_DonneesEtabl): Données de l'établissement
	 * @return (bool) true si l'enregistement est effectué
	 */
	public static function ObjSauVersDb(&$_DonneesEtablissement){
		foreach ($_DonneesEtablissement->getListeSauJour() as $vSauJour){
			foreach ($vSauJour->getListeService() as $vSauService) {
				Metier_Import_TraiteXml::ObjSauServiceVersDb($_DonneesEtablissement->getEtablissement(), $vSauService, $vSauJour->getJour());
			}
		}
	}
	
	// Dao_Veille_Samu::MajSamuVeille($_DonneesEtablissement->getEtablissement(), $vSamuJour);
	
	/**
	 * Sauvegarde les indicateurs dans la base de données
	 * @param _DonneesEtablissement (Objet_Import_DonneesEtabl): Données de l'établissement
	 * @return (bool) true si l'enregistement est effectué
	 */
	public static function ObjSamuVersDb(&$_DonneesEtablissement){
		foreach ($_DonneesEtablissement->getListeSamuJour() as $vSamuJour){
			try {
				Dao_Veille_Samu::MajSamuVeille($_DonneesEtablissement->getEtablissement(), $vSamuJour);
			}
			catch (Objet_Exception_SqlException $vException) {
				Metier_Import_Rapport::ajouterMessage ($_DonneesEtablissement->getEtablissement(), $vSamuJour->getJour(), 4, $vException->getMessage());
			}
		}
	}
	
	/**
	 * Sauvegarde les indicateurs dans la base de données
	 * @param _DonneesEtablissement (Objet_Import_DonneesEtabl): Données de l'établissement
	 * @return (bool) true si l'enregistement est effectué
	 */
	public static function ObjIndicateurVersDb(&$_DonneesEtablissement){
		foreach ($_DonneesEtablissement->getListeIndicateurJour() as $vIndicateurJour){
			try {
				Dao_Veille_Indicateur::MajIndicateurVeille($_DonneesEtablissement->getEtablissement(), $vIndicateurJour);
			}
			catch (Objet_Exception_SqlException $vException) {
				Metier_Import_Rapport::ajouterMessage ($_DonneesEtablissement->getEtablissement(), $vIndicateurJour->getJour(), 4, $vException->getMessage());
			}
		}
	}
	
	/**
	 * Copie les données LITS de l'arbre XML vers le ou les objets LitsJour
	 * @param _donneesEtablissement: objet à compléter
	 * @param _documentRoot: arbre XML
	 */
	public static function XmlLitsVersObj(&$_donneesEtablissement, &$_documentRoot){
		
		$vNoeudSau = $_documentRoot->xpath('//LITS');
		if (count($vNoeudSau) == 0){
     		return;
     	}
		
     	$vNoeudJournee = $vNoeudSau[0]->xpath('./JOURNEE');
     	
     	for ($vCpt =0; $vCpt < count($vNoeudJournee); $vCpt++){
     		// enregistrement jour par jour
     		$vNoeudJour = $vNoeudJournee[$vCpt]->jour;
     		if (isset($vNoeudJour)){
     			$vLitsJour = new Objet_Import_LitsJour;
     			$vTimestamp = Metier_Util_Date::StringDateVersTimestamp(strVal($vNoeudJour[0]));
     			
     			// application d'un offest pour combler le manque du l'heure
     			$vFiness = $_donneesEtablissement->getEtablissement()->getFiness();
     			if ($vFiness == "680000627"){
     				// Ch de Mulhouse, on ajoute 23h59
     				$vTimestamp += 23 * 60 * 60 + 59 * 60 + 59;
     			}
     			if ($vFiness == "670000397" || $vFiness == "670000405"){
     				// Ch de Séléstat ou d'Obernai, on ajoute 11h00
     				$vTimestamp += 11 *60 * 60;
     			}
     			
     			$vLitsJour->setJour($vTimestamp);
     			
     			$vNoeudService = $vNoeudJournee[$vCpt]->SERVICE;
     			for ($vCptService =0; $vCptService < count($vNoeudService); $vCptService++){
     				Metier_Import_TraiteXml::XmlLitServiceVersObj($_donneesEtablissement, $vLitsJour, $vNoeudService[$vCptService]);
     			}
     			
     			$_donneesEtablissement->ajouterLitsJour($vLitsJour);
     		}
     	}
	}
	
	/**
	 * Copie les données des services lits de l'arbre XML vers le ou les objets Service
	 * @param _jourSau: objet à compléter
	 * @param _documentJour: sous arbre service du fichier XML
	 */
	public static function XmlLitServiceVersObj(&$_donneesEtablissement, &$_LitsJour, &$_documentService){
		
		$vNoeudServiceCode = $_documentService->service_id;
		
		if (isset($vNoeudServiceCode)){
			$vServiceCode = strval($vNoeudServiceCode[0]);
			
			$vEtablissement = $_donneesEtablissement->getEtablissement();
			try {
				$vService = Metier_Import_TraiteXml::LireServiceCache($vEtablissement, $vServiceCode);
				if ($vService == null){
					$vService = Dao_Structure_Service::ChercheParCode($vEtablissement, $vServiceCode);
					Metier_Import_TraiteXml::EcrireServiceCache($vEtablissement, $vService);
				}
			}
			catch (Objet_Exception_SqlException $vException){
				Metier_Import_Rapport::ajouterMessage ($_donneesEtablissement->getEtablissement(), $_LitsJour->getJour(), 4, $vException->getMessage());
				return NULL;
			}
			catch (Objet_Exception_StructureNotFoundException $vException){
				Metier_Import_Rapport::ajouterMessage ($_donneesEtablissement->getEtablissement(), $_LitsJour->getJour(), 3, $vException->getMessage());
				return NULL;
			}
			
			$vServiceLit = new Objet_Structure_Lit_Service($vService);
			
			// mise à jour des ufs
			$vNoeudUf = $_documentService->xpath('./UF');
			
			for ($vCptUf =0; $vCptUf < count($vNoeudUf); $vCptUf++){
				Metier_Import_TraiteXml::XmlLitUfVersObj($_donneesEtablissement, $_LitsJour, $vServiceLit, $vNoeudUf[$vCptUf]);
			}
			
			Metier_Import_TraiteXml::MajServiceLit($vServiceLit);
			$_LitsJour->ajouterService($vServiceLit);
		}
	}
	
	/**
	 * Copie les données des UF SAU de l'arbre XML vers le ou les objets Uf
	 * @param _serviceSau: objet à compléter
	 * @param _documentservice: sous arbre uf du fichier XML
	 */
	public static function XmlLitUfVersObj(&$_donneesEtablissement, &$_LitsJour, &$_serviceLit, &$_documentUf){
		$vNoeudUfCode = $_documentUf->id_UF;
		
		$vUfCode = NULL;
		if (isset($vNoeudUfCode)){
			$vUfCode = strval($vNoeudUfCode);
		}
		if ($vUfCode == NULL || strlen($vUfCode) == 0){
			$vNoeudUfCode = $_documentUf->id_uf;
			if (isset($vNoeudUfCode)){
				$vUfCode = strval($vNoeudUfCode);				
			}
		}
		
		$vUf = NULL;
		if ($vUfCode != NULL){
			try {
				$vEtablissement = $_donneesEtablissement->getEtablissement();
				$vUf = Metier_Import_TraiteXml::LireUfCache($vEtablissement, $vUfCode);
				if ($vUf == null){
					$vUf = Dao_Structure_Uf::ChercheParCode($vEtablissement, $vUfCode);
					Metier_Import_TraiteXml::EcrireUfCache($vEtablissement, $vUf);
				}
			}
			catch (Objet_Exception_SqlException $vException){
				Metier_Import_Rapport::ajouterMessage ($_donneesEtablissement->getEtablissement(), $_LitsJour->getJour(), 4, $vException->getMessage());
				return NULL;
			}
			catch (Objet_Exception_StructureNotFoundException $vException){
				Metier_Import_Rapport::ajouterMessage ($_donneesEtablissement->getEtablissement(), $_LitsJour->getJour(), 3, $vException->getMessage());
				return NULL;
			}
		}
				
		if ($vUf != NULL){
			// lecture des champs
			$litsInstalles = NULL;
			$vNoeudLitsInstalles = $_documentUf->lits_installes;
			if (isset($vNoeudLitsInstalles)){
				$litsInstalles = strval($vNoeudLitsInstalles);
			}
					
			$litsOuverts = NULL;
			$vNoeudLitsOuverts = $_documentUf->lits_ouverts;
			if (isset($vNoeudLitsOuverts)){
				$litsOuverts = strval($vNoeudLitsOuverts);
			}
					
			$litsOccupes = NULL;
			$vNoeudLitsOccupes = $_documentUf->lits_occupes;
			if (isset($vNoeudLitsOccupes)){
				$litsOccupes = strval($vNoeudLitsOccupes);
			}
					
			$litsSupplementaires = NULL;
			$vNoeudLitsSupplementaires = $_documentUf->lits_supplementaires;
			if (isset($vNoeudLitsSupplementaires)){
				$litsSupplementaires = strval($vNoeudLitsSupplementaires);
			}
					
			$litsDisponibles = NULL;
			$vNoeudLitsDisponibles = $_documentUf->lits_disponibles;
			if (isset($vNoeudLitsDisponibles)){
				$litsDisponibles = strval($vNoeudLitsDisponibles);
			}

			$litsFermes = NULL;
			$vNoeudLitsFermes = $_documentUf->lits_fermes;
			if (isset($vNoeudLitsFermes)){
				$litsFermes = strval($vNoeudLitsFermes);
			}
			
			$places_disponibles = NULL;
			$vNoeudPlaces_disponibles = $_documentUf->places_disponibles;
			if (isset($vNoeudPlaces_disponibles)){
				$places_disponibles = strval($vNoeudPlaces_disponibles[0]);
			}

			$permissions = NULL;
			$vNoeudPermissions = $_documentUf->permissions;
			if (isset($vNoeudPermissions)){
				$permissions = strval($vNoeudPermissions);
			}
					
			if ($litsInstalles != NULL || $litsOuverts != NULL || $litsOccupes != NULL || $litsSupplementaires != NULL || $litsDisponibles != NULL || $litsFermes != NULL || $places_disponibles != NULL || $permissions != NULL){
				// aumoins un des champs es saisie
				$litsInstalles = intval($litsInstalles);
				$litsOuverts = intval($litsOuverts);
				$litsOccupes = intval($litsOccupes);
				$litsSupplementaires = intval($litsSupplementaires);
				$litsDisponibles = intval($litsDisponibles);
				$litsFermes = intval($litsFermes);
				$places_disponibles = intval($places_disponibles);
				$permissions = intval($permissions);
				
				$vUfLit = new Objet_Structure_Lit_Uf($vUf);
				$vUfLit->setLitsInstalles($litsInstalles);
				$vUfLit->setLitsOuverts($litsOuverts);
				$vUfLit->setLitsOccupes($litsOccupes);
				$vUfLit->setLitsSupplementaires($litsSupplementaires);
				$vUfLit->setLitsDisponibles($litsDisponibles);
				$vUfLit->setLitsFermes($litsFermes);
				$vUfLit->setPlaces_disponibles($places_disponibles);
				$vUfLit->setPermissions($permissions);
					
				$_serviceLit->ajouterUf($vUfLit);
			}
		}
	}
	
	/**
	 * Copie les données SAMU de l'arbre XML vers le ou les objets SamuJour
	 */
	public static function XmlSamuVersObj(&$_donneesEtablissement, &$_documentRoot){
		
		$vNoeudSamu = $_documentRoot->xpath('//SAMU');
		if (count($vNoeudSamu) == 0){
			return;
		}
     	
     	$vNoeudJournee = $vNoeudSamu[0]->xpath('./JOURNEE');
     	for ($vCpt =0; $vCpt < count($vNoeudJournee); $vCpt++){
     		// enregistrement jour par jour
     		$vNoeudJour = $vNoeudJournee[$vCpt]->jour;
     		if (isset($vNoeudJour)){
     			$vSamuJour = new Objet_Import_SamuJour;
     			
     			$vTimestamp = Metier_Util_Date::StringDateVersTimestamp(strVal($vNoeudJour[0]));
     			$vSamuJour->setJour($vTimestamp);
     			
     			// lecture des champs
				$vAffaires = NULL;
				$vNoeudAffaires = $vNoeudJournee[$vCpt]->affaires;
				if (isset($vNoeudAffaires)){
					$vAffaires = strval($vNoeudAffaires);
				}
				
     			$vSdis = NULL;
				$vNoeudSdis = $vNoeudJournee[$vCpt]->sdis;
				if (isset($vNoeudSdis)){
					$vSdis = strval($vNoeudSdis);
				}
				
     			$vAmbu = NULL;
				$vNoeudAmbu = $vNoeudJournee[$vCpt]->ambu;
				if (isset($vNoeudAmbu)){
					$vAmbu = strval($vNoeudAmbu);
				}
				
     			$vInterv = NULL;
				$vNoeudInterv = $vNoeudJournee[$vCpt]->interv;
				if (isset($vNoeudInterv)){
					$vInterv = strval($vNoeudInterv);
				}
				
     			$vPrimaire = NULL;
				$vNoeudPrimaire = $vNoeudJournee[$vCpt]->primaire;
				if (isset($vNoeudPrimaire)){
					$vPrimaire = strval($vNoeudPrimaire);
				}
				
     			$vSecondaire = NULL;
				$vNoeudSecondaire = $vNoeudJournee[$vCpt]->secondaire;
				if (isset($vNoeudSecondaire)){
					$vSecondaire = strval($vNoeudSecondaire);
				}
				
     			$vConseil = NULL;
				$vNoeudConseil = $vNoeudJournee[$vCpt]->conseil;
				if (isset($vNoeudConseil)){
					$vConseil = strval($vNoeudConseil);
				}
				
     			$vEnvoiMed = NULL;
				$vNoeudEnvoiMed = $vNoeudJournee[$vCpt]->envoi_med;
				if (isset($vNoeudEnvoiMed)){
					$vEnvoiMed = strval($vNoeudEnvoiMed);
				}
				
     			$vTiih = NULL;
				$vNoeudTiih = $vNoeudJournee[$vCpt]->tiih;
				if (isset($vNoeudTiih)){
					$vTiih = strval($vNoeudTiih);
				}
				
     			$vNeonat = NULL;
				$vNoeudNeonat = $vNoeudJournee[$vCpt]->neonat;
				if (isset($vNoeudNeonat)){
					$vNeonat = strval($vNoeudNeonat);
				}
				
	     		if ($vAffaires != NULL || $vSdis != NULL || $vAmbu != NULL || $vInterv != NULL || $vPrimaire != NULL || $vSecondaire != NULL || $vConseil != NULL || $vEnvoiMed != NULL || $vTiih != NULL || $vNeonat != NULL){
					// aumoins un des champs es saisie
					$vAffaires = intval($vAffaires);
					$vSdis = intval($vSdis);
					$vAmbu = intval($vAmbu);
					$vInterv = intval($vInterv);
					$vPrimaire = intval($vPrimaire);
					$vSecondaire = intval($vSecondaire);
					$vConseil = intval($vConseil);
					$vEnvoiMed = intval($vEnvoiMed);
					$vTiih = intval($vTiih);
					$vNeonat = intval($vNeonat);
							
					$vSamuJour->setNbAffaires($vAffaires);
					$vSamuJour->setNbSdis($vSdis);
					$vSamuJour->setNbAmbu($vAmbu);
					$vSamuJour->setNbInterv($vInterv);
					$vSamuJour->setNbPrimaire($vPrimaire);
					$vSamuJour->setNbSecondaire($vSecondaire);
					$vSamuJour->setNbConseil($vConseil);
					$vSamuJour->setNbEnvoieMed($vEnvoiMed);
					$vSamuJour->setNbTiih($vTiih);
					$vSamuJour->setNbNeonat($vNeonat);
						
					$_donneesEtablissement->ajouterSamuJour($vSamuJour);
				}
     		}
     		
     	}
	}
	
	/**
	 * Copie les données SAU de l'arbre XML vers le ou les objets SauJour
	 * @param _donneesEtablissement: objet à compléter
	 * @param _documentRoot: arbre XML
	 */
	public static function XmlSauVersObj(&$_donneesEtablissement, &$_documentRoot){
		
		$vNoeudSau = $_documentRoot->xpath('//SAU');
		if (count($vNoeudSau) == 0){
     		return;
     	}
		
     	$vNoeudJournee = $vNoeudSau[0]->xpath('./JOURNEE');
     	
     	for ($vCpt =0; $vCpt < count($vNoeudJournee); $vCpt++){
     		// enregistrement jour par jour
     		$vNoeudJour = $vNoeudJournee[$vCpt]->jour;
     		if (isset($vNoeudJour)){
     			$vSauJour = new Objet_Import_SauJour;
     			$vTimestamp = Metier_Util_Date::StringDateVersTimestamp(strVal($vNoeudJour[0]));
     			$vSauJour->setJour($vTimestamp);
     			
     			$vNoeudService = $vNoeudJournee[$vCpt]->xpath('./SERVICE');
     			for ($vCptService =0; $vCptService < count($vNoeudService); $vCptService++){
     				Metier_Import_TraiteXml::XmlSauServiceVersObj($_donneesEtablissement, $vSauJour, $vNoeudService[$vCptService]);
     			}
     			
     			$_donneesEtablissement->ajouterSauJour($vSauJour);
     		}
     	}
	}
	
	/**
	 * Copie les données des services SAU de l'arbre XML vers le ou les objets Service
	 * @param _jourSau: objet à compléter
	 * @param _documentJour: sous arbre service du fichier XML
	 */
	public static function XmlSauServiceVersObj(&$_donneesEtablissement, &$_jourSau, &$_documentService){
		
		$vNoeudServiceCode = $_documentService->service_id;
		
		if (isset($vNoeudServiceCode)){
			$vServiceCode = strval($vNoeudServiceCode);
			
			$vEtablissement = $_donneesEtablissement->getEtablissement();
			
			try {
				$vService = Dao_Structure_Service::ChercheParCode($vEtablissement, $vServiceCode);
			}
			catch (Objet_Exception_SqlException $vException){
				Metier_Import_Rapport::ajouterMessage ($_donneesEtablissement->getEtablissement(), $_jourSau->getJour(), 4, $vException->getMessage());
				return NULL;
			}
			catch (Objet_Exception_StructureNotFoundException $vException){
				Metier_Import_Rapport::ajouterMessage ($_donneesEtablissement->getEtablissement(), $_jourSau->getJour(), 3, $vException->getMessage());
				return NULL;
			}

			
			$vServiceSau = new Objet_Structure_Sau_Service($vService);
			
			// mise à jour des ufs
			$vNoeudUf = $_documentService->xpath('./UF');
			
			for ($vCptUf =0; $vCptUf < count($vNoeudUf); $vCptUf++){
				Metier_Import_TraiteXml::XmlSauUfVersObj($_donneesEtablissement, $_jourSau, $vServiceSau, $vNoeudUf[$vCptUf]);
			}
			
			Metier_Import_TraiteXml::MajServiceSau($vServiceSau);
			$_jourSau->ajouterService($vServiceSau);
		}
	}
	
	/**
	 * Copie les données des UF SAU de l'arbre XML vers le ou les objets Uf
	 * @param _serviceSau: objet à compléter
	 * @param _documentservice: sous arbre uf du fichier XML
	 */
	public static function XmlSauUfVersObj(&$_donneesEtablissement, &$_jourSau, &$_serviceSau, &$_documentUf){
		$vNoeudUfCode = $_documentUf->id_UF;
		
		$vEtablissement = &$_donneesEtablissement->getEtablissement();
		
		$vUfCode = NULL;
		if (isset($vNoeudUfCode)){
			$vUfCode = strval($vNoeudUfCode);
		}
		if ($vUfCode == NULL || strlen($vUfCode) == 0){
			$vNoeudUfCode = $_documentUf->uf_id;
			if (isset($vNoeudUfCode)){
				$vUfCode = strval($vNoeudUfCode);				
			}
		}
		
		$vUf = NULL;
		if ($vUfCode != NULL){
			try {
				$vUf = Dao_Structure_Uf::ChercheParCode($vEtablissement, $vUfCode);
			}
			catch (Objet_Exception_SqlException $vException){
				Metier_Import_Rapport::ajouterMessage ($vEtablissement, $_jourSau->getJour(), 4, $vException->getMessage());
				return NULL;
			}
			catch (Objet_Exception_StructureNotFoundException $vException){
				Metier_Import_Rapport::ajouterMessage ($vEtablissement, $_jourSau->getJour(), 3, $vException->getMessage());
				return NULL;
			}
		}
				
		if ($vUf != NULL){
			// lecture des champs
			$vNbUrgence = NULL;
			$vNoeudNbUrgence = $_documentUf->urg;
			if (isset($vNoeudNbUrgence)){
				$vNbUrgence = strval($vNoeudNbUrgence);
			}
					
			$vNbUrgMoins1an = NULL;
			$vNoeudNbUrgMoins1an = $_documentUf->urg1a;
			if (isset($vNoeudNbUrgMoins1an)){
				$vNbUrgMoins1an = strval($vNoeudNbUrgMoins1an);
			}
					
			$vNbUrgPlus75ans = NULL;
			$vNoeudNbUrgPlus75ans = $_documentUf->urg75a;
			if (isset($vNoeudNbUrgPlus75ans)){
				$vNbUrgPlus75ans = strval($vNoeudNbUrgPlus75ans);
			}
					
			$vNbHospitalisation = NULL;
			$vNoeudNbHospitalisation = $_documentUf->hosp;
			if (isset($vNoeudNbHospitalisation)){
				$vNbHospitalisation = strval($vNoeudNbHospitalisation);
			}
					
			$vNbTransUhcd = NULL;
			$vNoeudNbTransUhcd = $_documentUf->uhcd;
			if (isset($vNoeudNbTransUhcd)){
				$vNbTransUhcd = strval($vNoeudNbTransUhcd);
			}
			if ($vNbTransUhcd == NULL || strlen($vNbTransUhcd) == 0){
				$vNoeudNbTransUhcd = $_documentUf->uhtcd;
				if (isset($vNoeudNbTransUhcd)){
					$vNbTransUhcd = strval($vNoeudNbTransUhcd);
				}
			}

			$vNbTransAutre = NULL;
			$vNoeudNbTransAutre = $_documentUf->transferts;
			if (isset($vNoeudNbTransAutre)){
				$vNbTransAutre = strval($vNoeudNbTransAutre);
			}
					
			if ($vNbUrgence != NULL || $vNbUrgMoins1an != NULL || $vNbUrgPlus75ans != NULL || $vNbHospitalisation != NULL || $vNbTransUhcd != NULL || $vNbTransAutre != NULL){
				// aumoins un des champs es saisie
				$vNbUrgence = intval($vNbUrgence);
				$vNbUrgMoins1an = intval($vNbUrgMoins1an);
				$vNbUrgPlus75ans = intval($vNbUrgPlus75ans);
				$vNbHospitalisation = intval($vNbHospitalisation);
				$vNbTransUhcd = intval($vNbTransUhcd);
				$vNbTransAutre = intval($vNbTransAutre);
				
				$vUfSau = new Objet_Structure_Sau_Uf($vUf);
				$vUfSau->setNbUrgence($vNbUrgence);
				$vUfSau->setNbUrgMoins1an($vNbUrgMoins1an);
				$vUfSau->setNbUrgPlus75ans($vNbUrgPlus75ans);
				$vUfSau->setNbHospitalisation($vNbHospitalisation);
				$vUfSau->setNbTransUhcd($vNbTransUhcd);
				$vUfSau->setNbTransAutre($vNbTransAutre);
					
				$_serviceSau->ajouterUf($vUfSau);
			}
		}
		else {
			Metier_Import_Rapport::ajouterMessage ($vEtablissement, $_jourSau->getJour(), 3, "L'UF de code ".$vUfCode." n'existe pas dans l'application (SAU)");
		}
	}
	
	/**
	 * Copie les indicateurs de l'arbre XML vers le ou les objets IndicateurJours
	 * @param _donneesEtablissement: objet à compléter
	 * @param _documentRoot: arbre XML
	 */
	public static function XmlIndicateurVersObj(&$_donneesEtablissement, &$_documentRoot){
		
		$vNoeudIndicateur = $_documentRoot->xpath('//INDICATEURS');
		if (count($vNoeudIndicateur) == 0){
			return;
		}
		
     	$vNoeudJournee = $vNoeudIndicateur[0]->xpath('./JOURNEE');
     	for ($vCpt =0; $vCpt < count($vNoeudJournee); $vCpt++){
     		// enregistrement jour par jour
     		$vNoeudJour = $vNoeudJournee[$vCpt]->jour;
     		if (isset($vNoeudJour)){
     			$vIndicateurJour = new Objet_Import_IndicateurJour;
     			$vTimestamp = Metier_Util_Date::StringDateVersTimestamp(strVal($vNoeudJour));
     			$vIndicateurJour->setJour($vTimestamp);
     			
     			// lecture des champs
				$vDeces = NULL;
				$vNoeudDeces = $vNoeudJournee[$vCpt]->deces;
				if (isset($vNoeudDeces)){
					$vDeces = ''.$vNoeudDeces;
				}
				
     			$vDeces75a = NULL;
				$vNoeudDeces75a = $vNoeudJournee[$vCpt]->deces75a;
				if (isset($vNoeudDeces75a)){
					$vDeces75a = ''.$vNoeudDeces75a;
				}
				
     			$vDecesV1 = NULL;
     			$vDeces75aV1 = NULL;
     			
     			if (isset ($vNoeudJournee[$vCpt]->MORTALITE)){
					$vNoeudDecesV1 = $vNoeudJournee[$vCpt]->MORTALITE->deces;
					if (isset($vNoeudDecesV1)){
						$vDecesV1 = ''.$vNoeudDecesV1;
					}
					
	     			
					$vNoeudDeces75aV1 = $vNoeudJournee[$vCpt]->MORTALITE->deces75a;
					if (isset($vNoeudDeces75aV1)){
						$vDeces75aV1 = ''.$vNoeudDeces75aV1;
					}
     			}
				
	     		if ($vDeces != NULL || $vDecesV1 != NULL || $vDeces75a != NULL || $vDeces75aV1 != NULL){
					// aumoins un des champs est saisie
					$vDeces = intval($vDeces);
					$vDecesV1 = intval($vDecesV1);
					$vDeces75a = intval($vDeces75a);
					$vDeces75aV1 = intval($vDeces75aV1);
					
					if ($vDeces > $vDecesV1){
						$vIndicateurJour->setDeces($vDeces);
					}
					else {
						$vIndicateurJour->setDeces($vDecesV1);
					}
					if ($vDeces75a > $vDeces75aV1){
						$vIndicateurJour->setDeces75a($vDeces75a);
					}
					else {
						$vIndicateurJour->setDeces75a($vDeces75aV1);
					}
					
					$_donneesEtablissement->ajouterIndicateurJour($vIndicateurJour);
				}
     		}
     	}
	}
	
	/**
	 * Copie les données de l'établissement de l'arbre XML vers l'objet Etalissement
	 * @param _donneesEtablissement: objet à compléter
	 * @param _documentRoot: arbre XML
	 * @return true si l'établissement est trouvé dans la base de données
	 */
	public static function XmlEtablissementVersObj(&$_donneesEtablissement, &$_documentRoot){
		$vNoeudEtablissement = $_documentRoot->xpath('//DESCSERV');
     	
		$vNoeudFiness = $vNoeudEtablissement[0]->id_etab;
		if (!isset($vNoeudFiness)){
			return false;
		}
		
		$vFiness = ''.$vNoeudFiness[0];

     	if (!isset ($vFiness) || strlen($vFiness) ==  0){
     		return false;
     	}
     	
     	$vEtablissement = Dao_Structure_Etablissement::ChercheParCodeFiness($vFiness);
     	
     	if ($vEtablissement == NULL){
     		return false;
     	}
     	$_donneesEtablissement->setEtablissement($vEtablissement);
     	
     	return true;
	}
	
	/**
	 * Met à jour les données du service
	 * @param _serviceSau (Objet_Structure_Sau_Service): service à mettre à jour
	 */
	private static function MajServiceSau(&$_serviceSau){
	
		$vNbUrgence = 0;
		$vNbUrgMoins1an = 0;
		$vNbUrgPlus75ans = 0;
		$vNbHospitalisation = 0;
		$vNbTransUhcd = 0;
		$vNbTransAutre = 0;
		
		$vListeUf = $_serviceSau->getListeUf();
		if (isset($vListeUf)){
			foreach($vListeUf as $vUf){
				$vNbUrgence += $vUf->getNbUrgence();
				$vNbUrgMoins1an += $vUf->getNbUrgMoins1an();
				$vNbUrgPlus75ans += $vUf->getNbUrgPlus75ans();
				$vNbHospitalisation += $vUf->getNbHospitalisation();
				$vNbTransUhcd += $vUf->getNbTransUhcd();
				$vNbTransAutre += $vUf->getNbTransAutre();
			}
		}
		
		$_serviceSau->setNbUrgence($vNbUrgence);
		$_serviceSau->setNbUrgMoins1an($vNbUrgMoins1an);
		$_serviceSau->setNbUrgPlus75ans($vNbUrgPlus75ans);
		$_serviceSau->setNbHospitalisation($vNbHospitalisation);
		$_serviceSau->setNbTransUhcd($vNbTransUhcd);
		$_serviceSau->setNbTransAutre($vNbTransAutre);
	}
	
	/**
	 * Met à jour les données du service
	 * @param _serviceSau (Objet_Structure_Lit_Service): service à mettre à jour
	 */
	private static function MajServiceLit(&$_serviceLit){
		$vLitsInstalles =0;
		$vlitsOuverts =0;
		$vLitsOccupes =0;
		$vLitsSupplementaires =0;
		$vLitsDisponibles =0;
		$vLitsFermes =0;
		$vPlaces_disponibles =0;
		$vPermissions =0;
		
		$vListeUf = $_serviceLit->getListeUf();
		if ($vListeUf != null){ // on a null si l'uf n'est pas trouvé
		
			foreach($vListeUf as $vUf){
				$vLitsInstalles += $vUf->getLitsInstalles();
				$vlitsOuverts += $vUf->getLitsOuverts();
				$vLitsOccupes += $vUf->getLitsOccupes();
				$vLitsSupplementaires += $vUf->getLitsSupplementaires();
				$vLitsDisponibles += $vUf->getLitsDisponibles();
				$vLitsFermes += $vUf->getLitsFermes();
				$vPlaces_disponibles += $vUf->getPlaces_disponibles();
				$vPermissions += $vUf->getPermissions();
			}
		}
		
		$_serviceLit->setLitsInstalles($vLitsInstalles);
		$_serviceLit->setLitsOuverts($vlitsOuverts);
		$_serviceLit->setLitsOccupes($vLitsOccupes);
		$_serviceLit->setLitsSupplementaires($vLitsSupplementaires);
		$_serviceLit->setLitsDisponibles($vLitsDisponibles);
		$_serviceLit->setLitsFermes($vLitsFermes);
		$_serviceLit->setPlacesDispo($vPlaces_disponibles);
		$_serviceLit->setPermissions($vPermissions);
	}
	
	private static function LireServiceCache (&$_etablissement, $_serviceCode){
		$vFiness = $_etablissement->getFiness();

		if (isset (Metier_Import_TraiteXml::$serviceCache[$vFiness])){
			//lecture de la liste des services
			$vListeServices = &Metier_Import_TraiteXml::$serviceCache[$vFiness];
			
			if (isset($vListeServices[$_serviceCode])){
				return $vListeServices[$_serviceCode];
			}
		}
		return null;
	}
	
	private static function EcrireServiceCache (&$_etablissement, &$_service){
		$vFiness = $_etablissement->getFiness();
		
		$vListeServices = null;
		if (isset (Metier_Import_TraiteXml::$serviceCache[$vFiness])){
			//lecture de la liste des services
			$vListeServices = &Metier_Import_TraiteXml::$serviceCache[$vFiness];
		}
		else {
			$vListeServices = array();
			Metier_Import_TraiteXml::$serviceCache[$vFiness] = &$vListeServices;
		}
		
		$vServiceCode = $_service->getCode();
		if (isset($vListeServices[$vServiceCode])){
			return ;
		}
		else{
			$vListeServices[$vServiceCode] = &$_service;
		}
	}
	
	private static function LireUfCache (&$_etablissement, $_ufCode){
		$vFiness = $_etablissement->getFiness();

		if (isset (Metier_Import_TraiteXml::$ufCache[$vFiness])){
			//lecture de la liste des services
			$vListeUf = &Metier_Import_TraiteXml::$ufCache[$vFiness];
			
			if (isset($vListeUf[$_ufCode])){
				return $vListeUf[$_ufCode];
			}
		}
		return null;
	}
	
	/**
	 * Ecrit les uf dans le cache si cela est necassaire
	 * @param (Objet_Structure_Etablissement): établissement concerné
	 * @param (Objet_Structure_Uf): UF à mettre dans le cache
	 * @return
	 */
	private static function EcrireUfCache (&$_etablissement, &$_uf){
		$vFiness = $_etablissement->getFiness();
		
		$vListeUf = null;
		if (isset (Metier_Import_TraiteXml::$ufCache[$vFiness])){
			//lecture de la liste des services
			$vListeUf = &Metier_Import_TraiteXml::$ufCache[$vFiness];
		}
		else {
			$vListeUf = array();
			Metier_Import_TraiteXml::$ufCache[$vFiness] = &$vListeUf;
		}
		
		$vUfCode = $_uf->getCode();
		if (isset($vListeUf[$vUfCode])){
			return ;
		}
		else{
			$vListeUf[$vUfCode] = &$_uf;
		}
	}
}
?>