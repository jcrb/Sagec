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
//	programme: 		medicament_enregistre.php
//	date de création: 	15/10/2004
//	auteur:			jcb
//	description:		enregistre les caractéristiques d'un médicament
//	version:			1.0
//	maj le:			15/10/2004
//
//--------------------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//
// nouveau médicament
// vérifie qu'il n'existe pas
/*
$requete1="SELECT medic_ID FROM medicament WHERE medic_nom = '$_GET[ID_special]'
								AND medic_dci = '$_GET[ID_dci]'
								AND medic_presentation = '$_GET[present]'
								AND medic_dosage = '$_GET[poso]'
								AND medic_volume = '$_GET[volume]'
								";
$resultat1 = ExecRequete($requete1,$connexion);
if(!$rub=mysql_fetch_array($resultat1))
*/
$maj = 0;
if($_GET['volume']==0)
		$unite_vol="3";
	else
		$unite_vol=$_GET['ml'];

if(!$_GET['maj'])
{
	$requete="INSERT INTO medicament VALUES('',
								'$_GET[ID_special]',
								'$_GET[ID_dci]',
								'$_GET[present]',
								'$_GET[poso]',
								'$_GET[mg]',
								'$_GET[volume]',
								'$unite_vol'
								)";
	$resultat = ExecRequete($requete,$connexion);
	$maj = mysql_insert_id();

	// enregistrement des familles
	$f=$_GET[ID_famille];
	for($i=0; $i<count($f);$i++)
	{
		$famille=$f[$i];
		if($famille != 0)
		{
			$requete="INSERT INTO medicament_med_famille VALUES('$famille','$_GET[ID_special]')";
			$resultat = ExecRequete($requete,$connexion);
		}
	}
}
else // sinon c'est un update
{
	$requete = "UPDATE medicament SET 	medic_nom = '$_GET[ID_special]',
								medic_dci = '$_GET[ID_dci]',
								medic_presentation = '$_GET[present]',
								medic_dosage = '$_GET[poso]',
								medic_dosage_unite = '$_GET[mg]',
								medic_volume = '$_GET[volume]',
								medic_volume_unite = '$unite_vol'
							WHERE medic_ID = '$_GET[maj]'";
	$resultat = ExecRequete($requete,$connexion);
	$maj = $_GET['maj'];

	// enregistrement des familles
	// on efface les enregistrements correspondant au médicament
	$requete="DELETE FROM medicament_med_famille WHERE medic_ID = '$_GET[ID_special]'";
	$resultat = ExecRequete($requete,$connexion);
	// on remplace
	$f=$_GET['ID_famille'];
	for($i=0; $i<count($f);$i++)
	{
		$famille=$f[$i];
		if($famille != 0)
		{
			$requete="INSERT INTO medicament_med_famille VALUES('$famille','$_GET[ID_special]')";
			$resultat = ExecRequete($requete,$connexion);
		}
	}
}
//
//print($requete1."<br>");
//print($requete."<br>");
//header("Location:medicament_fiche.php?medicament=$maj");
header("Location:med_liste.php");
?>
