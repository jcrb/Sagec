<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------
//
//	programme: 		arh_data_samu.php
//	date de création: 	03/06/2005
//	auteur:			jcb
//	description:		crée un dossier. Par défaut le dossier est créé dans le dossier
//					administrateur. Pour le créér dans le dosier principal,
//					commencer par ../mon_dossier
//	version:			1.3
//	maj le:			27/07/2005	Ajout possibilité suppression enregistrement si autorisation = 10
//				08/09/2005	Pour les SAU remplacement de org_ID par Hop_ID (pb de Wissembourg)
//
//--------------------------------------------------------------------------------
//
session_start();
if(!$_SESSION['auto_arh'])header("Location:../logout.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../date.php");
$langue = $_SESSION['langue'];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
print("<head>");
print("<title>F2T</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");
//================================================================================
print("<BODY>");
print("<FORM name=\"arh\" method=\"post\" action=\"\">");

if($_GET['del_sau'])
{
	$requete="DELETE FROM veille_sau WHERE veille_ID='$_GET[del_sau]'";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete."<br>");
}

if(!$_GET['date1'])
{
	$date1 = mktime(0,0,0,date('m'),date('j')-6,date('Y'));
	$d1 = date("j/m/Y");
	$service='tous';
}
else
{
	$d1 = $_GET['date1'];
	$date1 = fdate2unix($_GET['date1']);
	$service = $_GET['service'];
}
if(!$_GET['date2'])
{
	$date2 = mktime(0,0,0,date('m'),date('j'),date('Y'));
	$d2 = date("j/m/Y");
	$service='tous';
}
else
{
	$d2 = $_GET['date2'];
	$date2 = fdate2unix($_GET['date2']);
	$service = $_GET['service'];
}

print("<div class=\"time2\">Période du ".$d1." au ".$d2."</div><br>");

