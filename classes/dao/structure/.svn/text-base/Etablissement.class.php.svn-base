<?php
require_once $BackToRoot."classes/objet/structure/Etablissement.class.php";
require_once $BackToRoot."classes/objet/structure/Organisme.class.php";
require_once $BackToRoot."classes/objet/structure/alerte/Etablissement.class.php";

require_once $BackToRoot."classes/objet/exception/SqlException.class.php";
require_once $BackToRoot."classes/objet/exception/StructureNotFoundException.class.php";

require_once $BackToRoot."classes/metier/util/Liste.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";

/**
 * Accès aux données pour une structure de type établissement
 * 
 * @package Dao_Structure
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
Class Dao_Structure_Etablissement{
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
	 * Cherche un établissement à l'aide de son code FINESS
	 * @param _finess: code FINESS
	 * @return Objet_Structure_Etablissement
	 * /!\ PDOException
	 */
	public static function ChercheParCodeFiness ($_finess){
		$vConnexion = Dao_Pool::getConnexionPdo(); // lève un PDOException s'il y a un problème à la connexion
		
		$vPreparedStatment = $vConnexion->prepare("SELECT H.Hop_ID, H.Hop_nom, H.Hop_finess, O.Org_ID, O.Org_nom FROM hopital H LEFT JOIN organisme O ON H.Org_ID=O.Org_ID WHERE Hop_finess=?");
		$vPreparedStatment->execute(array($_finess));
		
		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vEtablissement = new Objet_Structure_Etablissement;
		 	$vEtablissement->setId($vLigneObj->Hop_ID);
		 	$vEtablissement->setNom($vLigneObj->Hop_nom);
		 	$vEtablissement->setFiness($vLigneObj->Hop_finess);
		 	
		 	$vOrganismeID = $vLigneObj->Org_ID;
		 	$vOrganismeNom = $vLigneObj->Org_nom;
		 	if (isset($vOrganismeID) && isset($vOrganismeNom)){
		 		$vOrganisme = new Objet_Structure_Organisme;
		 		$vOrganisme->setId($vOrganismeID);
		 		$vOrganisme->setNom($vOrganismeNom);
		 		$vEtablissement->setOrganisme($vOrganisme);
		 	}
		 	return $vEtablissement;		 	
		}
		
		throw new Objet_Exception_StructureNotFoundException ("Etablissement non trouv&eacute; pour le code FINESS ".$_finess);
	}
	
	/**
	 * Cherche les établissements correspondant à la liste d'ID 
	 * @param unknown_type $_listeId: int[] liste d'ID
	 * @return Objet_Structure_Etablissement[] (utilisation de l'Id comme indexe)
	 */
	public static function ChercheEtablissementsParIds(&$_listeId){
		$vConnexion = Dao_Pool::getConnexionPdo(); // lève un PDOException s'il y a un problème à la connexion
		
		$vInListe = Metier_Util_Liste::SqlInListe($_listeId);
		
		$vPreparedStatment = $vConnexion->prepare("SELECT H.Hop_ID, H.Hop_nom, H.Hop_finess, O.Org_ID, O.Org_nom FROM hopital H LEFT JOIN organisme O ON H.Org_ID=O.Org_ID WHERE Hop_ID IN (".$vInListe.")");
		$vPreparedStatment->execute();
		
		$vListeEtablissement = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vEtablissement = new Objet_Structure_Etablissement;
		 	$vEtablissement->setId($vLigneObj->Hop_ID);
		 	$vEtablissement->setNom($vLigneObj->Hop_nom);
		 	$vEtablissement->setFiness($vLigneObj->Hop_finess);
		 	
		 	$vOrganismeID = $vLigneObj->Org_ID;
		 	$vOrganismeNom = $vLigneObj->Org_nom;
		 	if (isset($vOrganismeID) && isset($vOrganismeNom)){
		 		$vOrganisme = new Objet_Structure_Organisme;
		 		$vOrganisme->setId($vOrganismeID);
		 		$vOrganisme->setNom($vOrganismeNom);
		 		$vEtablissement->setOrganisme($vOrganisme);
		 	}
		 	
		 	$vListeEtablissement[$vLigneObj->Hop_ID] = $vEtablissement;
		}
		
		return $vListeEtablissement;
	}
	
	/**
	 * Cherche les établissements d'une même organisation
	 * @param _finess (string): code finess de l'établissement
	 * @return Objet_Structure_Etablissement[]
	 */
	public static function chercheAutreEtablissementParFiness($_finess){
		$vConnexion = Dao_Pool::getConnexionPdo();  // lève un PDOException s'il y a un problème à la connexion
    		
    	$vPreparedStatment = $vConnexion->prepare("SELECT H1.Hop_ID, H1.Hop_nom, H1.Hop_finess, O1.Org_ID, O1.Org_nom FROM hopital H1, organisme O1 WHERE H1.Org_ID = O1.Org_ID AND O1.Org_ID IN (SELECT Org_ID FROM hopital WHERE Hop_finess=?)");
    	$vPreparedStatment->execute(array($_finess));

    	$vListeEtablissement = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
		 	$vEtablissement = new Objet_Structure_Etablissement;
		 	$vEtablissement->setId($vLigneObj->Hop_ID);
		 	$vEtablissement->setNom($vLigneObj->Hop_nom);
		 	$vEtablissement->setFiness($vLigneObj->Hop_finess);
		 	
	 		$vOrganisme = new Objet_Structure_Organisme;
	 		$vOrganisme->setId($vLigneObj->Org_ID);
	 		$vOrganisme->setNom($vLigneObj->Org_nom);
	 		$vEtablissement->setOrganisme($vOrganisme);
		 	
		 	$vListeEtablissement[] = $vEtablissement; 	
		}
		return $vListeEtablissement;
	}
	
	/**
	 * Retourne une liste des établissements correspondant aux critères ci dessous
	 * @param $_region (Object_Sturcture_Administratif_Region): tous les hopitaux de la région
	 * @param $_departement (Object_Sturcture_Administratif_Departement): tous les hopitaux du département
	 * @return Objet_Structure_Etablissement[]
	 */
	public static function ChercheEtablissementParStrucAdministrative(&$_region = null, &$_departement = null){
		$vConnexion = Dao_Pool::getConnexionPdo();  // lève un PDOException s'il y a un problème à la connexion
		
		$vSql = "SELECT H.Hop_ID, H.Hop_nom, H.Hop_finess FROM hopital H, adresse A, ville V, departement D, region R WHERE H.adresse_ID=A.ad_ID AND A.ville_ID=V.ville_ID AND V.departement_ID=D.departement_ID AND D.region_ID=R.region_ID";
		$vListeParam = array();
		if ($_region != null && $_departement == null && $_region->getId()){
			$vSql .= " AND R.region_ID=?";
			$vListeParam = array($_region->getId());
		}
		if ($_departement != null && $_departement->getId()){
			$vSql .= " AND D.departement_ID=?";
			$vListeParam = array($_departement->getId());
		}
		
		$vPreparedStatment = $vConnexion->prepare($vSql);
		$vPreparedStatment->execute($vListeParam);
		
		$vListeEtablissement = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
		 	$vEtablissement = new Objet_Structure_Etablissement;
		 	$vEtablissement->setId($vLigneObj->Hop_ID);
		 	$vEtablissement->setNom($vLigneObj->Hop_nom);
		 	$vEtablissement->setFiness($vLigneObj->Hop_finess);
		 	
		 	$vListeEtablissement[] = $vEtablissement;
		}
		
		return $vListeEtablissement;
	}
	
	/**
	 * Retourne la liste des établissements surveillés pour la mise à jour de SAGEC
	 * @return Object_Sturcture_Alerte_Etablissement[]
	 */
	public function ChercheEtablissmentSurveille(){
		$vConnexion = Dao_Pool::getConnexionPdo();  // lève un PDOException s'il y a un problème à la connexion
		
		$vPreparedStatment = $vConnexion->prepare("SELECT H.Hop_ID, H.Hop_nom, M.mail, 'date', A.est_actif  FROM hopital H, hopital_alert A, mail_hopital_alert M where A.hopital_ID=H.Hop_ID AND A.hopital_alert_id=M.hopital_alert_id ORDER BY H.Hop_nom");
		$vPreparedStatment->execute();
		
		$vListeEtablissement = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			$vEtablissement = new Objet_Sturcture_Alerte_Etablissement;
			$vEtablissement->setId($vLigneObj->Hop_ID);
		 	$vEtablissement->setNom($vLigneObj->Hop_nom);
		 	
		 	$vEtablissement->setMail($vLigneObj->mail);
		 	$vEtablissement->setDate(0); // à mettre à jour lorsque la requête aura évolué
		 	$vEtablissement->setActif($vLigneObj->est_actif == 'o');
		 	
		 	$vListeEtablissement[] = $vEtablissement;
		}
		return $vListeEtablissement;
	}
	
	/**
	 * Vérifie si l'établissement est surveillé  
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement surveillé
	 * @param $_mail (string): adresse mail pour l'envoie de l'alerte
	 * @return bool
	 */
	public static function EtablissementEstSurveille(&$_etablissement, $_mail){
		$vConnexion = Dao_Pool::getConnexionPdo();  // lève un PDOException s'il y a un problème à la connexion
		
		$vPreparedStatment = $vConnexion->prepare("SELECT A.hopital_alert_id FROM hopital_alert A, mail_hopital_alert M WHERE M.hopital_alert_id = A.hopital_alert_id AND A.hopital_alert_id=? AND M.mail=?");
		$vPreparedStatment->execute(array($_etablissement->getId(), $_mail));

		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * Ajoute l'établissement aux établissements surveillés
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement surveillé
	 * @param $_mail (string): adresse mail pour d'envoie de l'alerte
	 * @return
	 */
	public static function MajEtablissementSurveille(&$_etablissement, $_mail){
		$vConnexion = Dao_Pool::getConnexionPdo();  // lève un PDOException s'il y a un problème à la connexion
		
		if (! Dao_Structure_Etablissement::EtablissementEstSurveille($_etablissement, $_mail)){
			// cherche l'établissement
			$vPreparedStatment = $vConnexion->prepare("SELECT hopital_alert_id FROM hopital_alert WHERE hopital_id = ?");
			$vPreparedStatment->execute(array($_etablissement->getId()));
			
			$vHopitalAlertId = 0; // cette valeur sera ecrasé
			if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
				$vHopitalAlertId = $vLigneObj->hopital_alert_id;
			}
			else {
				// ajout de l'établissement
				$vPreparedStatment = $vConnexion->prepare("INSERT INTO hopital_alert (hopital_id, est_actif) VALUES (?, 'o')");
				$vPreparedStatment->execute(array($_etablissement->getId()));
				$vHopitalAlertId = $vConnexion->lastInsertId();
			}
			
			// ajout de l'adresse email
			$vPreparedStatment = $vConnexion->prepare("INSERT INTO mail_hopital_alert (hopital_alert_id, mail) VALUES (?, ?)");
			$vPreparedStatment->execute(array($vHopitalAlertId, $_mail));
			
		}
	}
	
	/**
	 * Supprime l'établissement de la liste des établissements surveillés
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement surveillé
	 * @return
	 */
	public static function SupprEtablissementSurveille(&$_etablissement){
		$vConnexion = Dao_Pool::getConnexionPdo();  // lève un PDOException s'il y a un problème à la connexion
		
		// suppresion de la (ou des) adresse mail
		$vPreparedStatment = $vConnexion->prepare("DELETE FROM mail_hopital_alert USING hopital_alert INNER JOIN mail_hopital_alert WHERE hopital_alert.hopital_alert_id=mail_hopital_alert.hopital_alert_id AND hopital_alert.hopital_id=?");
		$vPreparedStatment->execute(array($_etablissement->getId()));
		
		// suppresion de l'établissement
		$vPreparedStatment = $vConnexion->prepare("DELETE FROM hopital_alert WHERE hopital_id = ?");
		$vPreparedStatment->execute(array($_etablissement->getId()));
	}
	
	/**
	 * Active ou desactive la surveillace de l'établissement
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement surveillé
	 * @param $_estActif (bool): true s'il faut rendre la surveillance active
	 * @return
	 */
	private static function ActifEtablissementSurveille(&$_etablissement, $_estActif){
		$vConnexion = Dao_Pool::getConnexionPdo();  // lève un PDOException s'il y a un problème à la connexion
		
		$vPreparedStatment = $vConnexion->prepare("UPDATE hopital_alert SET est_actif=? WHERE hopital_id=?");
		
		if($_estActif){
			$vPreparedStatment->execute(array("o", $_etablissement->getId()));
		} 
		else {
			$vPreparedStatment->execute(array("n", $_etablissement->getId()));
		}
	}
	
	/**
	 * Active la surveillance de l'établissement
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement surveillé
	 * @return
	 */
	public static function ActiverEtablissementSurveille(&$_etablissement){
		Dao_Structure_Etablissement::ActifEtablissementSurveille($_etablissement, true);
	}
	
	/**
	 * Desactive la surveillance de l'établissement
	 * @param $_etablissement (Objet_Structure_Etablissement): établissement à surveiller
	 * @return
	 */
	public static function DesactiverEtablissementSurveille(&$_etablissement){
		Dao_Structure_Etablissement::ActifEtablissementSurveille($_etablissement, false);
	}
}
?>