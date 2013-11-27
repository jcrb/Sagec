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
//
//	programme: 		constantes_enregistre.php
//	date de cr?ation: 	2005
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			2005
//
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
//====================== Corps =======================================

$dossier = Security::esc2Db(strtoupper($_REQUEST['dossier']));
$date = Security::esc2Db($_REQUEST['date'])."  ".Security::esc2Db($_REQUEST['heure']);
$fc = Security::esc2Db($_REQUEST['fc']);
$pas = Security::esc2Db($_REQUEST['pas']);
$pad = Security::esc2Db($_REQUEST['pad']);
$fr = Security::esc2Db($_REQUEST['fr']);
$sao2 = Security::esc2Db($_REQUEST['sao2']);
$etco2 = Security::esc2Db($_REQUEST['etco2']);
$diurese = Security::esc2Db($_REQUEST['diurese']);
$gly = Security::esc2Db($_REQUEST['gly']);
$glasgow = Security::esc2Db($_REQUEST['glasgow']);
$temp = Security::esc2Db($_REQUEST['temp']);

if($dossier != "")
{

	$date = strtotime($_GET['date']." ".$_GET['heure']);//retourne le timestamp
	
	if($fc){
		$requete = "INSERT INTO dm_constantes2 VALUES('$dossier','$date','1','$fc','$qui')";
		$resultat = ExecRequete($requete,$connexion);
	}
	if($pas){
		$requete = "INSERT INTO dm_constantes2 VALUES('$dossier','$date','2','$pas','$qui')";
		$resultat = ExecRequete($requete,$connexion);
	}
	if($pad){
		$requete = "INSERT INTO dm_constantes2 VALUES('$dossier','$date','3','$pad','$qui')";
		$resultat = ExecRequete($requete,$connexion);
	}
	if($fr){
		$requete = "INSERT INTO dm_constantes2 VALUES('$dossier','$date','4','$fr','$qui')";
		$resultat = ExecRequete($requete,$connexion);
	}
	if($sao2){
		$requete = "INSERT INTO dm_constantes2 VALUES('$dossier','$date','5','$sao2','$qui')";
		$resultat = ExecRequete($requete,$connexion);
	}
	if($etco2){
		$requete = "INSERT INTO dm_constantes2 VALUES('$dossier','$date','6','$etco2','$qui')";
		$resultat = ExecRequete($requete,$connexion);
	}
	if($diurese){
		$requete = "INSERT INTO dm_constantes2 VALUES('$dossier','$date','7','$diurese','$qui')";
		$resultat = ExecRequete($requete,$connexion);
	}
	if($gly){
		$requete = "INSERT INTO dm_constantes2 VALUES('$dossier','$date','8','$gly','$qui')";
		$resultat = ExecRequete($requete,$connexion);
	}
	if($glasgow){
		$requete = "INSERT INTO dm_constantes2 VALUES('$dossier','$date','9','$glasgow','$qui')";
		$resultat = ExecRequete($requete,$connexion);
	}
	if($temp){
		$requete = "INSERT INTO dm_constantes2 VALUES('$dossier','$date','10','$temp','$qui')";
		$resultat = ExecRequete($requete,$connexion);
	}
	header("Location:constantes.php");
	//print($requete);
}
?>
