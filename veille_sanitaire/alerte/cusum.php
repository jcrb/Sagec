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
* 	alertes sanitaires
*	@programme 		cusum.php
*	@date de création: 	20/01/2007
*	@author jcb
*	@version $Id$
*	@update le 20/01/2007
*	@version 1.0
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
require("../../pma_connect.php");
require("../../pma_connexion.php");
require("../../pma_requete.php");
require '../../date.php';
require '../../classe_stat.php';
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//
print("<html>");
print("<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">");
print("<title> Alertes sanitaires </title>");
print("<LINK REL=stylesheet HREF=\"../../pma.css\" TYPE =\"text/css\">");
print("</head>");
//

print("<BODY>");
print("<FORM name =\"alerte\" ACTION=\"\" METHOD=\"GET\">");
// 
// récupération des données
$indicateur = $_REQUEST['indicateur'];
$service = $_REQUEST['service'];
$lissage = $_REQUEST['lissage'];
$methode = $_REQUEST['methode'];
$h = $_REQUEST['sensibilite']; // ecart détectable en nb d'écart-type
$limite = $_REQUEST['seuil'];// limite supérieure d'alarme
$du = fDate2unix($_REQUEST['du']);// date de début
$au = fDate2unix($_REQUEST['au']);// date de début

// écriture de la requete
$requete = "SELECT ";
switch($indicateur){
	case 1:
		$requete.="date,nb_affaires FROM veille_samu WHERE service_ID='";
		$requete.=$service."' AND nb_affaires > 0 ORDER BY date ASC";
		break;
}
//print($requete."<br>");
$resultat = ExecRequete($requete,$connexion);
// lecture des données
$n = 0;
while($rub=mysql_fetch_array($resultat))
{
	$data[]=$rub;
	$n++;
}

$debut = 0;
$fin = $debut + $lissage;
// calcul de la premiere moyenne
$Stat = new CStat();
for($i=$debut;$i<$fin;$i++)
{
	$Stat->addx($data[$i]['nb_affaires']);
} 
$mean = $Stat->moyenne(); // moyenne
$sd = $Stat->ecart_type(); // // écart-type
$s[$lissage-1] = 0;// tableau des St
// fichier pour enregistrer les données
$f=fopen('cusum.txt',"w");

// calcul des CUSUM
print("<table border =\"1\" cellpadding=\"2\" cellspacing=\"0\">");
	print("<tr bgcolor=\"yellow\">");
		print("<td>jour</td>");
		print("<td>date</td>");
		print("<td>affaires</td>");
		print("<td>moyenne</td>");
		print("<td>écart-type</td>");
		print("<td>St</td>");
		print("<td>Cusum</td>");
		print("<td>Date Unix</td>");
	print("</tr>");
	$param="jour\tdate\taffaires\tmoyenne\tecart-type\tSt\tCusum\n";
	fwrite($f,$param);
// C1: on commence le traitement des données au 7ème jour
// C2: on commence le traitement des données au 9ème jour
$arl = 1; //average run length
$stat_arl = new CStat();
if($methode==1)$C1 = -1;
else $C1 = 1;
for($i=$lissage+$C1;$i<$n;$i++)
{
	$x = ($data[$i]['nb_affaires']-$mean)/$sd - $h; // calcul du résidu t
	$s[$i] = max(0,$s[$i-1]+$x); // calcul du Cusum t
	
	if($s[$i] > $limite)
	{
		$bgc='red';
		$stat_arl->addx($arl);
		$arl = 1;
	}
	else 
	{
		$bgc='white';
		$arl++;
	}
	if($data[$i]['date']>=$du && ($data[$i]['date']<=$au))
	{
		print("<tr bgcolor=\"$bgc\">");
		print("<td>".jour_de_la_semaine($data[$i]['date'])."</td>");
		print("<td>".uDate2French($data[$i]['date'])."</td>");
		print("<td align=\"right\">".$data[$i]['nb_affaires']."</td>");
		print("<td align=\"right\">".number_format($mean, 2, ',', ' ')."</td>");
		print("<td align=\"right\">".number_format($sd, 2, ',', ' ')."</td>");
		print("<td align=\"right\">".number_format($x, 2, ',', ' ')."</td>");
		print("<td align=\"right\">".number_format($s[$i], 2, ',', ' ')."</td>");
		print ("<td align=\"right\">".$data[$i]['date']."</td>");
		print("</tr>");
		$param=jour_de_la_semaine($data[$i]['date'])."\t".uDate2French($data[$i]['date'])."\t".$data[$i]['nb_affaires']."\t".$mean."\t".$sd."\t".$x."\t".$s[$i]."\n";
		fwrite($f,$param);
	}
	//on détruit le 1er objet CStat et on en recrée un nouveau
	//delete($Stat);
	$Stat = new CStat();
	// on incrémente
	$debut++;
	$fin++;
	for($j=$debut;$j<$fin;$j++)
	{
		$Stat->addx($data[$j]['nb_affaires']);
	}
	$mean = $Stat->moyenne();
	$sd = $Stat->ecart_type();
}

print("</table>");
fclose($f);
print("ARL moyenne: ".$stat_arl->moyenne()."<br>");
print('<br>');
//$depart=implode("|", $_GET["dpt"]);
print("<a href=\"cusum_graphe.php?service=$service&recul=50\">Graphe</a><br>");
print("<a href=\"export_xls.php\">Exporter le fichier (excel)</a>");

print("</form>");
print("</BODY>");
print("</html>");
?>