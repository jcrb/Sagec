<?php
require_once $BackToRoot."classes/objet/import/rapport/Etablissement.class.php";

/**
 * Represente le rapport de l'import
 * 
 * @package Objet_Import_Rapport
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */

class Objet_Import_Rapport_Rapport {
	/**
	 * Liste des établissements du rapport
	 * @var Objet_Import_Rapport_Etablissement[]
	 */
	private $listeEtablissement = array();
	
	
	public function &getListeEtablissement(){
		return $this->listeEtablissement;
	}
	
	/**
	 *	Ajouter un message aux log de la journée
	 *  @param _etablissement (Objet_Import_Rapport_Etablissement): etablissement de log
	 * 	@param _jour (int, timestamp): jour de logs
	 *  @param _niveau (int): niveau du message)
	 *  @param _message (string): message à ajouter
	 */
	public function ajouterMessage (&$_etablissement, $_jour, $_niveau, &$_message){
		$vFiness = $_etablissement->getFiness();
		$vEtablissement = &$this->listeEtablissement[$vFiness];
		if (isset($vEtablissement)){
			// ajout du message à l'établissement
//			$vEtablissement =& $this->listeEtablissement[$_etablissement->getFiness()];
			$vEtablissement->ajouterMessage($_jour, $_niveau, $_message);
		}
		else {
			// création d'un nouvel établissement
			$vEtablissement = new Objet_Import_Rapport_Etablissement;
			$vEtablissement->setEtablissement($_etablissement);
			$vEtablissement->ajouterMessage($_jour, $_niveau, $_message);
			$this->listeEtablissement[$_etablissement->getFiness()] =& $vEtablissement;
		}
	}
}
?>