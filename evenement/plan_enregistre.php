<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------
//
/**	programme: 		plan_enregistre.php
//	date de création: 	12/11/2004
//	@author:			jcb
//	description:		Fonctionalité permise à l'administrateur
//	@version:			1.2 - $Id: plan_enregistre.php 10 2006-08-17 22:41:56Z jcb $
//	maj le:			14/10/2004
*	@package		Sagec
*/
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
// insertion
if($_GET[maj]=="")
{
	$requete = "INSERT INTO plan_courant VALUES('','$_GET[ID_evenement]','$_GET[ID_plan]','$_GET[titre]','$_GET[date1]','$_GET[date2]','$_GET[comment]')";
	$resultat = ExecRequete($requete,$connexion);
	$maj = mysql_insert_id();
}
else //update
{
	$requete = "UPDATE plan_courant SET
				evenement_ID = '$_SESSION[evenement]',
				plan_ID = '$_GET[ID_plan]',
				titre = '$_GET[titre]',
				evenement_ID = '$_GET[ID_evenement]',
				date1 = '$_GET[date1]',
				date2 = '$_GET[date2]',
				comment = '$_GET[comment]'
			WHERE plan_courant_ID = '$_GET[maj]'";
	$resultat = ExecRequete($requete,$connexion);
	$maj = $_GET[maj];
}
//print($requete);
header("Location:evenement_plan.php?maj=$maj");