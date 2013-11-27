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
/** sau2xml.php
*	localhost/sagec3/hxp/sau2xml.php
* 	enregistre les données du dernier évènement courant dans le fichier administrateur/sauvegarde
*	date de création: 	10/11/2004		 
*	@author:			jcb		  
*	@version:			1.1	- $Id: sauvegarde.php 10 2006-08-17 22:41:56Z jcb $	 
*	maj le:				14/08/2006	
* 	@TODO: vérifier si tout est sauvegardé 
*	@package			sagec
*/
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

include('../utilitaires/table.php');
require '../utilitaires/globals_string_lang.php';
require('../pma_connect.php');
require('../pma_connexion.php');
require '../utilitaires/requete.php';
require('../date.php');
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

/**
*  récupère les données de la table veille_sau et les transforme en XML
*	@var date1: date initiale au format jj/mm/aaaa
*	@var date2: date finale au format jj/mm/aaaa
* 	@return un fichier XML
*/

function get_SAU_infos($date1,$date2)
{
	global $connect;
	$d1 = fDate2unix($date1);
	$d2 = fDate2unix($date2);

	$entete = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
	$msg=$entete;
	
	$msg .="<DATA_SAU>\r\n";
	$requete = "SELECT veille_sau.service_ID,date,inf_1_an,sup_75_an,entre1_75,hospitalise,uhcd,transfert,service_nom 
					FROM veille_sau,service 
					WHERE date BETWEEN '$d1' AND '$d2'
					AND veille_sau.service_ID = service.service_ID
					";
	$resultat = ExecRequete($requete,$connect);
	while($rub = mysql_fetch_array($resultat))
	{
		$msg .="<data>\r\n";
			$msg .="<service_id>$rub[service_ID]</service_id>\r\n";
			$msg .="<service_nom>$rub[service_nom]</service_nom>\r\n";
			$msg .="<date>$rub[date]</date>\r\n";
			$msg .="<inf_1_an>$rub[inf_1_an]</inf_1_an>\r\n";
			$msg .="<sup_75_an>$rub[sup_75_an]</sup_75_an>\r\n";
			$msg .="<entre1_75>$rub[entre1_75]</entre1_75>\r\n";
			$msg .="<hospitalise>$rub[hospitalise]</hospitalise>\r\n";
			$msg .="<uhcd>$rub[uhcd]</uhcd>\r\n";
			$msg .="<transfert>$rub[transfert]</transfert>\r\n";
		$msg .="</data>\r\n";
	}
	$msg .="</DATA_SAU>\r\n";
	return $msg;
}

function test_sau()
{
	$date1 = "19/10/2006";
	$date2 = $date1;
	$msg = get_SAU_infos($date1,$date2);
	$fp = fopen("hospital.xml", 'w');
	fputs($fp, $msg);
	fclose($fp);
        
	echo 'Export XML effectue !<br><a href="hospital.xml">Voir le fichier</a>';
	//echo 'Import XML effectue !<br><a href="xml2hospital.php">Voir le résultat</a>';
}

//test_sau();
?>
