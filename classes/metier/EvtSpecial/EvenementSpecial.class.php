<?php
require_once $BackToRoot."classes/dao/veille/EvenementSpecial.class.php";
require_once $BackToRoot."classes/dao/structure/administratif/Region.class.php";
require_once $BackToRoot."classes/dao/structure/Etablissement.class.php";
require_once $BackToRoot."classes/objet/veille/EvtSpeData.class.php";
require_once $BackToRoot."classes/objet/structure/Etablissement.class.php";

/**
 * Gestion de la saisie d'un évènement spécial
 * 
 * @package Metier_EvtSpecial
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Metier_EvtSpecial_EvenementSpecial{
	/**
	 * Retourne la liste des évènements spéciaux pour un établissement
	 * @param $_etablissement: Objet_Structure_Etablissement
	 * @return Objet_Veille_EvtSpe[]
	 */
	public function ChercheListeEvtParEtablissement(&$_etablissement){
		return Dao_Veille_EvenementSpecial::ChercheEvtSpParEtablissement($_etablissement);
	}
	
	/**
	 * Lit la valeur d'un champs pour un hôpital et un jour donné
	 * @param  $_data: Objet_Veille_EvtSpeData
	 * @return Objet_Veille_EvtSpeData
	 */
	public function ChercheValeurPourJour(&$_data){
		return Dao_Veille_EvenementSpecial::ChercheValeurPourJour($_data);
	}
	
	/**
	 * Met à jour (création où mise à jour de la valeur du champs)
	 * @param $_data: Objet_Veille_EvtSpeData
	 */
	public function MajEvtSpChamp(&$_data){
		$vData = Dao_Veille_EvenementSpecial::ChercheValeurPourJour($_data);
		if (is_null($vData)){
			// c'est une nouvelle entrée
			Dao_Veille_EvenementSpecial::MajEvtSpChamp($_data);
		}
		else {
			// l'entrée existe déjà
			$vData->setValeur($_data->getValeur());
			Dao_Veille_EvenementSpecial::MajEvtSpChamp($vData);
		}
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
	public function ChercheDonneesPourEvenement(&$_evenement){
		return Dao_Veille_EvenementSpecial::ChercheDonneesPourEvenement($_evenement);
	}
	
	/**
	 * Cherche la liste des évènements spéciaux
	 * @return Objet_Veille_EvtSpe[]
	 */
	public function ListeEvenement (){
		return Dao_Veille_EvenementSpecial::ListeEvenement();
	}
	
	/**
	 * Cherche la liste des hôpitaux liés à cet évènement
	 * @param $_evenement: Objet_Veille_EvtSpe
	 * @return Objet_Structure_Etablissement[]
	 */
	public function ChercheEtablissementsPourEvenement(&$_evenement){
		return Dao_Veille_EvenementSpecial::ChercheEtablissementsPourEvenement($_evenement);
	}
	
	/**
	 * Créer ou met à jour un évènement
	 * @param Objet_Veille_EvtSpe
	 */
	public function MajEvenement (&$_evenement){
		return Dao_Veille_EvenementSpecial::MajEvenement($_evenement);
	}
	
	/**
	 * Compléte l'object évènement passé en paramètre
	 * @param $_evenement: Objet_Veille_EvtSpe
	 */
	public function ChercheEvenementParID (&$_evenement){
		Dao_Veille_EvenementSpecial::ChercheEvenementParID($_evenement);
		$_evenement->setListeChamps(Dao_Veille_EvenementSpecial::ChercheChampsParEvenement($_evenement));
	}
	
	/**
	 * Créer ou met à jour un champ
	 * @param Objet_Veille_EvtSpe: évenement
	 * @param Objet_Veille_EvtSpe: champ à ajouter
	 */
	public function MajChamp (&$_evenement, &$_champ){
		Dao_Veille_EvenementSpecial::MajChamp($_evenement, $_champ);
	}
	
	/**
	 * Cherche tous les établissements de la région
	 * @return Objet_Structure_Etablissement[]
	 */
	public function ListeEtablissementRegion(){		
		$vRegionObj = Dao_Structure_Administratif_Region::getInstance();
		$vRegion =$vRegionObj->ChercheRegionParCode(42);
		
		return Dao_Structure_Etablissement::ChercheEtablissementParStrucAdministrative($vRegion);
	}
	
	/**
	 * créer ou supprime l'association de l'établissement à un évènement
	 */
	public function MajEvtSpEtablissement(&$_etablissement, &$_evenement){		
		if (Dao_Veille_EvenementSpecial::VerifieEvtSp($_etablissement, $_evenement)){
			Dao_Veille_EvenementSpecial::SupprEvtSpEtablissement($_etablissement, $_evenement);
		}
		else {
			Dao_Veille_EvenementSpecial::AjoutEvtSpEtablissement($_etablissement, $_evenement);
		}
	}
	
	/**
	 * Verifie si l'établissement est dans la liste des établissement
	 * @param $_listeEtablissement: Objet_Structure_Etablissement[]
	 * @param $_etablissement: Objet_Structure_Etablissement
	 * @return true s'il est dans la liste
	 */
	public function estDansListeEtablissement(&$_listeEtablissement, &$_etablissement){
		$vTrouve = false;
		if (isset($_listeEtablissement)){
			foreach ($_listeEtablissement as $vEtablissement){
				$vTrouve |= ($vEtablissement->getId() == $_etablissement->getId());
			}
		}
		return $vTrouve;
	}
	
	/**
	 * Cherche la liste des champs pour cet évènement
	 * @param Objet_Veille_EvtSpe
	 * @return Objet_Veille_EvtSpeChamp[]
	 */
	public function ChercheChampsParEvenement(&$_evenement){
		return Dao_Veille_EvenementSpecial::ChercheChampsParEvenement($_evenement);
	}
	
	/**
	 * Cherche toute les valeurs pour un jour et un évènement donnée
	 * @param $_jour: Date (timestamp)
	 * @param $_evenement: Objet_Veille_EvtSpe
	 * @param $_etablissement: Objet_Structure_Etablissement
	 * @return int[] (les indices des tableaux sont les ID des champs)
	 */
	public function ChercheValeursPourJourEvenement(&$_jour, &$_evenement, &$_etablissement){
		return Dao_Veille_EvenementSpecial::ChercheValeursPourJourEvenement($_jour, $_evenement, $_etablissement);
	}
	
	/**
	 * Cherche les établissements correspondant à la liste d'ID 
	 * @param unknown_type $_listeId: int[] liste d'ID
	 * @return Objet_Structure_Etablissement[] (utilisation de l'Id comme indexe)
	 */
	public function ChercheEtablissementsParIds(&$_listeId){
		return Dao_Structure_Etablissement::ChercheEtablissementsParIds($_listeId);
	}
}
?>