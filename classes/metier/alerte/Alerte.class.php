<?php
require_once $BackToRoot."classes/dao/structure/administratif/Departement.class.php";
require_once $BackToRoot."classes/dao/structure/administratif/Region.class.php";
require_once $BackToRoot."classes/dao/structure/Etablissement.class.php";
require_once $BackToRoot."classes/dao/structure/Service.class.php";
require_once $BackToRoot."classes/dao/structure/Uf.class.php";

require_once $BackToRoot."classes/dao/personne/Personne.class.php";

require_once $BackToRoot."classes/metier/util/Date.class.php";
/**
 * Traitement de l'alerte
 * 
 * @package Metier_Alerte
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Metier_Alerte_Alerte{
	private $etablissementDao = null; // (Dao_Structure_Etablissement)
	private $serviceDao = null; // (Dao_Structure_Service)
	private $ufDao = null; // (Dao_Structure_Uf)
	
	/**
	 * Retourne la liste des régions
	 * @return Dao_Structure_Administratif_Region[]
	 */
	public static function ListeRegion(){
		return Dao_Structure_Administratif_Region::ListeRegion();
	}
	
	/**
	 * Retourne la liste des départements. Si une region est données, retourne uniquement les départements 
	 *  de la région
	 * @param $_region (Object_Sturcture_Administratif_Region): restriction sur cette région
	 * @return Object_Sturcture_Administratif_Departement[]
	 */
	public static function ListeDepartement(&$_region=null){
		return Dao_Structure_Administratif_Departement::ListeDepartement($_region);
	}
	
	/**
	 * Retourne la liste des établissements surveillés
	 * @return Objet_Sturcture_Alerte_Etablissement[]
	 */
	public static function ListeEtablissementsSurveilles(){
		$vAlert = new Metier_Alerte_Alerte;
		$vEtablissementDao = $vAlert->getEtablissementDao();
		return $vEtablissementDao->ChercheEtablissmentSurveille();
	}
	
	/**
	 * Retourne la liste des utilisateurs en copie du mail d'alerte
	 * @return Object_Personne_PersonneCpAlerte[]
	 */
	public static function ListeUtilisateurCpAlerte(){
		return Dao_Personne_Personne::CherchePersonneCpAlerte();
	}
	
	/**
	 * Retourne la liste des hopitaux correspondant aux critères ci dessous
	 * @param $_region (Objet_Sturcture_Administratif_Region): restriction par région
	 * @param $_departement (Objet_Sturcture_Administratif_Departement): restriction par département
	 * @return Objet_Structure_Etablissement[]
	 */
	public static function ListeHopitaux(&$_region, &$_departement){
		return Dao_Structure_Etablissement::ChercheEtablissementParStrucAdministrative($_region, $_departement);
	}
	
	/**
	 * Ajoute une adresse email à la liste des personnes à prevenir en cas d'alerte
	 * @param $_mail (string): adresse email à ajouter
	 * @return
	 */
	public static function AjouterMailCopieAlerte($_mail){
		Dao_Personne_Personne::MajCpAlertMail($_mail);
	}
	
	/**
	 * Supprime une adresse email de la liste des personnes à prévenir en cas d'alerte
	 * @param $_id
	 * @return unknown_type
	 */
	public static function SupprimerMailCopieAlerte ($_id){
		Dao_Personne_Personne::SupprCpAlertMail($_id);
	}
	
	/**
	 * Ajoute un établissement à la liste des établissements à surveiller
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement surveillé
	 * @param $_mail (string): adresse email pour prévenir en cas de problèmes
	 * @return
	 */
	public static function AjouterSurveillanceEtablissement(&$_etablissement, $_mail){
		Dao_Structure_Etablissement::MajEtablissementSurveille($_etablissement, $_mail);
	}
	
	/**
	 * Supprime un établissement de la liste des établissement surveillés
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement surveillé
	 * @return
	 */
	public static function SupprimerSurveillanceEtablissement(&$_etablissement){
		Dao_Structure_Etablissement::SupprEtablissementSurveille($_etablissement);
	}
	
	/**
	 * Activer la surveillance de l'établissement 
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement surveillé
	 * @return
	 */
	public static function ActiverSurveillanceEtablissement(&$_etablissement){
		Dao_Structure_Etablissement::ActiverEtablissementSurveille($_etablissement);
	}
	
	/**
	 * Desactiver la surveillance de l'établissement
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement surveillé
	 * @return
	 */
	public static function DesactiverSurveillanceEtablissement(&$_etablissement){
		Dao_Structure_Etablissement::DesactiverEtablissementSurveille($_etablissement);
	}
	
	/**
	 * Création et envoie des alertes par mail au format HTML
	 * @return (string[][])
	 */
	public function CreationHtmlAlerte(){
		// determiner la limite de retard
		$vLimiteRetard = Metier_Util_Date::DebutJour(time());
		$vLimiteRetard -= 2; // <= pour les mise à jour de minuit
		
		$vListeMailMessage = array(); // tableau des messages à envoyer par utilisateur
		
		// lecture de la liste des établissement surveillés
		$vListeEtablissementSurveille = $this->ListeEtablissementsSurveilles();
		foreach ($vListeEtablissementSurveille as $vEtablissement){
			// services en retard
			$vListeServiceRetard = $this->getServiceDao()->ListeRetardService($vEtablissement, $vLimiteRetard);
			
			// uf en retard
			$vListeUfRetard = $this->getUfDao()->ListeRetardUf($vEtablissement, $vLimiteRetard);
			
			$vMessage = "";
			$vEmail = $vEtablissement->getMail();
			
			if (count($vListeServiceRetard) > 0 || count($vListeUfRetard) >0 ){
				// ajouter les informations de l'établissement au message
				
				if (isset($vListeMailMessage[$vEmail]))
					$vMessage = $vListeMailMessage[$vEmail];
			
				$vMessage .= "<u>".$vEtablissement->getNom()."</u><br>";
			}
			
			if (count($vListeServiceRetard) > 0){
				// ajouter les informations du service
				$vMessage .= "Liste des services:<ul>";
				foreach($vListeServiceRetard as $vService){
					$vMessage .= "<li>";
					if (strlen(trim($vService->getCode())) > 0){
						$vMessage .= "[".$vService->getCode()."] ";
					}
					$vMessage .= $vService->getNom();
					$vMessage .= " - Mise à jour le ".Metier_Util_Date::TimestampDateVersString($vService->getDateMaj());
					$vMessage .= "</li>";
				}
				$vMessage .= "</ul>";
			}
			
			if (count($vListeUfRetard) >0){
				//ajouter les information des UF
				$vMessage .= "Liste des Ufs:<ul>";
				foreach($vListeUfRetard as $vUf){
					$vMessage .= "<li>";
					if (strlen(trim($vUf->getCode())) > 0)
						$vMessage .= "[".$vUf->getCode()."] ";
					$vMessage .= $vUf->getNom();
					$vMessage .= " - Mise à jour le ".Metier_Util_Date::TimestampDateVersString($vUf->getDateMaj());
					$vMessage .= "</li>";
				}
				$vMessage .= "</ul>";
			}
			
			if (count($vListeServiceRetard) > 0 || count($vListeUfRetard) >0 ){
				// enregistrer le message dans le tableau
				$vListeMailMessage[$vEmail] = $vMessage;
			} 
		}
		
		return $vListeMailMessage;
	}
	
	
	private function getEtablissementDao(){
		if ($this->etablissementDao == null){
			$this->etablissementDao = Dao_Structure_Etablissement::getInstance();
		}
		return $this->etablissementDao;
	}
	public function setEtablissementDao(&$_etablissementDao){
		$this->etablissementDao = $_etablissementDao;
	}
	
	private function getServiceDao(){
		if($this->serviceDao == null){
			$this->serviceDao = Dao_Structure_Service::getInstance();
		}
		return $this->serviceDao;
	}
	public function setServiceDao(&$_serviceDao){
		$this->serviceDao = $_serviceDao;
	}

	private function getUfDao(){
		if ($this->ufDao == null){
			$this->ufDao = Dao_Structure_Uf::getInstance();
		}
		return $this->ufDao;
	}
	public function setUfDao(&$_ufDao){
		$this->ufDao = $_ufDao;
	}
}
?>