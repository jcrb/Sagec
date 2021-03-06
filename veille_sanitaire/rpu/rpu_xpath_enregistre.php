<?php
/**
*	Teste XPATH
*	rpu_xpath.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
$path = $backPathToRoot."sagec_echange/statistiques/";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."date.php");
include ($backPathToRoot.'utilitaires/stack.php');

/**
*	Parse un fichier RPU dans les tables de la base
*	@input $path chemin d'acc�s au fichier
*/
function parse_rpu($path)
{
	$rpu = array();
	$xml = simplexml_load_file($path);
	$finess = $xml->xpath("///FINESS");
	$ordre = $xml->xpath("///ORDRE");
	$extract = $xml->xpath("///EXTRACT");
	$dateDebut = $xml->xpath("///DATEDEBUT");
	$dateFin = $xml->xpath("///DATEFIN");
	//print($finess[0]);

	$patient = $xml->xpath("///PATIENT");// le nb de / d�pend de la profondeur dans l'arborescence 

	foreach ($patient as $p)
	{
		$requete = "INSERT INTO rpu(
			rpu_ID,finess,
			date_extraction ,
			date_jour ,
			zip ,
			ville ,
			date_naissance ,
			sexe ,
			date_entree ,
			mode_entree ,
			provenance ,
			transport ,
			transport_pec ,
			motif ,
			ccmu ,
			diag_principal ,
			date_sortie ,
			mode_sortie ,
			destination ,
			orientation)
			VALUES(NULL,
			'$finess[0]',
			'$extract[0]',
			'$dateDebut[0]',
			'$p->CP',
			'$p->COMMUNE',
			'$p->NAISSANCE',
			'$p->SEXE',
			'$p->ENTREE',
			'$p->MODE_ENTREE',
			'$p->PROVENANCE',
			'$p->TRANSPORT',
			'$p->TRANSPORT_PEC',
			'$p->MOTIF',
			'$p->HMED',
			'$p->DP',
			'$p->SORTIE',
			'$p->MODE_SORTIE',
			'$p->DESTINATION',
			'$p->ORIENT'
	 		)"; 
		$resultat = ExecRequete($requete,$connexion);
	
		$idRpu = mysql_insert_id();
		
		//$da = $p->xpath("LISTE_DA");
		foreach ($p->LISTE_DA->DA as $d)
		{
			//print($d);
			$requete = "INSERT INTO rpu_diagAssocie(rpu_ID,diag_ID) VALUES('$idRpu','$d')";
			ExecRequete($requete,$connexion);
		}
		//print(count($p->LISTE_ACTES->ACTE));
		foreach($p->LISTE_ACTES->ACTE as $a)
		{
			//print($a);
			$requete = "INSERT INTO rpu_actes (rpu_ID,acte_ID) VALUES('$idRpu','$a')";
			ExecRequete($requete,$connexion);
		}
	}
}

function parseRPU($path)
{
	$path = "RPU_670780691_090510.xml";// a commenter en mode production 
	parse_rpu($path);
}
?>