if($service=='samu'||$service=='tous')
{
	print("Activité des SAMU-SMUR<br><br>");
	$requete="SELECT date,veille_samu.service_ID,nb_affaires,nb_primaires,nb_secondaires,nb_neonat,nb_tiih,nb_apa,nb_vsav,conseils,nb_med,service_nom
		FROM veille_samu, service
		WHERE service.service_ID = veille_samu.service_ID
		AND date BETWEEN '$date1' AND '$date2'
		ORDER BY service_ID,date DESC";
	$resultat = ExecRequete($requete,$connexion);

print("<table border=\"1\" cellspacing=\"0\" class=\"Style22\" width=\"700\">");
print("<tr>");
	print("<td class=\"grise\">date</div></td>");
	print("<td class=\"grise\"><div align=\"center\"> service </div></td>");
	print("<td class=\"grise\"><div align=\"center\"> affaires </div></td>");
	print("<td class=\"grise\"><div align=\"center\"> primaires </div></td>");
	print("<td class=\"grise\"><div align=\"center\"> secondaires </div></td>");
	print("<td class=\"grise\"><div align=\"center\"> néonat </div></td>");
	print("<td class=\"grise\"><div align=\"center\"> TIIH </div></td>");
	print("<td class=\"grise\"><div align=\"center\"> ASSU </div></td>");
	print("<td class=\"grise\"><div align=\"center\"> VSAV </div></td>");
	print("<td class=\"grise\"><div align=\"center\"> conseils </div></td>");
	print("<td class=\"grise\"><div align=\"center\"> Medecins </div></td>");
print("</tr>");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td class=\"navy\"><div align=\"right\">".date("j/m/Y",$rub[date])."</div></td>");
		print("<td class=\"navy\"><div align=\"center\">$rub[service_nom]</div></td>");
		print("<td class=\"navy\"><div align=\"center\">$rub[nb_affaires]</div></td>");
		print("<td class=\"navy\"><div align=\"center\">$rub[nb_primaires]</div></td>");
		print("<td class=\"navy\"><div align=\"center\">$rub[nb_secondaires]</div></td>");
		print("<td class=\"navy\"><div align=\"center\">$rub[nb_neonat]</div></td>");
		print("<td class=\"navy\"><div align=\"center\">$rub[nb_tiih]</div></td>");
		print("<td class=\"navy\"><div align=\"center\">$rub[nb_apa]</div></td>");
		print("<td class=\"navy\"><div align=\"center\">$rub[nb_vsav]</div></td>");
		print("<td class=\"navy\"><div align=\"center\">$rub[conseils]</div></td>");
		print("<td class=\"navy\"><div align=\"center\">$rub[nb_med]</div></td>");
	print("</tr>");
	}
	print("</table><br>");
}
if($service=='sau'||$service=='tous')
{
	print("Activité des services d'urgence<br><br>");
	/*
	$requete="SELECT date,veille_ID,veille_sau.service_ID,inf_1_an,sup_75_an,entre1_75,hospitalise,uhcd,transfert,service_nom,org_nom
		FROM veille_sau, service,organisme
		WHERE service.service_ID = veille_sau.service_ID
		AND organisme.org_ID = service.org_ID
		AND date BETWEEN '$date1' AND '$date2'
		ORDER BY date DESC,org_nom,service_ID";*/
	
	$requete="SELECT date,veille_ID,veille_sau.service_ID,inf_1_an,sup_75_an,entre1_75,hospitalise,uhcd,transfert,service_nom,Hop_nom
		FROM veille_sau, service,hopital
		WHERE service.service_ID = veille_sau.service_ID
		AND hopital.Hop_ID = service.Hop_ID
		AND date BETWEEN '$date1' AND '$date2'
		ORDER BY date DESC,Hop_nom";
		
	$resultat = ExecRequete($requete,$connexion);
	print("<table border=\"1\" cellspacing=\"0\" class=\"Style22\" width=\"700\">");
	print("<tr>");
		print("<td class=\"grise\"> date </td>");
		print("<td class=\"grise\"><div align=\"center\"> Organisme </div></td>");
		print("<td class=\"grise\"><div align=\"center\"> service </div></td>");
		print("<td class=\"grise\"><div align=\"center\"> moins de 1 an </div></td>");
		print("<td class=\"grise\"><div align=\"center\"> plus de 75 ans </div></td>");
		print("<td class=\"grise\"><div align=\"center\"> entre 1 et 75 ans </div></td>");
		print("<td class=\"grise\"><div align=\"center\"> TOTAL passages </div></td>");
		print("<td class=\"grise\"><div align=\"center\"> hospitalisés </div></td>");
		print("<td class=\"grise\"><div align=\"center\"> UHCD </div></td>");
		print("<td class=\"grise\"><div align=\"center\"> Transferts </div></td>");
		if($_SESSION['autorisation']==10)
			print("<td class=\"grise\"><div align=\"center\"> &nbsp; </div></td>");
	print("</tr>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<tr>");
			print("<td class=\"navy\"><div align=\"right\">".date("j/m/Y",$rub[date])."</div></td>");
			//print("<td class=\"navy\"><div align=\"center\">$rub[org_nom]</div></td>");
			print("<td class=\"navy\"><div align=\"center\">$rub[Hop_nom]</div></td>");
			print("<td class=\"navy\"><div align=\"center\">$rub[service_nom]</div></td>");
			print("<td class=\"navy\"><div align=\"center\">$rub[inf_1_an]</div></td>");
			print("<td class=\"navy\"><div align=\"center\">$rub[sup_75_an]</div></td>");
			print("<td class=\"navy\"><div align=\"center\">$rub[entre1_75]</div></td>");
			$total = $rub['entre1_75']+$rub['sup_75_an']+$rub['inf_1_an'];
			print("<td class=\"navy\"><div align=\"center\">$total</div></td>");
			print("<td class=\"navy\"><div align=\"center\">$rub[hospitalise]</div></td>");
			print("<td class=\"navy\"><div align=\"center\">$rub[uhcd]</div></td>");
			print("<td class=\"navy\"><div align=\"center\">$rub[transfert]</div></td>");
			if($_SESSION['autorisation']==10)
				print("<td class=\"grise\"><div align=\"center\"><a href=\"arh_data_samu.php?del_sau=$rub[veille_ID]\"> supprimer </a></div></td>");
		print("</tr>");
	}
	print("</table><br>");
}
if($service=='hopital'||$service=='tous')
{
print("Décès enregistrés dans les hôpitaux<br><br>");
$requete="SELECT date,veille_dg.org_ID,nb_tot_dcd,nb_dcd_sup75,org_nom
		FROM veille_dg, organisme
		WHERE organisme.org_ID = veille_dg.org_ID
		AND date BETWEEN '$date1' AND '$date2'
		ORDER BY org_ID,date DESC";
	$resultat = ExecRequete($requete,$connexion);
	print("<table border=\"1\" cellspacing=\"0\" class=\"Style22\" width=\"700\">");
	print("<tr>");
		print("<td class=\"grise\"> date </td>");
		print("<td class=\"grise\"><div align=\"center\"> Organisme </div></td>");
		print("<td class=\"grise\"><div align=\"center\"> nombre total de décès </div></td>");
		print("<td class=\"grise\"><div align=\"center\"> Décès de plus de 75 ans </div></td>");
		print("<td class=\"grise\"><div align=\"center\"> Décès de moins de 75 ans </div></td>");
	print("</tr>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<tr>");
			print("<td class=\"navy\"><div align=\"right\">".date("j/m/Y",$rub[date])."</div></td>");
			print("<td class=\"navy\"><div align=\"center\">$rub[org_nom]</div></td>");
			print("<td class=\"navy\"><div align=\"center\">$rub[nb_tot_dcd]</div></td>");
			print("<td class=\"navy\"><div align=\"center\">$rub[nb_dcd_sup75]</div></td>");
			$d=$rub['nb_tot_dcd']-$rub['nb_dcd_sup75'];
			print("<td class=\"navy\"><div align=\"center\">$d</div></td>");
		print("</tr>");
	}
	print("</table>");
}
?>
