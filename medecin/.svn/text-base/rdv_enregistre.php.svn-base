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
//	programme: 			rdv_enregistre.php
//	date de création: 	11/02/2006
//	auteur:				jcb
//	description:		Enregistre un RDV
//	version:			1.0
//	maj le:				11/02/2006
//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if($_GET['ok']=="annuler")
	header("Location:agenda.php?date=$_GET[date]&medid=$_GET[medid]");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require "../date.php";
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//
$identifiant = $_GET['id_rdv'];
//print("identifiant = ".$identifiant);
if($identifiant)
{
	$date_sql = fdate2usdate($_GET['date_rdv'])." ".$_GET['heure_rdv'].":00";
	//print($_GET['date_rdv']." ".$_GET['heure_rdv']." -- ".$date_sql);
	$requete = "UPDATE mg67_rdv SET
				nom = '$_GET[nom]',
				prenom = '$_GET[prenom]',
				tel = '$_GET[tel]',
				age = '$_GET[age]',
				motif = '$_GET[motif]',
				conclusion = '$_GET[diag]',
				date_rdv = '$date_sql'
				WHERE rdv_ID = '$identifiant'";
}
else
{
	$date_sql = uDate2MySql($_GET['date_rdv'])." ".$_GET['heure_rdv'];
	//print($_GET['date_rdv']." ".$_GET['heure_rdv']." -- ".$date_sql);
	$requete = "INSERT INTO mg67_rdv VALUES('',
								'$_GET[nom]',
								'$_GET[prenom]',
								'$_GET[tel]',
								'$_GET[age]',
								'$_GET[motif]',
								'$_GET[diag]',
								'$_GET[no_samu]',
								'$_GET[medid]',
								'$date_sql',
								'$_GET[date_fin_rdv]'
								)";
}
//print($requete);
$resultat = ExecRequete($requete,$connexion);
header("Location:agenda.php?date=$_GET[date]&medid=$_GET[medid]");
?>
