<?php

if (!isset($BackToRoot)){
	$BackToRoot = '../../../';
}

require_once $BackToRoot."classes/dao/util/Constantes.class.php";

require_once $BackToRoot."classes/metier/import/Rapport.class.php";
require_once $BackToRoot."classes/metier/import/TraiteXml.class.php";

require_once $BackToRoot."classes/metier/util/Date.class.php";
require_once $BackToRoot."classes/metier/util/Mail.class.php";

/**
 * Intégration des disponibilité des lits (et données de veille sanitaire) dans SAGEC
 * 
 * @package Metier_Import
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */

class Metier_Import_Import{
	/**
	 * chemin du répertoire d'échange
	 * @var string
	 */
	private static $repertoire = /*$backToRoot.*/ "/sagec_echange/statistiques/";
	
	public static function setRepertoire ($_repertoire){
		Metier_Import_Import::$repertoire = $_repertoire;
	}
	/**
	 * Importe les fichiers XML qui sont dans le répertoire d'import
	 * @return 
	 */
	public static function import (){
		date_default_timezone_set("Europe/Paris");
		// liste des fichiers du répertoire
		foreach (glob(Metier_Import_Import::$repertoire."ARH*.xml") as $vFichier) {
			// traite le fichier XML
			$vDonneesEtablissement = Metier_Import_TraiteXml::TraiteFichier($vFichier);
	    	
			// deplacer le fichier
			$vRepBackup = Dao_Util_Constantes::LectureConstante("rep_backup");
			$vNomFichier = basename($vFichier);
			
			rename($vFichier, $vRepBackup[0]."/ARH/".$vNomFichier);
			
	    	Metier_Import_Rapport::ajouterMessage ($vDonneesEtablissement->getEtablissement(), 0, 0, "Fichier ".$vFichier." déplac&eacute;"); 
	    	
		}
		
		$vMessageHtml = Metier_Import_Rapport::construireRapport();
		
		// envoie le rapport par mail
		$vNomExpediteur = "SAGEC67";
		$vMailExpediteur = "noreply@chru-strasbourg.fr";
		$vMailDestinataire =Metier_Import_Import::getMail();
		$vSujet = "Rapport d'import";

		$vEntete = "MIME-Version: 1.0\r\n";
		$vEntete .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$vEntete .= "To: $vMailDestinataire <$vMailDestinataire>\r\n";
		$vEntete .= "From: $vNomExpediteur <$vMailExpediteur>\r\n";
		if(!mail($vMailDestinataire, $vSujet, $vMessageHtml, $vEntete)){
 			echo "L'email n'a pu être envoyé !";
		}
		
		// afficher le rapport sur la sortie standard
		echo $vMessageHtml;
	}
	
	private static function getMail(){
		$vListeMail = Dao_Util_Constantes::LectureConstante("rapport_import_flux");
		return Metier_Util_Mail::ConcatMailAdresse($vListeMail);
	}
}
?>
