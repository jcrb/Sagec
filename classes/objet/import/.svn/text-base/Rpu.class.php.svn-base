<?php
if (!isset($BackToRoot)){
	$BackToRoot = "./../../../";
}

require_once $BackToRoot."classes/objet/exception/WrongDataException.class.php";

require_once $BackToRoot."classes/objet/import/RpuActe.class.php";
require_once $BackToRoot."classes/objet/import/RpuDiagnostique.class.php";
require_once $BackToRoot."classes/objet/structure/Etablissement.class.php";

/**
 * Un passage au RPU
 * 
 * @package Objet_Import
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Import_Rpu{
	/**
	 * Identifiant du passage dans la base
	 * @var int
	 */
	private $id;
	
	/**
	 * Etablissement qui a traité le patien
	 * @var Objet_Structure_Etablissement
	 */
	private $etablissement;
	
	/**
	 * Date d'extraction des données
	 * @var date / heure (string)
	 */
	private $dateExtraction;
	
	private $jourPassage;
	
	/**
	 * Sexe du patient M / F / I pour indeterminé
	 * @var string
	 */
	private $sexe;
	
	/**
	 * Date de naissance du patient 
	 * @var date (string)
	 */
	private $dateNaissance;
	
	/**
	 * Code postal du patient
	 * @var string
	 */
	private $codePostal;
	
	/**
	 * Localité du patient
	 * @var string
	 */
	private $ville;
	
	/**
	 * Date d'entée aux urgences
	 * @var date / heure (string)
	 */
	private $dateEntree;
	
	/**
	 * Mode d'entée aux urgences:
	 * 6 - Mutation
	 * 7 - Transfert
	 * 8 - Domicile
	 * @var date / heure (string)
	 */
	private $modeEntree;
	
	/**
	 * Provenance du patient:
	 * En cas d’entrée par mutation ou transfert 
	 * 1 - En provenance d'une unité de soins de courte durée (MCO)
	 * 2 - En provenance d'une unité de soins de suite ou de réadaptation
	 * 3 - En provenance d'une unité de soins de longue durée
	 * 4 - En provenance d'une unité de psychiatrie
	 * En cas d'entrée à partir du domicile
	 * 5 - Prise en charge aux urgences autres que pour des raisons organisationnelles
	 * 8 - Prise en charge aux urgences pour des raisons organisationnelles
	 * @var int
	 */
	private $provencance;
	
	/**
	 * Mode de transport du patient:
	 * PERSO - pour moyen personnels (à pied, en taxi, en voiture personnelle,…)
	 * AMBU - ambulance publique ou privée
	 * VSAB - véhicule de secours et d’aide au blessés
	 * SMUR - véhicule de Service Mobile d’Urgence et de Réanimation
	 * HELI - hélicoptère
	 * FO - force de l’ordre (police, gendarmerie)

	 * @var string
	 */
	private $modeTransport;

	/**
	 * Prise en charge pendant le transport:
	 * MED - médicalisée
	 * PARAMED - paramédicalisée
	 * AUCUN - sans prise en charge médicalisée ou paramédicalisée
	 * @var string
	 */
	private $transportPEC;
	
	/**
	 * Motif de la visite codé
	 * @var string
	 */
	private $motif;

	/**
	 * Gravité codé en CCMU:
	 * 1 - Etat lésionnel ou pronostic fonctionnel jugé stable après le premier examen clinique éventuellement complété d’actes diagnostiques réalisés et interprétés au lits du malade, abstention d’actes complémentaires ou de thérapeutique 
	 * P - Idem CCMU 1 avec problème dominant psychiatrique ou psychologique isolé ou associé à une pathologie somatique jugée stable.
	 * 2 - Etat lésionnel ou pronostic fonctionnel jugé stable, réalisation d’actes complémentaires aux urgences en dehors des actes diagnostiques éventuellement réalisés et interprétés au lits du malade et / ou d’actes thérapeutiques
	 * 3 - Etat lésionnel ou pronostic fonctionnel jugé susceptible de s’aggraver aux urgences sans mettre en jeu le pronostic vital
	 * 4 - Situation pathologique engageant le pronostic vital aux urgences sans manœuvre de réanimation initiée ou poursuivie dés l’entrée aux urgences
	 * 5 - Situation pathologique engageant le pronostic vital aux urgences avec initiation ou poursuite de manœuvres de réanimation dés l’entrée aux urgences
	 * D - Patient décédé à l’entrée aux urgences sans avoir pu bénéficier d’initiation ou poursuite de manœuvres de réanimation aux urgences
	 * @var string
	 */
	private $gravite;

	/**
	 * Diagnostique principale (codage CIM10)
	 * @var Objet_Import_RpuDiagnostique
	 */
	private $diagPrincipal;

	/**
	 * Diagnostiques associés (codage CIM10)
	 * @var Objet_Import_RpuDiagnostique[]
	 */
	private $diagAssocie;

	/**
	 * Actes (codage CCAM)
	 * @var Objet_Import_RpuActe[]
	 */
	private $actes;
	
	/**
	 * Date de sortie
	 * @var date / heure (string)
	 */
	private $dateSortie;

	/**
	 * Mode de sortie:
	 * 6 - Mutation : le malade est hospitalisé vers une autre unité médicale de la même entité juridique. Pour le coté puriste de la nomenclature : pour les établissements privés visés aux alinéas d et e de l'article L162-22-6 du code de la sécurité sociale (CSS) Cf annexe. Si le patient provient d’un autre établissement de la même entité juridique le mode d’entrée à utiliser est le 7 (Cf ci-dessous)
	 * 7 - Transfert : le malade est hospitalisé dans une autre entité juridique  (sauf cas particulier décrit ci-dessus).
	 * 8 - Domicile : le malade retourne au domicile ou son substitut, tel une structure d'hébergement médicosociale.
	 * 9 - Décès : le malade décède aux urgences
	 * @var int
	 */
	private $modeSortie;
	
	/**
	 * destination:
	 * En cas de sortie par mutation ou transfert
	 * 1 - Hospitalisation dans une unité de soins de courte durée (MCO)
	 * 2 - Hospitalisation dans une unité de soins de suite ou de réadaptation
	 * 3 - Hospitalisation dans une unité de soins de longue durée
	 * 4 - Hospitalisation dans une unité de psychiatrie
	 * En cas de sortie au domicile
	 * 6 - retour au domicile dans le cadre d’une hospitalisation à domicile
	 * 7 - dans une structure d'hébergement médicosociale
	 * @var int
	 */
	private $destination;

	/**
	 * Orientation du patient:
	 * En cas de sortie par mutation ou transfert 
	 * HDT - hospitalisation sur la demande d’un tiers
	 * HO - hospitalisation d’office
	 * SC - hospitalisation dans une unité de Surveillance Continue
	 * SI - hospitalisation dans une unité de Soins Intensifs
	 * REA - hospitalisation dans une unité de Réanimation
	 * UHCD - hospitalisation dans une unité d’hospitalisation de courte durée
	 * MED - hospitalisation dans une unité de Médecine hors SC, SI, REA
	 * CHIR - hospitalisation dans une unité de Chirurgie hors SC, SI, REA
	 * OBST - hospitalisation dans une unité d’Obstétrique hors SC, SI, REA
	 * En cas de sortie au domicile 
	 * FUGUE - sortie du service à l’insu du personnel soignant
	 * SCAM - sortie contre avis médical
	 * PSA - partie sans attendre prise en charge
	 * REO - réorientation directe sans soins (ex vers consultation spécialisée ou lorsque le service d’accueil administratif est fermée) 
	 * @var string
	 */
	private $orientation;

	public function getId(){
		return $this->id;
	}
	public function setId($_id){
		$this->id = $_id;
	}
	
	public function getEtablissement(){
		return $this->etablissement;
	}
	public function setEtablissement ($_etablissement){
		$this->etablissement = $_etablissement;
	}
	
	public function getDateExtraction(){
		return $this->dateExtraction;
	}
	public function setDateExtraction($_dateExtraction){
		$this->dateExtraction = $_dateExtraction;
	}
	
	public function getSexe(){
		return $this->sexe;
	}
	public function setSexe($_sexe){
		$_sexe = strtoupper($_sexe);
		
		$vTabCode = array("M", "F", "I");
		if (!in_array($_sexe, $vTabCode)){
			$_sexe = 'I';
		}
		$this->sexe = $_sexe;
	}
	
	public function getDateNaissance(){
		return $this->dateNaissance;
	}
	public function setDateNaissance($_dateNaissance){
		$this->dateNaissance = $_dateNaissance;
	}
	
	public function getCodePostal(){
		return $this->codePostal;
	}
	public function setCodePostal($_codePostal){
		$this->codePostal = $_codePostal;
	}
	
	public function getVille(){
		return $this->ville;
	}
	public function setVille($_ville){
		$this->ville = $_ville;
	}
	
	public function getDateEntree(){
		return $this->dateEntree;
	}
	public function setDateEntree($_dateEntree){
		$this->dateEntree = $_dateEntree;
	}
	
	public function getModeEntree(){
		return $this->modeEntree;
	}
	public function setModeEntree($_modeEntree){
		$_modeEntree = intval($_modeEntree);
		
		$vTabCode = array(6, 7, 8);
		if (in_array($_modeEntree, $vTabCode)){
			$this->modeEntree = $_modeEntree;
		}
		else {
			$this->modeEntree = 0;
			throw new Objet_Exception_WrongDataException ("setModeEntree(".$_modeEntree.")"); 
		}
	}
	
	public function getProvenance(){
		return $this->provencance;
	}
	public function setProvenance($_provenance){
		$_provenance = intval($_provenance);
		
		$vTabCode = array(1, 2, 3, 4, 5, 8);
		if (in_array($_provenance, $vTabCode)){
			$this->provencance = $_provenance;
		}
		else {
			$this->provencance = 0;
			throw new Objet_Exception_WrongDataException ("setsetProvenance(".$_provenance.")"); 
		}
	}
	
	public function getModeTransport(){
		return $this->modeTransport;
	}
	public function setModeTransport($_modeTransport){
		$_modeTransport = strtoupper($_modeTransport);
		
		$vTabCode = array ("PERSO", "AMBU", "VSAB", "SMUR", "HELI", "FO");
		if (in_array($_modeTransport, $vTabCode)){
			$this->modeTransport = $_modeTransport;
		}
		else {
			$this->modeTransport = 0;
			throw new Objet_Exception_WrongDataException ("setModeTransport(".$_modeTransport.")"); 
		}
	}
	
	public function getTransportPEC(){
		return $this->transportPEC;
	}
	public function setTransportPEC($_transportPEC){
		$_transportPEC = strtoupper($_transportPEC);
		
		$vTabCode = array("MED", "PARAMED", "AUCUN");
		if (in_array($_transportPEC, $vTabCode)){
			$this->transportPEC = $_transportPEC;
		}
		else {
			$this->transportPEC = 0;
			throw new Objet_Exception_WrongDataException ("setTransportPEC(".$_transportPEC.")"); 
		}
	}
	
	public function getMotif(){
		return $this->motif;
	}
	public function setMotif($_motif){
		$this->motif = $_motif;
	}
	
	public function getGravite(){
		return $this->gravite;
	}
	public function setGravite($_gravite){
		$_gravite = strtoupper($_gravite);
		
		$vTabCode = array("1", "P", "2", "3", "4", "5", "D");
		if (in_array($_gravite, $vTabCode)){
			$this->gravite = $_gravite;
		}
		else {
			$this->gravite = 0;
			throw new Objet_Exception_WrongDataException ("setGravite(".$_gravite.")"); 
		}
	}
	
	public function getDiagPrincipal(){
		return $this->diagPrincipal;
	}
	public function setDiagPrincipal($_diagPrincipal){
		if ($_diagPrincipal != null)
			$this->diagPrincipal = $_diagPrincipal;
	}
	
	public function getDiagAssocie(){
		return $this->diagAssocie;
	}
	public function setDiagAssocie($_diagAssocie){
		if (is_array($_diagAssocie)){
			$this->diagAssocie = $_diagAssocie;
		}
	}
	public function addDiagAssocie($_diagAssocie){
		if (!is_array($this->diagAssocie)){
			$this->diagAssocie = array();
		}
		
		if ($_diagAssocie != null)
			$this->diagAssocie[] = $_diagAssocie;
	}
	
	public function getActes(){
		return $this->actes;
	}
	public function setActes($_actes){
		if (is_array($_actes)){
			$this->actes = $_actes;
		}
	}
	public function addActe($_acte){
		if (!is_array($this->actes)){
			$this->actes = array();
		}
		
		if ($_acte != null)
			$this->actes[] = $_acte;
	}
	
	public function getDateSortie(){
		return $this->dateSortie;
	}
	public function setDateSortie($_dateSortie){
		$this->dateSortie = $_dateSortie;
	}
	
	public function getModeSortie(){
		return $this->modeSortie;
	}
	public function setModeSortie($_modeSortie){
		$_modeSortie = intval($_modeSortie);
		
		$vTabCode = array(6, 7, 8, 9);
		if (in_array($_modeSortie, $vTabCode)){
			$this->modeSortie = $_modeSortie;
		}
		else {
			$this->modeSortie = 0;
			throw new Objet_Exception_WrongDataException ("setModeSortie(".$_modeSortie.")"); 
		}
	}
	
	public function getDestination(){
		return $this->destination;
	}
	public function setDestination($_destination){
		$vDestination = intval($_destination);
		
		$vTabCode = array(1, 2, 3, 4, 6, 7);
		if (in_array($vDestination, $vTabCode)){
			$this->destination = $vDestination;
		}
		else {
			$this->destination = 0;
			throw new Objet_Exception_WrongDataException ("setDestination(".$_destination.") - ".$vDestination." - ".$this->etablissement->getFiness()." ");
		}
	}
	
	public function getOrientation(){
		return $this->orientation;
	}
	public function setOrientation($_orientation){
		$_orientation = strtoupper($_orientation);
		
		$vTabCode = array("HDT", "HO", "SC", "SI", "REA", "UHCD", "MED", "CHIR", "OBST", "FUGUE", "SCAM", "PSA", "REO");
		if (in_array($_orientation, $vTabCode)){
			$this->orientation = $_orientation;
		}
		else {
			$this->orientation = 0;
			throw new Objet_Exception_WrongDataException ("setOrientation(".$_orientation.")"); 
		}
	}
}
?>