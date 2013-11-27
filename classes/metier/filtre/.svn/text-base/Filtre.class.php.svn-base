<?php
require_once $BackToRoot."classes/dao/Filtre.class.php";
require_once $BackToRoot."classes/objet/filtre/Filtre.class.php";

class Metier_Filtre_ParamFiltre{
	/**
	 * Lit les paramètres du fichier XML
	 * @param $_nomFiltre: String
	 * @return Objet_filtre_Filtre
	 */
	public function LectureParam($_nomFiltre){
		$vDocumentRoot = simplexml_load_file($_nomFiltre);
		$vFiltre = new Objet_filtre_Filtre();
		
		$vSqlListeNoeud = $vDocumentRoot->xpath("///SQL_LISTE");
		if (isset($vSqlListeNoeud)){
			$vFiltre->setSqlListe($vSqlListeNoeud[0]);
		}
		$vSelDefautNoeud = $vDocumentRoot->xpath("///DEFAULT/ID");
		if (isset($vSelDefautNoeud)){
			$vFiltre->addListeDefaultId($vSelDefautNoeud[0]);
		}
		$vNoSelIdNoeud = $vDocumentRoot->xpath("///NO_SELECT_ID");
		if (isset($vNoSelIdNoeud) && isset($vNoSelIdNoeud[0])){
			$vFiltre->setNoSelectId($vNoSelIdNoeud[0]);
		}
		$vNoSelLibNoeud = $vDocumentRoot->xpath("///NO_SELECT_LABEL");
		if (isset($vNoSelLibNoeud) && isset($vNoSelLibNoeud[0])){
			$vFiltre->setNoSelectLibelle(utf8_decode($vNoSelLibNoeud[0]));
		}
		
		$vListeParam = array();
		$vParamNoeud = $vDocumentRoot->xpath("///PARAM");
		if (isset($vParamNoeud) && isset ($vParamNoeud[0])){
			foreach ($vParamNoeud[0] as $vNoeudNom => $vParamNoeudP){
				$vListeParam[$vNoeudNom]=$vParamNoeudP;
			}
		}
		$vFiltre->setListeParam($vListeParam);

		$vWhereNoeud = $vDocumentRoot->xpath("///WHERE");
		if (isset ($vWhereNoeud) && isset($vWhereNoeud[0])){
			$vFiltre->setSqlWhere(strval($vWhereNoeud[0]));
		}

		$vInAllNoeud = $vDocumentRoot->xpath("///IN_ALL");
		if (isset($vInAllNoeud) && isset ($vInAllNoeud[0])){
			$vFiltre->setInAll(strval($vInAllNoeud[0]));
		}
		return $vFiltre;
	}
	
	/**
	 * Lit la liste des élements du filtre
	 * @param $_sql: String
	 * @return String[] (clé => Id, valeur => Libellé)
	 */
	public function lectureListe($_sql){
		return Dao_Filtre::ChercheElementFiltre($_sql);
	}
	
	/**
	 * Vérifie si le fichier associé au filtre existe
	 * @param $_nomFiltre: String
	 * @return boolean: true si le fichier existe
	 */
	public function FiltreFileExiste($_nomFiltre){
		return file_exists($_nomFiltre);
	}
}
?>