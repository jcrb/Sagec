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
/**													
*	programme 			pds_garde_enregistre.php
*	@date de création: 	05/11/2006
*	@author:			jcb
*	description:		saisie des médecins de garde pour un secteur
*	@version:			1.0 - $ $
*	maj le:				05/11/2006
*	@package			Sagec
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require("../html.php");
require("../utilitairesHTML.php");
require("../date.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];
$secteur = $_REQUEST['secteur'];
$dr=$_REQUEST['dr'];

$n = sizeof($dr);
for($i=0;$i<$n;$i++)
{
	$date = $date1 + $i*un_jour;
	print($date)." ".$secteur." ".$dr[$i]."<br>";
	$requete = "SELECT garde_ID FROM mg67_garde WHERE secteur_pds_ID = '$secteur' AND date_debut='$date'";
	print($requete."<br>");
	$result = ExecRequete($query,$connexion);
	$rep = mysql_fetch_array($result);
	if($rep['garde_ID'])
	{
		$requete = "UPDATE mg67_garde SET med_ID='$dr[$i]' WHERE garde_ID = '$rep[garde_ID]'";
	}
	else
	{
		$requete = "INSERT INTO mg67_garde VALUES('','$dr[$i]','$secteur','$i',''";
	}
	ExecRequete($query,$connexion);
	print($requete."<br>");
}
?>