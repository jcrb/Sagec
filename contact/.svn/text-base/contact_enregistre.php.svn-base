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
//	programme: 		contact_enregistre.php
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

if($_GET['type']==0)
{	// existe il un doublon ?
	$requete = "SELECT contact_ID FROM contact WHERE identifiant_contact = '$_GET[personne_id]'
			AND type_contact_ID = '$_GET[type_contact]'
			AND nature_contact_ID = '$_GET[nature]'
			AND contact_lieu = '$_GET[lieu_contact]'
			AND confidentialite_ID = '$_GET[confidentialite]'
			AND valeur = '$_GET[value]'
			AND contact_nom = '$_GET[nom]'
			";
	$resultat = ExecRequete($requete,$connexion);
	$num_rows = mysql_num_rows($resultat);
	if($num_rows == 0)
	{
		$requete = "INSERT INTO contact VALUES(
		'',
		'$_GET[type_contact]',
		'$_GET[nature]',
		'$_GET[personne_id]',
		'',
		'$_GET[confidentialite]',
		'',
		'$_GET[value]',
		'$_GET[lieu_contact]',
		'$_GET[nom]'
		)";
		$resultat = ExecRequete($requete,$connexion);
	}
}
else if($_GET['type']==1) //maj
{
	$requete = "UPDATE contact SET
				type_contact_ID = '$_GET[type_contact]',
				nature_contact_ID = '$_GET[nature]',
				contact_lieu = '$_GET[lieu_contact]',
				confidentialite_ID = '$_GET[confidentialite]',
				valeur = '$_GET[value]',
				contact_nom = '$_GET[nom]'
			WHERE contact_ID = '$_GET[enregistrement]'";
	$resultat = ExecRequete($requete,$connexion);
}
$f=fopen('test.txt','w');
fwrite($f,$requete);
fclose($f);
//print($requete);
//header("Location: contact_saisie.php");
?>
