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
//	programme: 		passage_sau_enregistre.php
//	date de création: 	23/03/2005
//	auteur:			jcb
//	description:		service à modifier
//	version:			1.1
//	maj le:			23/07/2005
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
if($_SESSION['member_id']==0)header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../../pma_connect.php");
require("../../pma_connexion.php");
require("../../pma_requete.php");
require("../../date.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//
$date=strtotime($_GET[date]);
//
	// vérifie si enregistrement existe déjà
	// 23/7/05 remplacement de $_SESSION[service] par $_GET[service]
	$requete = "SELECT veille_ID FROM veille_sau WHERE date = '$date'AND service_ID = '$_GET[service]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	$id = $rub['veille_ID'];
//
// suppression
//
if($_REQUEST['ok']=="supprimer")
{
	$requete = "DELETE FROM veille_sau WHERE veille_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
}
//
// enregistrement
//
else
{

	//
	if($id == 0)
	{
	$requete = "INSERT INTO veille_sau VALUES('',
			'$_GET[service]',
			'$date',
			'$_GET[nb_1_an]',
			'$_GET[nb_75_an]',
			'$_GET[nb_1_a_75_an]',
			'$_GET[nb_hospitalise]',
			'$_GET[nb_uhcd]',
			'$_GET[nb_transferts]',
			'$_SESSION[member_id]'
			)";
	$resultat = ExecRequete($requete,$connexion);
	$id = mysql_insert_id();
	}
	else
	{
	$requete = "UPDATE veille_sau SET date = '$date',
				service_ID = '$_GET[service]',
				inf_1_an = '$_GET[nb_1_an]',
				sup_75_an = '$_GET[nb_75_an]',
				entre1_75 ='$_GET[nb_1_a_75_an]',
				hospitalise = '$_GET[nb_hospitalise]',
				uhcd = '$_GET[nb_uhcd]',
				transfert = '$_GET[nb_transferts]',
				ID_utilisateur = '$_SESSION[member_id]'
				WHERE veille_ID = '$id'
	";
	$resultat = ExecRequete($requete,$connexion);
	}
}
header("Location: passages_sau.php?service=$_GET[service]&enregistrement=$id");
?>
