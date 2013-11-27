<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		lits_fermes_enregistre.php
//	date de création: 	23/03/2005
//	auteur:			jcb
//	description:		service à modifier
//	version:			1.0
//	maj le:			23/03/2005
//
//--------------------------------------------------------------------------------------------------------
/** Variables transmises
*@param $debut date de début de la fermeture
*@param $fin date de fin de la fermeture
*@param $lits_fermes nombre de lits fermés
*/
//--------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_hopital'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";

require($backPathToRoot."dbConnection.php");
require($backPathToRoot."date.php");

/** vérifie si il n'y a pas déjà des lits fermés pour ce service
*@param $d date de début
*@param $f date de fin
*@param $s id du service */
function chevauchement($d,$f,$s,$connexion)
{
	$requete = "SELECT lits_ferme_id FROM lits_fermes WHERE service_ID = '$s' AND ('$d' BETWEEN debut AND fin
	OR '$f' BETWEEN debut AND fin)";
	$resultat = ExecRequete($requete,$connexion);
	$num_rows = mysql_num_rows($resultat);
	return($num_rows != 0);
}

$today = mktime();//date courante

$nom = $_REQUEST['nom'];

$erreur = 0;

$_service = $_REQUEST['serviceID'];
if(!$_service) $erreur = 1;

$debut = fDate2unix($_REQUEST['date1']);
$fin = fDate2unix($_REQUEST['date2']);
if(!$debut) $erreur = 2;
//if($debut < $today) $erreur = 5;
if(!$fin) $erreur = 3;
if(($fin < aujourdhui()) || ($debut > $fin)) $erreur = 8;

$lits_fermes = $_REQUEST['nb'];
if(!$lits_fermes) $erreur = 4;
if($lits_fermes < 1) $erreur = 6;

if($_REQUEST['enregistrement'])
{
	/** c'est une mise à jour de l'enregistement */
	$requete="DELETE FROM lits_fermes WHERE lits_ferme_id = '$_REQUEST[enregistrement]'";
	$resultat = ExecRequete($requete,$connexion);
}
// si le variable enregistre existe alors c'est une maj. On détruit l'enregistrement précédant et on ne
// teste pas le chevauchement.
//elseif (chevauchement($debut,$fin,$_service,$connexion))
//	$erreur = 7;
// Il n'y a pas d'erreur
if($erreur==0)
{
	$requete = "INSERT INTO lits_fermes VALUES('','$_service','$debut','$fin','$lits_fermes','$today')";
	$resultat = ExecRequete($requete,$connexion);
	$last_insert = mysql_insert_id();
	//header("Location: lits_fermes_nouveau.php?enregistrement=$last_insert&nom=$nom");
	header("Location: lits_fermeture.php?enregistrement=$last_insert&nom=$nom");
	//print($requete);
}
/**
if($erreur != 0)
{
	$d = uDate2French($debut);
	$f = uDate2French($fin);
	header("Location:lits_fermes_nouveau.php?erreur=$erreur&_service=$_service&nom=$nom&debut=$d&fin=$f
		&lits_fermes=$lits_fermes");
}
else
	header("Location: service_fermeture.php");
*/
print($erreur."<br>");
print($requete."<br>");
print($fin."<br>".$debut."<br>".$today);
?>
