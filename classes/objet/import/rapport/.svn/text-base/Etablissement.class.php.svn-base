<?php
require_once $BackToRoot."classes/objet/import/rapport/Jour.class.php";
require_once $BackToRoot."classes/objet/structure/Etablissement.class.php";

/**
 * Represente les messages pour un établissement de l'import
 * 
 * @package Objet_Import_Rapport
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Import_Rapport_Etablissement  extends Objet_Structure_Etablissement{
	/**
     * Jour les message
     * @var int, timestamp
     */
	private $listeJours = array ();
	
	public function &getListeJours(){
		return $this->listeJours;
	}
	
	/**
	 *	Ajouter un message aux log de la journée
	 * 	@param _jour (int, timestamp): jour de logs
	 *  @param _niveau (int): niveau du message)
	 *  @param _message (string): message à ajouter
	 */
	public function ajouterMessage($_jour, $_niveau, &$_message){
		
		if (isset($this->listeJours[$_jour])){
			// on complete le jour existant
			$vJour =& $this->listeJours[$_jour];
			$vJour->ajouterMessage($_niveau, $_message);
		}
		else {
			// on crée un nouveau jour
			$vJour = new Objet_Import_Rapport_Jour;
			$vJour->setJour($_jour);
			$vJour->ajouterMessage($_niveau, $_message);
			$this->listeJours[$_jour] =& $vJour;
		}	
	}
	
	/**
	 * Enregistre les données de l'établissement dans la structure
	 * @param _etablissement (Objet_Structure_Etablissement): : établissement à ajouter
	 */
	public function setEtablissement (&$_etablissement){
		$this->setNom($_etablissement->getNom());
		$this->setFiness($_etablissement->getFiness());
	}
}
?>