<?php
if (!isset($BackToRoot))
	$BackToRoot = '../../../';

require_once $BackToRoot."classes/objet/import/Rpu.class.php";
require_once $BackToRoot."classes/objet/import/RpuActe.class.php";
require_once $BackToRoot."classes/objet/import/RpuDiagnostique.class.php";
require_once $BackToRoot."classes/objet/exception/WrongDataException.class.php";

require_once $BackToRoot."classes/metier/util/Date.class.php";

require_once $BackToRoot."classes/dao/util/Constantes.class.php";
require_once $BackToRoot."classes/dao/structure/Etablissement.class.php";
require_once $BackToRoot."classes/dao/veille/Acte.class.php";
require_once $BackToRoot."classes/dao/veille/Diagnostique.class.php";
require_once $BackToRoot."classes/dao/veille/Rpu.class.php";

/**
 * Intégration des RPU (rapport de passages aux urgences) dans SAGEC
 * 
 * @package Metier_Import
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */

class Metier_Import_Rpu{
	/**
	 * chemin du répertoire d'échange
	 * @var string
	 */
	private static $repertoire = "/sagec_echange/statistiques/";
	
	public static function setRepertoire ($_repertoire){
		Metier_Import_Rpu::$repertoire = $_repertoire;
	}
	
	/**
	 * Importe les fichiers XML qui sont dans le répertoire d'import
	 * @return 
	 */
	public static function import (){
		date_default_timezone_set("Europe/Paris");
		
		foreach (glob(Metier_Import_Rpu::$repertoire."RPU*.xml") as $vFichier) {
			// traite le fichier XML
			Metier_Import_Rpu::TraiteFichier($vFichier);
			
			// deplacer le fichier
			$vRepBackup = Dao_Util_Constantes::LectureConstante("rep_backup");
			$vNomFichier = basename($vFichier);
			
			rename($vFichier, $vRepBackup[0]."/RPU/".$vNomFichier);
		}
		
		// construire un rapport et envoyer par mail
	}
	
	private static function TraiteFichier($_fichier){
		
		$vDocumentRoot = simplexml_load_file($_fichier);
		
		//TODO: voir ce qu'on va faire de ces variables
		$vCodeFiness = $vDocumentRoot->xpath("///FINESS");
		$vEtablissement = Dao_Structure_Etablissement::ChercheParCodeFiness(strval($vCodeFiness[0]));
		echo $vCodeFiness;
		$ordre = $vDocumentRoot->xpath("///ORDRE");
		$vExtractDate = $vDocumentRoot->xpath("///EXTRACT");
		$extract = Metier_Util_Date::StringDateVersMysqlDateTime(strval ($vExtractDate[0]));
		$dateDebut = $vDocumentRoot->xpath("///DATEDEBUT");
		$dateFin = $vDocumentRoot->xpath("///DATEFIN");
		
		$vNoeudRpuS = $vDocumentRoot->xpath("///PATIENT");
		foreach ($vNoeudRpuS as $vNoeudRpu){
			// transformer le fichier XML en objet
			$vRpu = Metier_Import_Rpu::XmlRpuVersObj($vNoeudRpu, $vEtablissement);
			
			$vRpu->setDateExtraction($extract);
			
			// enregistre l'objet en base de données
			Metier_Import_Rpu::ObjRpuVersDB($vRpu);
		}
	}
	
	/**
	 * Transforme une noeud XML en objet
	 * @param $_vNoeudRpu: noeud à transformer
	 * @param $_etablissement (Objet_Structure_Etablissement): Etablissement de passage du patient
	 * @return Objet_Import_Rpu
	 */
	private static function XmlRpuVersObj (&$_vNoeudRpu, &$_etablissement){
		$vRpu = new Objet_Import_Rpu;
		
		$vRpu->setEtablissement($_etablissement);
		
		$vRpu->setSexe(strval($_vNoeudRpu->SEXE));
		$vRpu->setDateNaissance(strval($_vNoeudRpu->NAISSANCE));
		$vRpu->setCodePostal(strval($_vNoeudRpu->CP));
		$vRpu->setVille(strval($_vNoeudRpu->COMMUNE));
		
		$vRpu->setDateEntree(strval($_vNoeudRpu->ENTREE));
		try {
			$vRpu->setModeEntree(intval($_vNoeudRpu->MODE_ENTREE));
		}
		catch (Objet_Exception_WrongDataException $vE){
			echo $vE;
		}
		try {
			$vRpu->setProvenance(strval($_vNoeudRpu->PROVENANCE));
		}
		catch (Objet_Exception_WrongDataException $vE){
			echo $vE;
		}
		try {
			$vRpu->setModeTransport(strval($_vNoeudRpu->TRANSPORT));
		}
		catch (Objet_Exception_WrongDataException $vE){
			echo $vE;
		}
		try {
			$vRpu->setTransportPEC(strval($_vNoeudRpu->TRANSPORT_PEC));
		}
		catch (Objet_Exception_WrongDataException $vE){
			echo $vE;
		}
		
		$vRpu->setMotif(strval($_vNoeudRpu->MOTIF));
		try {
			$vRpu->setGravite(strval($_vNoeudRpu->GRAVITE));
		}
		catch (Objet_Exception_WrongDataException $vE){
			echo $vE;
		}
		$vRpu->setDiagPrincipal(Dao_Veille_Diagnostique::ChercheDiagnostiqueParCode(strval($_vNoeudRpu->DP)));
		foreach($_vNoeudRpu->LISTE_DA as $vNoeudDiagAssocie){
			$vRpu->addDiagAssocie(Dao_Veille_Diagnostique::ChercheDiagnostiqueParCode(strval($vNoeudDiagAssocie->DA)));
		}
		foreach($_vNoeudRpu->LISTE_ACTES as $vNoeudActes){
			$vRpu->addActe(Dao_Veille_Acte::ChercheActeParCode(strval($vNoeudActes->ACTE)));
		}
		
		$vRpu->setDateSortie(strVal($_vNoeudRpu->SORTIE));
		try {
			$vRpu->setModeSortie(intval($_vNoeudRpu->MODE_SORTIE));
		}
		catch (Objet_Exception_WrongDataException $vE){
			echo $vE;
		}
		try {
			$vRpu->setDestination(intval($_vNoeudRpu->DESTINATION));
		}
		catch (Objet_Exception_WrongDataException $vE){
			echo $vE;
		}
		try {
			$vRpu->setOrientation(strVal($_vNoeudRpu->ORIENT));
		}
		catch (Objet_Exception_WrongDataException $vE){
			echo $vE;
		}
		
		return $vRpu;
	}
	
	/**
	 * Enregistre le RPU en base de données
	 * @param $_rpu (Objet_Import_Rpu): RPU à enregistrer 
	 * @return 
	 */
	private static function ObjRpuVersDB (&$_rpu){
		Dao_Veille_Rpu::MajRpu($_rpu);
	}
}
?>