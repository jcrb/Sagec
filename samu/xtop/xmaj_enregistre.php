<?php
/**
  *	xtop_enregistre.php
  */
  	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);	
	$backPathToRoot = "../../";
	require($backPathToRoot."dbConnection.php");
	include($backPathToRoot."login/init_security.php");
	require($backPathToRoot."date.php");
  
  $date = uDateTime2MySql(time());
  $ID_utilisateur = '$_SESSION[member_id]';
  $organisme = '$_SESSION[organisation]';
  
  $attente = Security::esc2Db($_REQUEST['attente']);
  $boxes = Security::esc2Db($_REQUEST['boxes']);
  $brancard = Security::esc2Db($_REQUEST['brancard']);
  $dechoc = Security::esc2Db($_REQUEST['dechoc']);
  $uhtcd = Security::esc2Db($_REQUEST['uhtcd']);
  $rem = Security::esc2Db($_REQUEST['rem']);
  
  
  // nouveau message 
  if($message != '' && $messageID < 1 && $auteur !=0)// ne pas enregistrer une phrase vide 
  {
  	$requete = "INSERT INTO pma.top (top_ID,top_date,top_clerk,top_attente,top_boxes,top_brancard,top_dechoc,top_uhtcd,top_rem,top_org_ID)
  					VALUES (NULL,$date,$ID_utilisateur,$attente,$boxes,$brancard,$dechoc,$uhtcd,$rem,$organisme)"; 
  	$result = ExecRequete($requete,$connexion);
  	$messageID = mysql_insert_id ();
  }
  else if($auteur !=0) // c'est une mise à jour 
  {
  	$requete = "UPDATE pma.top SET
  					top_date = '$date',
  					top_clerk = '$ID_utilisateur',
  					top_attente = '$attente',
  					top_boxes = '$boxes',
  					top_brancard = '$brancard',
  					top_dechoc = '$dechoc',
  					top_uhtcd = '$uhtcd',
  					top_rem = '$rem',
  					top_org_ID = '$organisme',
  					
  					WHERE ID = '$messageID'
  					";
  	$result = ExecRequete($requete,$connexion);
  }
  //print_r( $_REQUEST);
  header("Location: xmaj.php?messageID=$messageID&info=message enregistre");
?>