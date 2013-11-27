<?php
/**
  *	dossier_cata_delete.php
  *	neutralise un dossier en mettant sont evenement_ID א 0
  *	crיי le 24/06/2012
  */
  session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	$backPathToRoot = "../";
	require($backPathToRoot."dbConnection.php");
	
  $id = $_REQUEST['id'];
  if($id > 1)
  {
  		print('neutralisation du dossier: '.$id);
  		$requete = "UPDATE victime SET evenement_ID = 0,comment='suppression' WHERE victime_ID = '$id'";
  		ExecRequete($requete,$connexion);
  }
  header("Location:dossier_cata_liste_entete.php");
?>