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
/**
//	programme: 		graphe_veille_samu2.php Utilise PHPlot
//	date de création: 	03/02/2007
//	@author:			jcb
//	description:		Graphe de tendance de l'activité du SAMU
//	@version $Id$
//	maj le:			03/02/2007
* 	@package Sagec
*/
//-----------------------------------------------------------------------------
session_start();
//ini_set('display_errors','1');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once "../classe_dessin.php";
require_once("../date.php");
require_once("../phplot/phplot.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//données récupérées
if(isset($_REQUEST['affaire'])) $affaire = true;
if(isset($_REQUEST['assu'])) $assu = true;
if(isset($_REQUEST['primaire'])) $primaire = true;
if(isset($_REQUEST['vsav'])) $vsav = true;
if(isset($_REQUEST['secondaire'])) $secondaire = true;
if(isset($_REQUEST['cons'])) $cons = true;
if(isset($_REQUEST['neonat'])) $neonat = true;
if(isset($_REQUEST['tiih'])) $tiih = true;
if(isset($_REQUEST['med'])) $med = true;
if(isset($_REQUEST['moyenne'])) $moy = true;
if(isset($_REQUEST['moyenne_lisse'])) $moylisse = true;
if(isset($_REQUEST['ecart_type'])) $sd = true;
if(isset($_REQUEST['valeur'])) $valeur = true;
if(isset($_REQUEST['samu67'])) $samu67 = 111;// code 111
if(isset($_REQUEST['samu68'])) $samu68 = 152;//
$date1 = fDate2unix($_REQUEST['date1']);
$date2 = fDate2unix($_REQUEST['date2']);
$plissage = $_REQUEST['jour'];// paramètre de lissage

// requete

$requete="SELECT date";
$item = "date";
if(isset($affaire))
{
	$requete .= ",nb_affaires";
	$item .= ",affaires";
}
if(isset($primaire))
{
	$requete .= ",nb_primaires";
	$item .= ",primaires";
}
if(isset($secondaire))
{
	$requete .= ",nb_secondaires";
	$item .= ",secondaires";
}
if(isset($cons))
{
	$requete .= ",conseils";
	$item .= ",conseils";
}
if(isset($vsav))
{
	$requete .= ",nb_vsav";
	$item .= ",vsav";
}
if(isset($assu))
{
	$requete .= ",nb_apa";
	$item .= ",assu";
}
if(isset($tiih))
{
	$requete .= ",nb_tiih";
	$item .= ",tiih";
}
if(isset($med))
{
	$requete .= ",nb_med";
	$item .= ",med";
}
if(isset($neonat))
{
	$requete .= ",nb_neonat";
	$item .= ",neonat";
}
//==========================================
$requete .= " FROM veille_samu WHERE ";
// ========================================= choix du département
if(isset($samu67) && ! isset($samu68))
{
	$requete .= "service_ID = '$samu67'";
	$service = $samu67;
}
elseif(!isset($samu67) && isset($samu68))
{
	$requete .= "service_ID = '$samu68'";
	$service = $samu68;
}
elseif(isset($samu67) && isset($samu68))
{
	$requete .= "service_ID IN( '$samu67','$samu68') ";
	$service = $samu67.$samu68;
}
//============================================
$requete .= " AND date BETWEEN '$date1' AND '$date2' ORDER BY date ASC";

//print($requete);

header("Location:dessine_graphe_veille_samu2.php?requete=$requete&item=$item&service=$service");
?>