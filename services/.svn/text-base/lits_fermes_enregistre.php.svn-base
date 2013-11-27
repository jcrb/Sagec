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

require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../date.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

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
$nom = $_GET['nom'];
$erreur = 0;
$_service = $_GET['_service'];
if(!$_service) $erreur = 1;
$debut = fDate2unix($_GET['debut']);
$fin = fDate2unix($_GET['fin']);
if(!$debut) $erreur = 2;
//if($debut < $today) $erreur = 5;
if(!$fin) $erreur = 3;
if(($fin < $today) || ($debut > $fin)) $erreur = 8;
$lits_fermes = $_GET['lits_fermes'];
if(!$lits_fermes) $erreur = 4;
if($lits_fermes < 1) $erreur = 6;
if($_GET['enregistrement'])
{
	$requete="DELETE FROM lits_fermes WHERE lits_ferme_id = '$_GET[enregistrement]'";
	$resultat = ExecRequete($requete,$connexion);
}
// si le variable enregistre existe alors c'est une maj. On détruit l'enregistrement précédant et on ne
// teste pas le chevauchement.
elseif (chevauchement($debut,$fin,$_service,$connexion))
	$erreur = 7;
// Il n'y a pas d'erreur
if($erreur==0)
{
	$requete = "INSERT INTO lits_fermes VALUES('','$_service','$debut','$fin','$lits_fermes','$today')";
	$resultat = ExecRequete($requete,$connexion);
	//$last_insert = mysql_insert_id();
	//print($requete);
}
if($erreur != 0)
{
	$d = uDate2French($debut);
	$f = uDate2French($fin);
	header("Location:lits_fermes_nouveau.php?erreur=$erreur&_service=$_service&nom=$nom&debut=$d&fin=$f
		&lits_fermes=$lits_fermes");
}
else
	header("Location: service_fermeture.php");
//print($erreur);
?>
