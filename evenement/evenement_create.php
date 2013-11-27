<?php
/**
  *	evenement_create.php
  *
  */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>100) header("Location:../logout.php");
$backPathToRoot = "../";
include($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."date.php");
include_once($backPathToRoot."administrateur/sauvegarde_TXT.php");
include($backPathToRoot."login/init_security.php");


/* Sauvegarde de l'évènement précédant */
	if($_SESSION['evenement'] > 1)
	{
		// administrateur/sauvegarde.php 
		sauvegarde_txt();
	}
	$requete = "SELECT* FROM evenement WHERE evenement_ID = '$_REQUEST[ev_courant_prec]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);

	if($rub['evenement_nom']!=$_REQUEST['titre'])//si l'évènement précédant a un nom différent
	{
		
		$date = security::esc2Db($_REQUEST['date1']);
		$heure = security::esc2Db($_REQUEST['heure1']);
		$samu = security::esc2Db($_REQUEST['dossier_samu']);
		$sdis = security::esc2Db($_REQUEST['dossier_sdis']);
		$comment = security::esc2Db($_REQUEST['comment']);
		$titre = security::esc2Db($_REQUEST['titre']);
		$ppi = security::esc2Db($_REQUEST['ppi_id']);
		if($_REQUEST['actif'])$actif = 'oui';// évènement en cours 
		
		$requete = "INSERT INTO evenement VALUES('','$titre','$date','$heure','0','$heure','0','0','$actif','$samu','$sdis','$comment','$ppi')";
		$resultat = ExecRequete($requete,$connexion);
		// récupérer l'ID. Si ID = 1, il ne se passe rien
		$maj = mysql_insert_id();
		// créer un enregistrement dans la table incident_description
		$requete = "INSERT INTO `pma`.`incident_description` (`incident_ID`, `incident_nom`, `incident_categorie`, `incident_type`, `incident_stype`, `incident_severite`, `incident_version`, `incident_date`, `incident_status`, 				`incident_phase`, `incident_niveau`, `incident_date_maj`, `incident_date_cloture`, `incident_certitude`, `evenement_ID`) 
		VALUES (NULL, '$titre', '0', '0', '0', '0', '0', '$date', '0', '0', '0', '$date', '$date', '0', '$maj');";
		// mettre à jour la table alerte
		$requete = "UPDATE alerte SET evenement_ID = '$maj'";
		$resultat = ExecRequete($requete,$connexion);
		// mettre à jour les structures temporaires réutilisables ?
	}
	
	if($_REQUEST['titre'] != "Aucun évènement en cours")
	{
			// diriger vers la page spécifique de l'évènement
			//header("Location:evenement_courant.php");
			if($_REQUEST['pco'])
			{
				$requete = "SELECT ts_ID FROM temp_structure WHERE ts_nom = 'PCO 1'";
				$resultat = ExecRequete($requete,$connexion);
				$rep = mysql_fetch_array($resultat);
				$PCO_ID = $rep[ts_ID];// adresse du PCO
				if(!$rep[ts_ID])
				{
					$requete = "INSERT INTO `temp_structure` (`ts_ID`,`ts_nom`,`ts_type`,`ts_localisation`,`ts_contact`,`ts_lat`,`ts_long`,`cata_ID`, `ts_parent_ID`,`ts_active`,`ts_heure_activation`,`ts_heure_arret`,`ts_reutilisable`)VALUES ('', 'PCO 1', '11', '', '0', '0', '0', '$_SESSION[evenement]', '0','o', '$datetime ', '$datetime ', 'n')";
					$PCO_ID = mysql_insert_id() ;
				}
				else
					$requete = "UPDATE `temp_structure` SET `ts_heure_activation`='$datetime',`ts_heure_arret`='$datetime',`ts_active`='o' WHERE ts_ID='$rep[ts_ID]'";
				$resultat = ExecRequete($requete,$connexion);
			}
			
			if($_REQUEST['pma'])
			{
				$requete = "SELECT ts_ID FROM temp_structure WHERE ts_nom = 'PMA 1'";
				$resultat = ExecRequete($requete,$connexion);
				$rep = mysql_fetch_array($resultat);
				$PMA_ID = $rep[ts_ID]; // adresse du PMA
				if(!$rep[ts_ID])
					$requete = "INSERT INTO `temp_structure` (`ts_ID`,`ts_nom`,`ts_type`,`ts_localisation`,`ts_contact`,`ts_lat`,`ts_long`,`cata_ID`, `ts_parent_ID`,`ts_active`,`ts_heure_activation`,`ts_heure_arret`,`ts_reutilisable`)VALUES ('', 'PMA 1', '3', '', '0', '0', '0', '$_SESSION[evenement]', '$PCO_ID','o', '$datetime ', '$datetime', 'n')";
				else
					$requete = "UPDATE `temp_structure` SET `ts_heure_activation`='$datetime',`ts_heure_arret`='$datetime',`ts_active`='o' WHERE ts_ID='$rep[ts_ID]'";
				$resultat = ExecRequete($requete,$connexion);
			}
			
			if($_REQUEST['chantier'])
			{
				$requete = "SELECT ts_ID FROM temp_structure WHERE ts_nom = 'chantier 1'";
				$resultat = ExecRequete($requete,$connexion);
				$rep = mysql_fetch_array($resultat);
				if(!$rep[ts_ID])
					$requete = "INSERT INTO `temp_structure` (`ts_ID`,`ts_nom`,`ts_type`,`ts_localisation`,`ts_contact`,`ts_lat`,`ts_long`,`cata_ID`, `ts_parent_ID`,`ts_active`,`ts_heure_activation`,`ts_heure_arret`,`ts_reutilisable`)VALUES ('', 'chantier 1', '1', '', '0', '0', '0', '$_SESSION[evenement]', '$PMA_ID','o', '$datetime ', '$datetime', 'n')";
				else
					$requete = "UPDATE `temp_structure` SET `ts_heure_activation`='$datetime',`ts_heure_arret`='$datetime',`ts_active`='o' WHERE ts_ID='$rep[ts_ID]'";
				$resultat = ExecRequete($requete,$connexion);
			}
			$datetime = uDateTime2MySql(time());
			

			if($_REQUEST['actif'])
			{
				// mettre à jour la variable globale
				$_SESSION["evenement"] = $maj;
				$requete = "UPDATE alerte SET evenement_ID = '$maj'";
				$resultat = ExecRequete($requete,$connexion);
			}
		}
		else
		{
			// mettre à jour la table alerte
			$requete = "UPDATE alerte SET evenement_ID = 1";
			$resultat = ExecRequete($requete,$connexion);
			// mettre à jour la variable globale
			$_SESSION["evenement"] = 1;
		}

?>