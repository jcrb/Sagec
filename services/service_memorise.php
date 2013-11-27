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
//----------------------------------------- SAGEC --------------------------------------------------------
//													//
//	programme: 		service_memorise.php							//
//	date de création: 	20/04/2004								//
//	auteur:			jcb									//
//	description:		Enregistre les modifications du nombre de lits disponibles		//
//	version:		1.3									//
//	maj le:			13/08/2005								//
//													//
//---------------------------------------------------------------------------------------------------------
session_start();
if(!($_SESSION['auto_hopital']||$_SESSION['auto_service']||$_SESSION['auto_organisme']))header("Location:../logout.php");

require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$date_maj = time();

if($_POST['ok_lits'])
{
	$lits_occ =  $_POST['lits_sp'] - $_POST['lits_dispo'];
	//$lits_dispo = $_POST['lits_sp'] + $_POST['lits_supp'] - $lits_occ - $lits_cata;

	$requete = "UPDATE lits SET
				lits_sp = '$_POST[lits_sp]',
				lits_supp = '$_POST[lits_supp]',
				lits_occ = '$lits_occ',
				lits_liberable = '$_POST[lits_liberable]',
				lits_dispo = '$_POST[lits_dispo]',
				lits_respi = '$_POST[lits_respi]',
				date_maj = '$date_maj',
				lits_pneg = '$_POST[lits_pneg]',
				lits_installe = '$_POST[lits_installe]',
				lits_ferme = '$_POST[lits_ferme]',
				lits_reserve = '$_POST[lits_reserve]',
				lit_spe1 = '$_POST[lit_spe1]',
				lit_spe2 = '$_POST[lit_spe2]',
				lit_spe3 = '$_POST[lit_spe3]',
				lit_spe4 = '$_POST[lit_spe4]',
				lit_spe5 = '$_POST[lit_spe5]',
				lit_spe6 = '$_POST[lit_spe6]',
				lit_spe7 = '$_POST[lit_spe7]',
				places_auto = '$_POST[places_auto]',
				places_dispo = '$_POST[places_dispo]'
		WHERE service_ID = '$_POST[service_ID]'";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete."<br>\n");
	$requete="INSERT INTO lits_journal VALUES('$date_maj','$_POST[service_ID]','$_POST[lits_dispo]','$_SESSION[member_id]')";
	$resultat = ExecRequete($requete,$connexion);
	if($_POST['places_auto']>0)
	{
		$requete="INSERT INTO places_journal VALUES('$date_maj','$_POST[service_ID]','$_POST[places_dispo]','$_SESSION[member_id]')";
		$resultat = ExecRequete($requete,$connexion);
	}
	header("Location:service_modifie.php?service=$_POST[service_ID]&type=$_POST[service_type]");
}
else
{
	$requete = "UPDATE service SET
			service_code = '$_POST[code]',
			service_tel = '$_POST[tel]',
			service_fax = '$_POST[fax]',
			service_batiment = '$_POST[batiment]',
			service_etage = '$_POST[etage]',
			service_adulte = '$_POST[adulte]',
			service_enfant = '$_POST[enfant]',
			age_min = '$_POST[age_enfant]'
		WHERE service_ID = '$_POST[service_ID]'";
	//print($requete."<br>\n");
	$resultat = ExecRequete($requete,$connexion);
	header("Location:service_info.php?service=$_POST[service_ID]&type=$_POST[service_type]");
}

?>
