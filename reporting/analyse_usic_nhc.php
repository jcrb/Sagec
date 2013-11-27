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
*	@programme 		analyse_usic_nhc.php
*	Affiche la disponibilité de l'USIC du NHC au cours des 30 derniers jours
*	@date de création: 	26/06/2008
*	@author jcb
*	@version $Id$
*	@update le 26/06/2008
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
$today = fDatetime2unix('01/12/2008');
$todayMoins30 = date("Y-m-d",time()-60*60*24*300);
// Récupération des données
$values = array();
$values2 = array();
$commandeR = "";
$requete = "SELECT lits_occupes,lits_ouverts,lits_dispo,DATE_FORMAT(date,'%e/%m')AS dates
				FROM journal_uf
				WHERE uf_ID = 474
				AND date BETWEEN '$todayMoins30' AND '$today'
				ORDER BY date 
				LIMIT 30 
				";
$requete = "SELECT lits_occupes,lits_ouverts,lits_dispo,DATE_FORMAT(date,'%e/%m')AS dates
				FROM journal_uf
				WHERE uf_ID = 474
				ORDER BY date 
				LIMIT 30 
				";
$resultat = ExecRequete($requete,$connexion);

$commandeRdirecte = "R --no-save << END\n";
$commandeR = "options(echo = FALSE)\n";
$commandeR.='lits_dispo<-c(';
while($rub=mysql_fetch_array($resultat))
{
	$pourcent = 100*$rub[lits_occupes]/ $rub[lits_ouverts];
		if($pourcent > 100) $pourcent = 100;
	$values[] = $pourcent;
	$values2[] = $rub[lits_dispo];
	$commandeR.= $rub[lits_dispo].',';
	$date[] = $rub[dates];
}
print_r($value);
$commandeR = substr($commandeR, 0, -1);  // supprime la derniere virgule
$commandeR.= ")\n";
$commandeR.= "summary(lits_dispo)\n";
$commandeR.= "print('variance: ');";
$commandeR.= "var(lits_dispo)\n";
$commandeR.= "boxplot(lits_dispo, main=\"Boxplot\", xlab=\"Lits de réa\")\n";
$commandeR.="q(runLast=FALSE)\n";
$fp=fopen("data.txt","w");
fwrite($fp,$commandeR);
fclose($fp);
// méthode indirecte (fichier)
echo exec('R CMD BATCH --slave "data.txt" "result.txt" ');

// méthode directe par flux
exec($commandeRdirecte.$commandeR, $reponse);
print("Réponse méthode directe.<br>");
foreach($reponse as $value)
{
	print("  ".$value."<br>");
}
print_r($reponse);

// méthode indirecte
print("<br>Réponse méthode indirecte.<br>");
$fp=fopen("result.txt","r");
print("<table border=\"1\">");
while($msg = fgets($fp))
{
	$val = explode("\t",$msg);
	print("<tr>");
	for($i=0;$i<sizeof($val);$i++)
	{
		print("<td>$val[$i]</td>");
	}
	print("</tr>");
}
print("</table>");
fclose($fp);

//Affichage graphique 
print("<table>");
	print("<tr>");
		// Affichage graphique
		$data = urlencode(serialize($values));
		$data2 = urlencode(serialize($values2));
		$dates = urlencode(serialize($date));
		$titre = "Occupation Lits USIC NHC (30 derniers jours)";
		print("<td>");		
			print("<div><img src=\"graphe_rea.php?values=$data&titre=$titre&date=$dates&mode=pc\" alt=\"image\" /></div>");
		print("</td>");
	print("<tr>");
		print("<td>");
			print("<div><img src=\"graphe_rea.php?values=$data2&titre=$titre&date=$dates\" alt=\"image2\" /></div>");
		print("</td>");
	print("</tr>");
print("</table>");
//header("Location:graphe_rea.php?values=$data");
exec(" convert Rplots.ps -rotate 90 boxplot.jpg");

?>
<img src="boxplot.jpg" alt="graphe"/>