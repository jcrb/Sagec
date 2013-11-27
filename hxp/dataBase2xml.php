<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
//--------------------------------------------------------------------------------------------------------
/** dataBase2xml.php
* 	enregistre les donn�es du dernier �v�nement courant dans le fichier administrateur/sauvegarde
*	date de cr�ation: 	10/11/2004		 
*	@author:			jcb		  
*	@version:			1.1	- $Id: sauvegarde.php 10 2006-08-17 22:41:56Z jcb $	 
*	maj le:				14/08/2006	
* 	@TODO: v�rifier si tout est sauvegard� 
*	@package			sagec
*/
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require '../date.php';
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

function test()
{
	$date = fDatetime2unix("01/01/2007");
	$msg = veilleSamu2xml($date);
	$fp = fopen("veilleSamu.xml", 'w');
	fputs($fp, $msg);
	fclose($fp);
        
	echo 'Export XML effectue !<br><a href="veilleSamu.xml">Voir le fichier</a>';
	//echo 'Import XML effectue !<br><a href="xml2hospital.php">Voir le r�sultat</a>';
	
	// cr�ation d'un fichier compress�
	$zp = gzopen('test.gz', "w9");
	gzwrite($zp, $msg);
	gzclose($zp);
	
	/*
	// d�compression
	function uncompress($srcName, $dstName) {
		$string = implode("", gzfile($srcName));
		$fp = fopen($dstName, "w");
		fwrite($fp, $string, strlen($string));
		fclose($fp);
		}  
	}*/
}

/** transforme en XML les donn�es de la table veille_samu � partir d'une date donn�e
@param $date : date � patir de laquelle les donn�es sont r�cup�r�es
@return une chaine XML
*/
function veilleSamu2xml($date)
{
	global $connect;
	$requete = "SELECT * from veille_samu WHERE date > '$date'";
	$resultat = ExecRequete($requete,$connect);
	$msg="<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
	$msg .= "<data>";
	while($rub=mysql_fetch_array($resultat))
	{
		$msg .= "<newDay>\r\n"; 
			$msg .= "<date>$rub[date]</date>\r\n";
			$msg .= "<service>$rub[service_ID]</service>\r\n";
			$msg .= "<affaires>$rub[nb_affaires]</affaires>\r\n";
			$msg .= "<primaires>$rub[nb_primaires]</primaires>\r\n";
			$msg .= "<secondaires>$rub[nb_secondaires]</secondaires>\r\n";
			$msg .= "<neonat>$rub[nb_neonat]</neonat>\r\n";
			$msg .= "<tih>$rub[nb_tiih]</tih>\r\n";
			$msg .= "<apa>$rub[nb_apa]</apa>\r\n";
			$msg .= "<vsav>$rub[nb_vsav]</vsav>\r\n";
			$msg .= "<cons>$rub[conseils]</cons>\r\n";
			$msg .= "<med>$rub[nb_med]</med>\r\n";
		$msg .= "</newDay>";
	}
	$msg .= "</data>";
	return $msg;
}

test();

?>