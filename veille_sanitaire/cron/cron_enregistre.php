<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//----------------------------------------- SAGEC --------------------------------
//
//	programme: 		cron_enregistre.php
//	date de création: 	15/05/2005
//	auteur:			jcb
//	description:		Enregistre le paramétrage des envois automatiques
//	version:			1.0
//	maj le:			15/05/2005
//
//--------------------------------------------------------------------------------
//
session_start();
if(! $_SESSION['auto_hopital'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//
require("../../pma_connect.php");
require("../../pma_connexion.php");
require("../../pma_requete.php");
require("../../date.php");
include "utilitaire_cron.php";
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$date1 = strtotime($_POST['date1']);
$date2 = strtotime($_POST['date2']);
$now = time();

if($_POST['ok'])
{
	$requete = "UPDATE cron SET
				cron_maj='$now',
				cron_heure = '$_POST[heure]',
				cron_minute = '$_POST[minute]',
				cron_jour = '$_POST[jour]',
				cron_adresse = '$_POST[url]',
				cron_date1= '$date1',
				cron_date2 = '$date2',
				cron_heure = '$_POST[heure]',
				cron_intervalle = '$_POST[intervalle]',
				cron_login = '$_POST[login]',
				cron_password = '$_POST[pass]'
	";
	$resultat = ExecRequete($requete,$connexion);
	//print($resultat);
	header("Location: cron_reglage.php");
}
//
// Arret de la connexion automatique
else if($_POST['stop1'])
{
	exec('crontab -r'); /* supprime le fichier crontab créé par apache */
	$requete = "UPDATE cron SET cron_auto = 'n'";
	$resultat = ExecRequete($requete,$connexion);
	header("Location: cron_reglage.php");
}
//Relance de la connexion automatique
else if($_POST['start1'])
{
	$requete = "UPDATE cron SET cron_auto = 'o'";
	$resultat = ExecRequete($requete,$connexion);
	exec('crontab -r'); /* supprime le fichier crontab créé par apache */
	$chpHeure = $_POST['heure'];
	$chpMinute = $_POST['minute'];
	$chpJourMois = "*";
	if($_POST['jour']==7) $chpJourSemaine = "*";
	else $chpJourSemaine = $_POST['jour'];
	$chpMois = "*";
	// remplacer test.php par le fichier qui crée l'export XML et le crypte: create_xml.php
	$chpCommande = "wget --delete-after http://localhost/SAGEC67_v3/veille_sanitaire/create_xml.php";
	$chpCommentaire = "test";
	$rep = ajouteScriptSagec($chpHeure, $chpMinute, $chpJourMois, $chpJourSemaine, $chpMois, $chpCommande, $chpCommentaire);
	header("Location: cron_reglage.php");
}
//Envoi manuel
else if($_POST['start2'])
{
	//print($_POST['date1']." ".$_POST['date2']);
	header("Location: ../create_xml.php?date1=$date1&date2=$date2");

}
?>
