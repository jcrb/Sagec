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
//
//----------------------------------------- SAGEC ---------------------------------------------//
//												//
//	programme: 		evenement_enregistre.php						//
//	date de création: 	02/05/2004							//
//	auteur:			jcb								//
//	description:		Enregistre / met à jour une tache				//
//	version:		1.0								//
//	maj le:			02/05/2004							//
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require($backPathToRoot."date.php");
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");

$titre = Security::esc2Db($_REQUEST[titre]);
$date1 = Security::esc2Db($_REQUEST[date]);
$heure = Security::esc2Db($_REQUEST[heure]);
$victime = Security::esc2Db($_REQUEST[victime]);
$dossier_samu = Security::esc2Db($_REQUEST[dossier_samu]);
$dossier_sdis = Security::esc2Db($_REQUEST[dossier_sdis]);

$date = date("Y-m-j H:i:s");

	$requete = "UPDATE evenement SET
		evenement_nom = '$titre',
		evenement_date1 = 'date1',
		evenement_heure1 = 'heure1',
		evenement_victime = '$victime',
		last_update = '$date',
		dossier_samu = '$dossier_samu',
		dossier_sdis = 'dossier_sdis'
		WHERE evenement_ID = '$_SESSION[evenement]'
		";
$resultat = ExecRequete($requete,$connexion);
//print($requete);
header("Location:evenement_courant.php");
?>
