<?php
/**
  *	redirection.php
  */
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
$backPathToRoot = "./";
require("controle_acces.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."dbConnection.php");

$login ="";
$password= "";
$login = Security::esc2Db($_REQUEST['login']);
$password = Security::esc2Db($_REQUEST['password']);

/**
  * Rejet mot de passe trop court
  */
if(strlen($login)<2 || strlen($password)<2)
	header("Location: login_dialogue.php");
	

/**
  *	Utilisateur connu, on lit ses caractéristiques, sinon renvoyé
  */
	if(strlen($login)>0 && strlen($password)>0)
	{ 
		$utilisateur_nom = "";
		$utilisateur_nom = autorise($login, $password,$connexion);
		
		if(strlen($utilisateur_nom)< 2)
			header("Location: login_dialogue.php");
	}
	else
	{
		header("Location: login_dialogue.php");
	}

/**
  *	Utilisateur de type SAMU
  *	deux redirections possibles selon que l'on veut arriver
  *	directement ou non Ã  la cartographie
  */
  	if($_SESSION["service"]=="111"){
		//header("Location: samu/samu_main.php");
		//header("Location: samu/samu_main.php");//samu/regulation/carto_base.php
		header("Location: samu/messagerie/message_lire.php");//samu/regulation/carto_base.php
	}
	else 
	/**
    *	Utilisateur de type PMA
    */
	if($_SESSION["organisation"]=="2"){
		header("Location: pmas/pma_main.php");//samu/regulation/carto_base.php
	}
	
/**
  *	Sinon on repart vers la page denerale
  */
	else
		header("Location: login2.php");
	



?>
