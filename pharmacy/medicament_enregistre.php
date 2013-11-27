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
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
//
// nouveau médicament
// vérifie qu'il n'existe pas
/*
$requete1="SELECT medic_ID FROM medicament WHERE medic_nom = '$_REQUEST[ID_special]'
								AND medic_dci = '$_REQUEST[ID_dci]'
								AND medic_presentation = '$_REQUEST[present]'
								AND medic_dosage = '$_REQUEST[poso]'
								AND medic_volume = '$_REQUEST[volume]'
								";
$resultat1 = ExecRequete($requete1,$connexion);
if(!$rub=mysql_fetch_array($resultat1))
*/

print_r($_REQUEST);
print('<br>');

$maj = 0;
if($_REQUEST['volume']==0)
		$unite_vol="3";
	else
		$unite_vol=$_REQUEST['ml'];

if(!$_REQUEST['maj'])
{
	/* renseigner la table med_specialité et récupérer un identifiant */
	$requete = "INSERT INTO med_specialite VALUES('','$_REQUEST[specialite]',1)";
				$resultat = ExecRequete($requete,$connexion);
				print($requete."<br>");
				$ID_special = mysql_insert_id();
	
	$requete="INSERT INTO medicament VALUES('',
								'$ID_special',
								'$_REQUEST[ID_dci]',
								'$_REQUEST[present]',
								'$_REQUEST[poso]',
								'$_REQUEST[mg]',
								'$_REQUEST[volume]',
								'$unite_vol'
								)";
	$resultat = ExecRequete($requete,$connexion);
	print($requete."<br>");
	$maj = mysql_insert_id();

	// enregistrement des familles
	$f=$_REQUEST[ID_famille];
	for($i=0; $i<count($f);$i++)
	{
		$famille=$f[$i];
		if($famille != 0)
		{
			$requete="INSERT INTO medicament_med_famille VALUES('$famille','$_REQUEST[ID_special]')";
			print($requete."<br>");
			//$resultat = ExecRequete($requete,$connexion);
		}
	}
}
else // sinon c'est un update
{
	echo 'update';
	$requete = "UPDATE medicament SET 	medic_nom = '$_REQUEST[ID_special]',
								medic_dci = '$_REQUEST[ID_dci]',
								medic_presentation = '$_REQUEST[present]',
								medic_dosage = '$_REQUEST[poso]',
								medic_dosage_unite = '$_REQUEST[mg]',
								medic_volume = '$_REQUEST[volume]',
								medic_volume_unite = '$unite_vol'
							WHERE medic_ID = '$_REQUEST[maj]'";
	$resultat = ExecRequete($requete,$connexion);
	print($requete."<br>");
	$maj = $_REQUEST['maj'];

	// enregistrement des familles
	// on efface les enregistrements correspondant au médicament
	$requete="DELETE FROM medicament_med_famille WHERE medic_ID = '$_REQUEST[ID_special]'";
	print($requete."<br>");
	$resultat = ExecRequete($requete,$connexion);
	
	// on remplace
	$f=$_REQUEST['ID_famille'];
	for($i=0; $i<count($f);$i++)
	{
		$famille=$f[$i];
		if($famille != 0)
		{
			$requete="INSERT INTO medicament_med_famille VALUES('$famille','$_REQUEST[ID_special]')";
			print($requete."<br>");
			$resultat = ExecRequete($requete,$connexion);
		}
	}
}
//

//print($requete."<br>");
//header("Location:medicament_fiche.php?medicament=$maj");
//header("Location:med_liste.php");
?>
