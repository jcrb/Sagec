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
/** 
  *	victimes2xml.php
  * 	enregistre les données du dernier évènement courant dans le fichier administrateur/sauvegarde
  *	date de création: 	10/11/2004		 
  *	@author:			jcb		  
  *	@version:			1.1	- $Id: sauvegarde.php 10 2006-08-17 22:41:56Z jcb $	 
  *	maj le:				11/12/2010	
  * 	@TODO: vérifier si tout est sauvegardé 
  *	@package			sagec
  */
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

$backPathToRoot = "../";
include_once($backPathToRoot."dbConnection.php");
require $backPathToRoot.'utilitaires/requete.php';

function get_victimes()
{
	global $connexion;
	$requete = "SELECT * FROM victime";
	$resultat = ExecRequete($requete,$connexion);
	$msg = "<SAGEC_XML>\r\n";
	while($rub=mysql_fetch_array($resultat))
	{
		$msg .= "<VICTIME>\r\n";
			$msg .= "<ID>".$rub[victime_ID]."</ID>\r\n";
			$msg .= "<Identifiant>".$rub[no_ordre]."</Identifiant>\r\n";
			$msg .= "<Nom>".$rub[nom]."</Nom>\r\n";
			$msg .= "<Prenom>".$rub[prenom]."</Prenom>\r\n";
			$msg .= "<Sexe>".$rub[sexe]."</Sexe>\r\n";
			$msg .= "<Age1>".$rub[age1]."</Age1>\r\n";
			$msg .= "<Age2>".$rub[age2]."</Age2>\r\n";
			$msg .= "<Gravite>".$rub[gravite]."</Gravite>\r\n";
			$msg .= "<heure_creation>".$rub[heure_creation]."</heure_creation>\r\n";
			$msg .= "<heure_maj>".$rub[heure_maj]."</heure_maj>\r\n";
			$msg .= "<localisation_ID>".$rub[localisation_ID]."</localisation_ID>\r\n";
			$msg .= "<hopital_ID>".$rub[hopital_ID]."</hopital_ID>\r\n";
			$msg .= "<hopital_finess>".$rub[finess]."</hopital_finess>\r\n";
			$msg .= "<hopital_nom>".$rub[hopital_ID]."</hopital_nom>\r\n";
			$msg .= "<service_ID>".$rub[service_ID]."</service_ID>\r\n";
			$msg .= "<service_nom>".$rub[service_nom]."</service_nom>\r\n";	
			$msg .= "<Lesions>".$rub[lesions]."</Lesions>\r\n";	
			$msg .= "<traitements>".$rub[traitement]."</traitements>\r\n";
			$msg .= "<constantes>".$rub[constantes]."</constantes>\r\n";
			$msg .= "<comment>".$rub[comment]."</comment>\r\n";
			
		$msg .= "</VICTIME>\r\n";
	}
	$msg .= "</SAGEC_XML>\r\n";
	
	//$msg="en cours";

	return $msg;
}

function test()
{
	$msg = get_victimes();
	$fp = fopen("victimes.xml", 'w');
	fputs($fp, $msg);
	fclose($fp);
        
	echo 'Export XML effectue !<br><a href="victimes.xml">Voir le fichier</a>';
}

//test();
?>
