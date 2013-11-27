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
/**
 * lanceur_rpu.php
 * déclenche l'analyse et le parsing des fichiers RPU contenus dans le dossier statistiques
 * @package Sagec
 * @version $Id: analyse_fichiers.php 34 2008-02-19 06:42:06Z jcb $
 * @author JCB
 * @date: 20/05/2009
 */											
//---------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backpathToRoot="../../";
if(! $_SESSION['auto_sagec'])header("Location:./../logout.php");
//include_once("xml2rpu.php");
include_once("rpu_xpath_enregistre.php");

/** chemin d'accès au répertoire */
$path = $backpathToRoot."sagec_echange/statistiques/";
$dir = opendir($path);
/** nombre de fichiers lus */
$n = 0;

/** 
* main: parcourt le répertoire $path à la recherche de fichiers à parser
* puis efface les fichiers vieux de plus de 8 jours
* et envoie un mail de confirmation
*/
while($f = readdir($dir))
{
	if(is_file($path.$f))
	{
		print("fichier lu ".$f."<br>");
		traite_fichier($f);
		$n++;
	}
}

/**
*	Analyse les fichiers provenant de SAGAH
*	@param[in] $f chemin d'accès au fichier
*/
function traite_fichier($f)
{
/*
	global $path;
	$msg = "<br>";
	$msg .= "nom: ".$f."<br>";
	$msg .= "taille: ".filesize($path.$f)." octets<br>";
	$msg .= "création: ".dd(filectime($path.$f))."<br>";
	$msg .= "modification: ".dd(filemtime($path.$f))."<br>";
	$msg .= "accès: ".dd(fileatime($path.$f))."<br>";
	$msg .= "<br>";
	print($msg);

	$entete = substr($f, 0, 3);
	switch($entete){
		case 'RPU': 
			parseRPU($f);
			renomme_file($f);
			break;
	}
	enregistre($msg, 'parse');
	*/
	parseRPU($f);
}

/**
* met à jour le fichier log
*/
function enregistre($msg, $action)
{
	$fp = fopen('log_rpu.txt','a');
	if($action == "parse")
	{
		$msg .= " [fichier parsé]\n";
	}
	else
	{
		$msg .= " [fichier détruit]\n";
	}
	fwrite($fp,$msg);
	fclose($fp);
}

/**
* Renomme un fichier pour qu'il ne soit pas lu deux fois
*/
function renomme_file($f)
{
	global $path;
	if(!rename($path.$f ,$path."OLD_".$f))
		print("echec renommage ".$path.$f." en ".$path."OLD_".$f);
	
}

function detruit_fichier($path)
{
}

/**
*	concersion de format de date
*	@param[in] $date date au format unix
*/
function dd($date)
{
	return date("d/m/Y H:i:s", $date);
}

?>