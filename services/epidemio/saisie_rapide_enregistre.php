<?php

/**
 * saisie_rapide_enregistre.php
 * programme réécrit: les varaibles $_GET ont été remplacées par $_POST 
 * en raison d'une incompatibilité avec Internet Explorer
 * @todo revoir la partie messages d'erreur qui a été désactivée
 * @version $Id$
 * @copyright 2007
 */
session_start();
if(! $_SESSION['auto_hopital'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../../pma_connect.php");
require("../../pma_connexion.php");
require "../../utilitairesHTML.php";
require "../../date.php";
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

 $s=$_POST['services'];	// identifiant du service
	$l=$_POST['litsd'];		// tableau des lits disponibles
	$c=$_POST['check'];
	$p=$_POST['placessd'];	// tableau des places disponibles
	$lits_auto = $_POST['lits_auto'];// tableau du nombre de lits autorisés
	$date=fDatetime2unix($_POST['date']);	//$_POST['date']
	$max = sizeof($l);

	// vérifier qu'il n'ya pas d'erreur de saisie:
	/*
	for($i=0;$i<$max;$i++)
	{
		if($l[$i] > $lits_auto[$i] || $l[$i] < 0)
			header("Location:saisie_rapide_old.php?erreur=1&id=$s[$i]");
	}
	*/
	for($i=0;$i<$max;$i++)
	{
		if($s[$i] && is_numeric($l[$i]) || is_numeric($p[$i]))
		{
			// mise à jour du journal des lits
			$requete="INSERT INTO lits_journal VALUES('$date','$s[$i]','$l[$i]','$_SESSION[member_id]')";
			$resultat = ExecRequete($requete,$connexion);
			// mise à jour du journal des places
			if(is_numeric($p[$i]))
			{
				$requete="INSERT INTO places_journal VALUES('$date','$s[$i]','$p[$i]','$_SESSION[member_id]')";
				$resultat = ExecRequete($requete,$connexion);
			}
			// la mise à jour ne se fait que si la date est plus récente que la date enregistrée
			$requete = "SELECT date_maj FROM lits WHERE service_ID = '$s[$i]'";
			$resultat = ExecRequete($requete,$connexion);
			$last_maj = mysql_fetch_array($resultat);
			$date2 = $last_maj['date_maj'];

//	print("service: ".$s[$i]."<br>");
//	print("last_maj = ".$date2." - date = ".$date."<br>");

			if(intval($date2) < intval($date))
			{
				$requete = "UPDATE lits SET
										lits_dispo = '$l[$i]',
										places_dispo = '$p[$i]',
										date_maj = '$date'
										WHERE service_ID = '$s[$i]'";
				$resultat = ExecRequete($requete,$connexion);
				//print("date maj <br>");
			}
	//print($l[$i]." ".$s[$i]." ".$s[$i]." ".$p[$i]."<br>");
			$requete = "SELECT date_maj FROM lits WHERE service_ID = '$s[$i]'";
			$resultat = ExecRequete($requete,$connexion);
			$last_maj = mysql_fetch_array($resultat);
			$date3 = $last_maj['date_maj'];
			//print("last_maj = ".$date3." - date = ".$date);
		}
	}

header("Location:saisie_rapide.php?ok=ok");


?>