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
//---------------------------------------------------------------------------------------------------------
/**
* 	
*	@programme 		analyse_reanimation.php
*	@date de création: 	01/03/2007
*	@author jcb
*	@version $Id$
*	@update le 01/03/2007
*	@version 1.0
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../date.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$today = today();
//$today = fDate2unix("01/07/2008");
$todayMoins30 = $today - 60*60*24*30;

$values = array();
$requete = "SELECT SUM(lits_journal.lits_dispo),DATE_FORMAT(FROM_UNIXTIME(lits_journal.date),'%e/%m') AS date
				FROM lits_journal,service,hopital,adresse,ville
				WHERE lits_journal.date BETWEEN '$todayMoins30' AND '$today'
				AND lits_journal.service_ID = service.service_ID	
				AND service.Type_ID = 2
				AND service.Hop_ID = hopital.Hop_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID = 67
				GROUP BY 2
				ORDER BY date
				";
$requete = "SELECT SUM(lits_journal.lits_dispo),DATE_FORMAT(FROM_UNIXTIME(lits_journal.date),'%e/%m'),date
				FROM lits_journal
				WHERE lits_journal.date BETWEEN '$todayMoins30' AND '$today'
				AND lits_journal.service_ID = '1'	
				GROUP BY date
				ORDER BY date ASC
				";
				print($requete.'<br>');
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	//print($rub[1].'   '.$rub[0].'<br>');
	$values[] = $rub[0];
	$date[] = $rub[1];
	print($rub[1]." -> ".$rub[0]."<br>");
}
//
$data = urlencode(serialize($values));
$dates = urlencode(serialize($date));
$titre = "Lits de Réanimation\n dans le Bas-Rhin (30 jours)";
print("<div><img src=\"graphe_rea.php?values=$data&titre=$titre&date=$dates\" alt=\"image\" /></div>");	
//header("Location:graphe_rea.php?values=$data");		
?>
