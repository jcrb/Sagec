<?php
/**
  *	message_enregistre.php
  */
  	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);	
	$backPathToRoot = "../../";
	require($backPathToRoot."dbConnection.php");
	include($backPathToRoot."login/init_security.php");
	require($backPathToRoot."date.php");
  
  $date = uDateTime2MySql(time());
  
  $auteur = Security::esc2Db($_REQUEST['auteur']);
  $message = Security::esc2Db($_REQUEST['message']);
  $visible = Security::esc2Db($_REQUEST['visible']);
  $groupe = Security::esc2Db($_REQUEST['groupe']);
  $ID_utilisateur = '$_SESSION[member_id]';
  $irq = Security::esc2Db($_REQUEST['irq']);
  $messageID = Security::esc2Db($_REQUEST['messageID']);
  
  // nouveau message 
  if($message != '' && $messageID < 1 && $auteur !=0)// ne pas enregistrer une phrase vide 
  {
  	$requete = "INSERT INTO `pma`.`livrebord_service` (`LBS_ID`, `org_ID`, `LBS_expediteur`, `LBS_date`, `LBS_message`,`LBS_groupe`,`LBS_visible`,`LBS_irq`)
  					VALUES (NULL, '$_SESSION[organisation]','$auteur','$date','$message','$groupe','$visible','$irq')"; 
  	$result = ExecRequete($requete,$connexion);
  	$messageID = mysql_insert_id ();
  }
  else if($auteur !=0) // c'est une mise à jour 
  {
  	$requete = "UPDATE `pma`.`livrebord_service` SET
  					org_ID = '$_SESSION[organisation]',
  					LBS_expediteur = '$auteur',
  					LBS_message = '$message',
  					LBS_groupe = '$groupe',
  					LBS_visible = '$visible',
  					LBS_irq = '$irq'
  					WHERE LBS_ID = '$messageID'
  					";
  	$result = ExecRequete($requete,$connexion);
  }
  //print_r( $_REQUEST);
  header("Location: message_lire.php?messageID=$messageID&info=message enregistre");
?>