<?php
//----------------------------------------- SAGEC ------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//----------------------------------------- SAGEC ------------------------------
/**
*	programme: 		uf_enregistre.php
*	description:	gestion des UF
*	date de création: 	17/02/2008
*	@author:			jcb
*	@version:		$Id: uf_enregistre.php 41 2008-03-08 14:36:50Z jcb $
*	maj le:			
*/
//------------------------------------------------------------------------------
//
session_start();
$backPathToRoot = "../";
if(! $_SESSION['auto_sagec'])header("Location:../logout.php");
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
require("uf_utilitaires.php");

if($_REQUEST['BtnSubmit'] == 'Valider' && $_REQUEST['id'] != 0)
{
	/** c'est une mise à jour */
	$uf = Security::esc2Db(strtoupper($_REQUEST['nom']));
	$code = Security::esc2Db(strtoupper($_REQUEST['code']));
	$age_min = Security::esc2Db(strtoupper($_REQUEST['agemin']));
	$age_max = Security::esc2Db(strtoupper($_REQUEST['agemax']));
	$etage = Security::esc2Db(strtoupper($_REQUEST['etage']));
	$urgence = Security::esc2Db(strtoupper($_REQUEST['urg']));
	
	$requete = "UPDATE uf SET
					uf_nom = '$uf',
					uf_code = '$code',
					uf_ouverte = '$_REQUEST[ufOuverte]',
					service_ID = '$_REQUEST[service_id]',
					pole_ID = '$_REQUEST[pole_id]',
					Hop_ID = '$_REQUEST[hopital_id]',
					org_ID = '$_REQUEST[organisme_id]',
					uf_invs_ID = '$_REQUEST[invs_id]',
					uf_activite_ID= '$_REQUEST[activite_id]',
					uf_discipline_ID = '$_REQUEST[discipline_id]',
					uf_division_ID= '$_REQUEST[division_id]',
					uf_age_ID= '$_REQUEST[age_id]',
					uf_age_min= '$age_min',
					uf_age_max= '$age_max',
					uf_etage = '$etage',
					batiment_ID = '$_REQUEST[batiment_id]',
					site_ID = '$_REQUEST[site_id]',
					uf_urgence = $urgence
					WHERE uf_ID = '$_REQUEST[id]'";

	$resultat = ExecRequete($requete,$connexion);
	//print($requete);
	
}
else
{
	/** c'est une création */
	
}
	
//print($requete);
header("Location:uf_create.php?ufID=$_REQUEST[id]");


?>
