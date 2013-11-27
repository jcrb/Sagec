<?php
require_once $BackToRoot."classes/objet/import/rapport/Rapport.class.php";
require_once $BackToRoot."classes/objet/import/rapport/Etablissement.class.php";
require_once $BackToRoot."classes/objet/import/rapport/Jour.class.php";
require_once $BackToRoot."classes/objet/import/rapport/Message.class.php";

require_once $BackToRoot."classes/objet/structure/Etablissement.class.php";

require_once $BackToRoot."classes/metier/util/Date.class.php";

/**
 * Gestion du rapport d'import
 * 
 * @package Metier_Import
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Metier_Import_Rapport {
	private $rapport;
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
    
	private function &getRapport(){
		return $this->rapport;
    }
	private function setRapport(&$_rapport){
		return $this->rapport = $_rapport;
    }
    
    public static function ajouterMessage (&$_etablissement, $_jour, $_niveau, $_message){
    	$vImportRapport = Metier_Import_Rapport::getInstance();
    	
    	$vRapport = $vImportRapport->getRapport();
    	
    	if (!isset($vRapport)){
    		$vRapport = new Objet_Import_Rapport_Rapport;
    		$vImportRapport->setRapport($vRapport);
    	}
    	
    	$vRapport->ajouterMessage($_etablissement, $_jour, $_niveau, $_message);
    }
    
    /**
	 * Retourne le rapport au format HTML
	 */
    public static function construireRapport(){
		$vImportRapport = Metier_Import_Rapport::getInstance();
		
		$vStrRapport = "";
		// construction du rapport
		$vRapport = $vImportRapport->getRapport();
		$vListeEtablissement = $vRapport->getListeEtablissement();
		foreach ($vListeEtablissement as $vEtablissement){
			$vStrRapport .= "<B>".$vEtablissement->getNom()." (".$vEtablissement->getFiness().")</B><BR>";
			
			foreach ($vEtablissement->getListeJours() as $vJour){
				if ($vJour->getJour() > 0){
					$vStrRapport .= "<U>".Metier_Util_Date::TimestampDateVersString($vJour->getJour())."</U><BR>";
				}
			
				foreach ($vJour->getListeMsgAffiche() as $vMsgAffiche){
					$vStrRapport .= $vMsgAffiche->getMessage()."<BR>";
				}
				foreach ($vJour->getListeMsgDebug() as $vMsgDebug){
					$vStrRapport .= "[DEBUG] ".$vMsgDebug->getMessage()."<BR>";
				}
				foreach ($vJour->getListeMsgInfo() as $vMsgInfo){
					$vStrRapport .= "[INFO] ".$vMsgInfo->getMessage()."<BR>";
				}
				foreach ($vJour->getListeMsgWarning() as $vMsgWarning){
					$vStrRapport .= "[WARN] ".$vMsgWarning->getMessage()."<BR>";
				}
				foreach ($vJour->getListeMsgError() as $vMsgError){
					$vStrRapport .= "[ERROR] ".$vMsgError->getMessage()."<BR>";
				}
			}
		}
		
		return $vStrRapport;
    }
}
?>