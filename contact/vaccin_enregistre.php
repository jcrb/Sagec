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
/**
//	programme: 		vaccin_enregistre.php
//	date de création: 	28/09/2006
//	auteur:			jcb
//	description:		service à modifier
//	version:			1.0
//	maj le:			28/09/2006
*/
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

$date_u = fDate2unix($_GET[date]);// date française en timestamp unix

if($_GET['type']==0)
{	// existe il un doublon ?
	$requete = "SELECT vaccination_ID FROM vaccination WHERE personne_ID = '$_GET[personne_id]'
			AND date = '$date_u'
			AND dose = '$_GET[dose]'
			AND nom = '$_GET[nom]'
			AND vaccin_type_ID = '$_GET[nature]'
			";
	$resultat = ExecRequete($requete,$connexion);
	$num_rows = mysql_num_rows($resultat);
	if($num_rows == 0)
	{
		$requete = "INSERT INTO vaccination VALUES(
		'',
		'$_GET[personne_id]',
		'$_GET[nature]',
		'$date_u',
		'$_GET[dose]',
		'$_GET[nom]'
		)";
		$resultat = ExecRequete($requete,$connexion);
	}
}
else if($_GET['type']==1) //maj
{
	$requete = "UPDATE vaccination SET
				vaccin_type_ID = '$_GET[nature]',
				date = '$date_u',
				dose = '$_GET[dose]',
				nom = '$_GET[nom]'
			WHERE vaccination_ID = '$_GET[enregistrement]'";
	$resultat = ExecRequete($requete,$connexion);
}
$f=fopen('test.txt','w');
fwrite($f,$requete);
fclose($f);
//print($requete);
//header("Location: contact_saisie.php");
?>
