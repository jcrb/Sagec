<?php
/**
  *	scenario.php
  *
  */
  $backPathToRoot = "../../";
  include_once($backPathToRoot."dbConnection.php");
  
	$id  = $_REQUEST['id'];
	
	$requete = "SELECT stocki_nom,stocki_lat,stocki_lng,chem_nom,stocki_qte,unite_abrev,stocki_rayon1,stocki_rayon2,stocki_rayon3
					FROM stockage_industriel,produitsChimiques,med_unites 
					WHERE stocki_ID = '$id'
					AND stocki_qte_unite = med_unites.unite_ID
					AND stockage_industriel.produit_ID = produitsChimiques.chem_ID
					";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	echo json_encode($rub);
 
?>