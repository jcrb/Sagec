<?php
require_once $BackToRoot."classes/objet/import/rapport/Message.class.php";

/**
 * Represente les messages pour le jour de l'import
 * 
 * @package Objet_Import_Rapport
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Import_Rapport_Jour{
	/**
     * Jour les message
     * @var int, timestamp
     */
	private $jour;
	/**
     * Liste des messages à afficher
     * @var string[]
     */
	private $listeMsgAffiche = array();
	/**
     * Liste des messages de debug
     * @var string[]
     */
	private $listeMsgDebug = array();
	/**
     * Liste des messages d'information
     * @var string[]
     */
	private $listeMsgInfo = array ();
	/**
     * Liste des messages de warning
     * @var string[]
     */
	private $listeMsgWarning = array ();
	/**
     * Liste des messages d'erreur
     * @var string[]
     */
	private $listeMsgError = array ();
	
	public function getJour(){
		return $this->jour;
	}
	public function setJour($_jour){
		$this->jour = $_jour;
	}
	
	public function &getListeMsgAffiche(){
		return $this->listeMsgAffiche;
	}
	
	public function &getListeMsgDebug(){
		return $this->listeMsgDebug;
	}
	
	public function &getListeMsgInfo (){
		return $this->listeMsgInfo;
	}
	
	public function &getListeMsgWarning (){
		return $this->listeMsgWarning;
	}
	
	public function &getListeMsgError (){
		return $this->listeMsgError;
	}
	
	/**
	 *	Ajouter un message aux log de la journée
	 *  @param _niveau (int): niveau du message)
	 *  @param _message (string): message à ajouter
	 */
	public function ajouterMessage($_niveau, &$_message){
	
		$vMessage = new Objet_Import_Rapport_Message;
		$vMessage->setNiveau($_niveau);
		$vMessage->setMessage($_message);
		
		switch($_niveau){
	  		case 0:
	  			$this->listeMsgAffiche[] = $vMessage;
	    		break;
	  		case 1:
	    		$this->listeMsgDebug[] = $vMessage;
	    		break;
	  		case 2:
	    		$this->listeMsgInfo[] = $vMessage;
	    		break;
	    	case 3:
	    		$this->listeMsgWarning[] = $vMessage;
	    		break;
	  		case 4:
	    		$this->listeMsgError[] = $vMessage;
	    		break;
	  	}
	}
}
?>