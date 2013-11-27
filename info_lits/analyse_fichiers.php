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
 * analyse_fichiers.php
 * analyse des fichiers présents dans le répertoire sagec_echange
 * @package Sagec
 * @version $Id: analyse_fichiers.php 34 2008-02-19 06:42:06Z jcb $
 * @author JCB
 * @date: 20/09/2007
 */											
//---------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backpathToRoot="../";
if(! $_SESSION['auto_sagec'])header("Location:./../logout.php");
include_once("xml2UF.php");
require_once($backpathToRoot.'uf/uf_patch.php');

/** chemin d'accès au répertoire */

$path = $backpathToRoot."sagec_echange/statistiques/";
$dir = opendir($path);
/** nombre de fichiers lus */
$n = 0;

print("test");
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
print("<br>".$n." fichiers traités<br>");

// mise à jour du dossier $path
detruit_fichier($path);
//
$msg= date("d/m/Y H:i:s")." dossiers SAGAH traités";
if(patche()) $msg.= "<br>USIC patche";
send_Mail($msg);

/**
*	Analyse les fichiers provenant de SAGAH
*	@param[in] $f chemin d'accès au fichier
*/
function traite_fichier($f)
{
	global $path;
	$msg = "<br>";
	$msg .= "nom: ".$f."<br>";
	$msg .= "taille: ".filesize($path.$f)." octets<br>";
	$msg .= "création: ".dd(filectime($path.$f))."<br>";
	$msg .= "modification: ".dd(filemtime($path.$f))."<br>";
	$msg .= "accès: ".dd(fileatime($path.$f))."<br>";
	$msg .= "<br>";
	//print($msg);

	$entete = substr($f, 0, 3);
	switch($entete){
		case 'ARH': parse_file($f);break;
	}
	enregistre($msg, 'parse');
}

/**
* met à jour le fichier log
*/
function enregistre($msg, $action)
{
	$fp = fopen('log_sagah.txt','a');
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
	rename($path.$f ,"OLD_".$path.$f);
}

/**
*	Détruit les fichiers vieux de plus de sept jours
*/
function detruit_fichier($path)
{
	$semaine = 7*24*3600;
	//$date = dd(time()-$semaine);// date unix
	$date = time()-$semaine;// date unix
	print("date = ".dd($date)."<br>");
	$date_limite = mktime  (0,0,0,12,11,2007); // ne pas effacer ce qui est < au 11/12/2007 à 0H
	print("datelimite = ".dd($date_limite)."<br>");
	$dir = opendir($path);
	/** nombre de fichiers lus */
	$n = 0;
	/** lecture du répertoire */
	while($f = readdir($dir))
	{
		if(is_file($path.$f))
		{
			$delete_file = $path.$f;
			print($delete_file."  ");
			//$date_fichier = dd(filemtime($path.$f));
			$date_fichier = filemtime($delete_file);// date unix
			print("date_fichier = ".dd($date_fichier));
			if($date_fichier < $date && $date_fichier > $date_limite)
			{
				print(realpath($delete_file)."<br>");
				if(unlink(realpath($delete_file)))
				{
					enregistre($f, 'delete');
					$n++;
					print(" fichier effacé<br>");
				}
				else print(" fichier non effacé<br>");
			}
			else print(" fichier non effacé<br>");
		}
	}
}

/**
*	Envoie un mail concernant les fichiers traités
*	@param[in] $msg message d'information
*/
function send_Mail($msg)
{
	$destinataire = "jcbartier@orange.fr\n";
	$sujet = "Sagec_echange a ete modifié\n";
	$entetes = "From: jcb-bartier@wanadoo.fr \n";
	$entetes .= "Content-type:text/html \n";
	$rep = mail($destinataire, $sujet,$msg,$entetes);
	print($rep);
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
</body>