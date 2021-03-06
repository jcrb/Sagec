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
*	@date de cr�ation: 	20/01/2007
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
print("<head>");
print("<title> Alertes sanitaires </title>");
print("<LINK REL=stylesheet HREF=\"../../pma.css\" TYPE =\"text/css\">");
print("</head>");
//

print("<BODY>");
print("<FORM name =\"alerte\" ACTION=\"\" METHOD=\"GET\">");

print_r($_REQUEST);
// 
// r�cup�ration des donn�es
$indicateur = $_REQUEST['indicateur'];
$service = $_REQUEST['service'];
$lissage = $_REQUEST['lissage'];
$methode = $_REQUEST['methode'];
$h = $_REQUEST['sensibilite']; // ecart d�tectable en nb d'�cart-type
$limite = $_REQUEST['seuil'];// limite sup�rieure d'alarme
$du = fDate2unix($_REQUEST['du']);// date de d�but
$au = fDate2unix($_REQUEST['au']);// date de d�but

/**--------------------------------------------------------------
* �criture de la requ�te: version exp�rimentale; ne concerne que 
* les services d'urgence des HUS � l'exclusion de la p�diatrie
* SAU Pasteur = 8
* SAU adulte HTP = 9
* SAU chir A = 38
-----------------------------------------------------------------*/
$service = "('8','9','38')";
/**---------------------------------------------------------------
* la table veille_sau stocke sur une ligne les valeurs pour un 
* service et un jour donn�. Il existe donc plusieurs lignes ayant 
* la m�me date. On op�re un regroupement sur les dates.
* Les donn�es sont retourn�es sous forme de 3 valeurs correspondant
* aux 3 classe de mesures: <1 an, > 75 ans, entre 1 et 75 ans
* @TODO toutes les lignes de la table sont retourn�es alors que 
* seules les lignes correspondant au date de mesure sont utiles
* REMARQUE: il y a des jours avec donn�es incompl�tes
-----------------------------------------------------------------*/
$requete = "SELECT ";
switch($indicateur)
{
	case 1:
		$requete.="date,inf_1_an, sup_75_an,entre1_75,SUM(entre1_75),SUM(inf_1_an),SUM(sup_75_an)
		FROM veille_sau 
		WHERE service_ID IN ";
		$requete.= $service;
		$requete.=" GROUP BY date ";
		$requete.=" ORDER BY date ASC";
		break;
}
//print($requete."<br>");
$resultat = ExecRequete($requete,$connexion);
/*--------------------------------------------------------------------------------
* lecture des donn�es
* le tableau srub est transform� en tableau $data comportant n lignes et 2 colonnes
* colonne 1: date du jour
* colonne 2: somme totale des passages pour ce jour, quelque soit l'age
----------------------------------------------------------------------------------*/
$n = 0;
while($rub=mysql_fetch_array($resultat))
{
	$data[$n]['date']=$rub['date'];
	$data[$n]['passages'] = $rub[4] + $rub[5] + $rub[6];
	//print(uDate2French($data[$n]['date'])." ".$data[$n]['passages']."<br>");
	$n++;
}
/*----------------------------------------------------------------------------------
* Calcul du CUSUM
* calcul de la premi�re moyenne � partir de la p�riode de r�f�rence
* la p�riode de r�f�rence correspond � la dur�e du lissage
* les donn�es du tableau data correspondant � cette p�riode sont saisis dans un 
* objet statistique CStat qui retourne la moyenne et l'�cart-type pour cette p�riode.
----------------------------------------------------------------------------------*/
$debut = 0;
$fin = $debut + $lissage;
// calcul de la premi�re moyenne
$Stat = new CStat();
for($i=$debut;$i<$fin;$i++)
{
	$Stat->addx($data[$i]['passages']);
} 
$mean = $Stat->moyenne(); // moyenne
$sd = $Stat->ecart_type(); // // �cart-type
$s[$lissage-1] = 0;// tableau des St
// fichier oiur enregistrer les donn�es et les exporter
$f=fopen('cusum.txt',"w");

// calcul des CUSUM
print("<table border = \"1\" cellpadding=\"2\" cellspacing=\"0\">");
	print("<tr bgcolor=\"yellow\">");
		print("<td>jour</td>");
		print("<td>date</td>");
		print("<td align=\"rigth\">passages</td>");
		print("<td align=\"rigth\">moyenne</td>");
		print("<td align=\"rigth\">�cart-type</td>");
		print("<td align=\"rigth\">St</td>");
		print("<td align=\"rigth\">Cusum</td>");
		print("<td align=\"rigth\">Date Unix</td>");
	print("</tr>");
	fwrite($f,"Donn�es SAU HUS hors p�diatrie");
	$param="jour\tdate\taffaires\tmoyenne\tecart-type\tSt\tCusum\n";
	fwrite($f,$param);

/*-----------------------------------------------------------------------
Calcul des autres p�riodes
 C1: on commence le traitement des donn�es au 7�me jour
 C2: on commence le traitement des donn�es au 9�me jour
 ----------------------------------------------------------------------*/
$arl = 1; //average run length
$stat_arl = new CStat();
if($methode==1)$C1 = -1;
else $C1 = 1;
for($i=$lissage+$C1;$i<$n;$i++)
{
	$x = ($data[$i]['passages']-$mean)/$sd - $h; // calcul du r�sidu t
	$s[$i] = max(0,$s[$i-1]+$x); // calcul du Cusum t
	
	// si le cusum d�passe la limite, les cases sont mise en rouge
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
		print("<td>".$data[$i]['passages']."</td>");
		print("<td align=\"right\">".number_format($mean, 2, ',', ' ')."</td>");
		print("<td align=\"right\">".number_format($sd, 2, ',', ' ')."</td>");
		print("<td align=\"right\">".number_format($x, 2, ',', ' ')."</td>");
		print("<td align=\"right\">".number_format($s[$i], 2, ',', ' ')."</td>");
		print ("<td align=\"right\">".$data[$i]['date']."</td>");
		print("</tr>");
		$param=jour_de_la_semaine($data[$i]['date'])."\t".uDate2French($data[$i]['date'])."\t".$data[$i]['passages']."\t".$mean."\t".$sd."\t".$x."\t".$s[$i]."\n";
		fwrite($f,$param);
	}
	//on d�truit le 1er objet CStat et on en recr�e un nouveau
	// @TODO voir si un reset de l'objet CStat ne serait pas plus efficient que la cr�ation nouvel objet
	//delete($Stat);
	$Stat = new CStat();
	// on incr�mente
	$debut++;
	$fin++;
	for($j=$debut;$j<$fin;$j++)
	{
		$Stat->addx($data[$j]['passages']);
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