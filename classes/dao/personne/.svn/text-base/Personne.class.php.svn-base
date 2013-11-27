<?php
require_once $BackToRoot."classes/objet/personne/PersonneCpAlerte.class.php";

require_once $BackToRoot."classes/dao/pool.class.php";

/**
 * Accès aux données pour une personne
 * 
 * @package Dao_Personne
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */

class Dao_Personne_Personne{
	/**
	 * Retourne la liste des personnes en copie du message d'alerte
	 * @return Object_Personne_PersonneCpAlerte
	 */
	public static function CherchePersonneCpAlerte(){
		$vConnexion = Dao_Pool::getConnexionPdo(); // lève un PDOException s'il y a un problème à la connexion
		
		$vPreparedStatment = $vConnexion->prepare("SELECT id, email FROM hopital_copie_alerte");
		$vPreparedStatment->execute();
		
		$vListeUtilisateur = array();
		while ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
				$vUtilisateur = new Object_Personne_PersonneCpAlerte;
				$vUtilisateur->setId($vLigneObj->id);
				$vUtilisateur->setMail($vLigneObj->email);
		
				$vListeUtilisateur[] = $vUtilisateur;
		}
		
		return $vListeUtilisateur;
	}
	
	/**
	 * Retourne "true" si la personne existe déjà
	 * @param $_mail (string): adrese mail à vérifier
	 * @return bool
	 */
	public static function PersonneCpAlerteParMailExiste($_mail){
		$vConnexion = Dao_Pool::getConnexionPdo(); // lève un PDOException s'il y a un problème à la connexion
		
		$vPreparedStatment = $vConnexion->prepare("SELECT id FROM hopital_copie_alerte WHERE email=?");
		$vPreparedStatment->execute(array($_mail));
		
		if ($vLigneObj = $vPreparedStatment->fetch(PDO::FETCH_OBJ)){
			return true;
		}
		return false;
	}
	
	/**
	 * Ajoute à la liste des adresses mails en copie des alertes
	 * @param $_mail (string): adresse mail à ajouter
	 * @return
	 */
	public static function MajCpAlertMail($_mail){
		$vConnexion = Dao_Pool::getConnexionPdo(); // lève un PDOException s'il y a un problème à la connexion
		
		if (!Dao_Personne_Personne::PersonneCpAlerteParMailExiste($_mail)){
			$vPreparedStatment = $vConnexion->prepare("INSERT INTO hopital_copie_alerte (email) VALUES (?)");
			$vPreparedStatment->execute(array($_mail));
		}
	}

	/**
	 * Supprime de la liste des adresses mails en copie des alertes
	 * @param $_id (int): id de la personne en copie
	 * @param $_mail (string): adresse mail à supprimer
	 * @return
	 */
	public static function SupprCpAlertMail($_id, $_mail=null){
		$vConnexion = Dao_Pool::getConnexionPdo(); // lève un PDOException s'il y a un problème à la connexion
		
		if (isset($_id)){
			$vPreparedStatment = $vConnexion->prepare("DELETE FROM hopital_copie_alerte WHERE id=?");
			$vPreparedStatment->execute(array($_id));
		}
		else {
			if (isset($_mail)){
				$vPreparedStatment = $vConnexion->prepare("DELETE FROM hopital_copie_alerte WHERE email=?");
				$vPreparedStatment->execute(array($_mail));
			}
		}
	}
}
?>