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
//	programme: 		ars_deces_enregistre.php
//	date de création: 	23/03/2005
//	auteur:			jcb
//	description:		service à modifier
//	version:			1.1
//	maj le:			20/06/2005
//
//--------------------------------------------------------------------------------------------------------
/** Variables transmises
*@param $debut date de début de la fermeture
*@param $fin date de fin de la fermeture
*@param $lits_fermes nombre de lits fermés
*/
//--------------------------------------------------------------------------------------------------------
session_start();
if(!$_SESSION['auto_hopital'])header("Location:logout.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
include_once($backPathToRoot."login/init_security.php");
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."date.php");

$date=strtotime($_REQUEST[date]);
// vérifie si enregistrement existe déjà
$requete = "SELECT veille_dg_ID FROM veille_dg WHERE date = '$date'AND org_ID = '$_SESSION[organisation]'";
$resultat = ExecRequete($requete,$connexion);
$rub = mysql_fetch_array($resultat);
$id = $rub['veille_dg_ID'];
if($rub['veille_dg_ID'] == 0)
{
	$requete = "INSERT INTO veille_dg VALUES('',
			'$date',
			'$_REQUEST[nb_deces]',
			'$_REQUEST[nb_deces_75an]',
			'$_SESSION[organisation]',
			'$_SESSION[member_id]'
			)";
	$resultat = ExecRequete($requete,$connexion);
	$id = mysql_insert_id();
	$error = 0;
}
else
{
	$requete = "UPDATE veille_dg SET date = '$date',
				nb_tot_dcd = '$_REQUEST[nb_deces]',
				nb_dcd_sup75 = '$_REQUEST[nb_deces_75an]',
				org_ID = '$_SESSION[organisation]',
				ID_utilisateur = '$_SESSION[member_id]'
				WHERE veille_dg_ID = '$id'
	";
	$resultat = ExecRequete($requete,$connexion);
}
header("Location: ars_deces.php?enregistrement=$id");
?>
