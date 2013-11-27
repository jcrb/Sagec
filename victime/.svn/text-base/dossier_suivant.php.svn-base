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
//----------------------------------------- SAGEC ---------------------------------------------
//
//	programme: 			dossier_suivant.php
//	date de création: 	11/02/2006
//	auteur:				jcb
//	description:		fait avancer ou reculer au dossier patient suivant/précédant
//	version:			1.0
//	maj le:				11/02/2006
//
//---------------------------------------------------------------------------------------------
require("../pma_requete.php");
require("../pma_connect.php");
require("../pma_connexion.php");
$connexion = connexion(NOM,PASSE,BASE,SERVEUR);
if($_GET['next']=='suivant')
	$requete="SELECT no_ordre FROM victime WHERE no_ordre > '$_GET[ordre]' ORDER BY no_ordre LIMIT 0,1";
else if($_GET['next']=='precedant')
	$requete="SELECT no_ordre FROM victime WHERE no_ordre < '$_GET[ordre]' ORDER BY no_ordre DESC LIMIT 0,1";
if($_GET['next']=='first')
	$requete="SELECT no_ordre FROM victime ORDER BY no_ordre ASC LIMIT 0,1";
if($_GET['next']=='last')
	$requete="SELECT no_ordre FROM victime ORDER BY no_ordre DESC LIMIT 0,1";
$resultat = ExecRequete($requete,$connexion);
$rub=mysql_fetch_array($resultat);
if(!$rub[0])
{
	$rub[0]=$_GET['ordre'];// on est au max
	if($_GET['next']=='suivant')
		$suite = 'stop+';
	$suite = 'stop-';
}
else $suite='encore';
//print($rub[0]);
header("Location:victime_saisie.php?identifiant=$rub[0]&suite=$suite");
?>