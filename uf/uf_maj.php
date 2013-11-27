<?php
//----------------------------------------- SAGEC --------------------------------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//----------------------------------------- SAGEC --------------------------------------------------------
/**
*	programme: 		uf_maj.php
*	description:	gestion des UF
*	date de cr�ation: 	17/02/2008
*	@author:			jcb
*	@version:		$Id: uf_maj.php 41 2008-03-08 14:36:50Z jcb $
*	maj le:			
*/
//---------------------------------------------------------------------------------------------------------
//
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$langue = $_SESSION['langue'];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>Uformulaire plan blanc</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link href="uf.css" rel="stylesheet" type="text/css" />
</head>

<?php

/**
*	Liste les UF d'un h�pital
* 	@param [in] $hopid identifiant sagec de l'h�pital
*/
function get_UF_hopital($hopid)
{
	global $connexion;
	
	$requete = "SELECT * FROM uf WHERE Hop_ID = '$hopid'";
	
	$requete = "SELECT * ,Hop_nom, service_nom
					FROM uf,hopital, service,organisme
					WHERE uf.Hop_ID = '$hopid'
					AND hopital.Hop_ID = '$hopid'
					AND service.service_ID = uf.service_ID
					AND service.org_ID = uf.org_ID
					AND organisme.org_ID = uf.org_ID
					";
					
	$resultat = ExecRequete($requete,$connexion);
	print("<table>");
		print("<tr>");
			print("<td>UF ID</td>");
			print("<td>UF Code</td>");
			print("<td>UF nom</td>");
			print("<td>UF ouverte</td>");
			print("<td>Service ID</td>");
			print("<td>Service nom</td>");
			print("<td>Pole ID</td>");
			print("<td>H�pital ID</td>");
			print("<td>H�pital nom</td>");
			print("<td>Organisme ID</td>");
		print("</tr>");
		while($rub=mysql_fetch_array($resultat))
		{
			print("<tr>");
				print("<td>".$rub['uf_ID']."</td>");
				print("<td>".$rub['uf_code']."</td>");
				print("<td>".$rub['uf_nom']."</td>");
				print("<td>".$rub['uf_ouverte']."</td>");
				print("<td>".$rub['service_ID']."</td>");
				print("<td>".$rub['service_nom']."</td>");
				print("<td>".$rub['pole_ID']."</td>");
				print("<td>".$rub['Hop_ID']."</td>");
				print("<td>".$rub['Hop_nom']."</td>");
				print("<td>".$rub['org_ID']."</td>");
				print("<td><a href=\"uf_modifie.php?id=$rub[uf_ID]\">modifier</a></td>");
				print("</tr>");
		}
	print("</table>");
}

/**
* statistiques
* affiche les donn�es lits de l'UF 
* @param $ufid identifiant sagec de l'UF
*/
function lits($ufid)
{
	global $connexion;
	
	$requete = "SELECT * FROM journal_uf WHERE uf_ID = '$ufid' ORDER BY date";
	$resultat = ExecRequete($requete,$connexion);
	print("<table border=\"1\">");
		print("<tr>");
			print("<td>UF ID</td>");
			//print("<td>UF Code</td>");
			print("<td>Date</td>");
			print("<td>Heure</td>");
			print("<td>Lits install�s</td>");
			print("<td>lits_ouverts</td>");
			print("<td>Lits dispo</td>");
			print("<td>lits ferm�s</td>");
			print("<td>Lits sup</td>");
			print("<td>Lits occup�s</td>");
		print("</tr>");
		while($rub=mysql_fetch_array($resultat))
		{
			print("<tr>");
				print("<td>".$rub['uf_ID']."</td>");
				//print("<td>".$rub['uf_code']."</td>");
				print("<td>".$rub['date']."</td>");
				print("<td>".$rub['heure']."</td>");
				print("<td>".$rub['lits_installes']."</td>");
				print("<td>".$rub['lits_ouverts']."</td>");
				print("<td>".$rub['lits_dispo']."</td>");
				print("<td>".$rub['lits_fermes']."</td>");
				print("<td>".$rub['lits_sup']."</td>");
				print("<td>".$rub['lits_occupes']."</td>");
				print("</tr>");
		}
	print("</table>");
}

/**
* analyse du fichier veille_sau
* s'il existe plusieurs UF, les r�sultats sont group�s
* @param $orgid identifiant sagec de l'organisme
*/
function veilleSAU($orgid)
{
	global $connexion;
	
	// identification de la structure
	$requete = "SELECT org_nom FROM organisme WHERE org_ID = '$orgid'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	print($rub['org_nom']."<br>Activit� des services d'urgence<br><br>");
	
	$requete = "SELECT date, SUM(passage) passage, SUM(inf_1an) inf_1an,SUM(sup_75an) sup_75an,SUM(hosp) hosp,
					SUM(uhcd) uhcd, SUM(transfert) transfert
					FROM veille_SAU where org_ID = '$orgid' GROUP BY date";
	$resultat = ExecRequete($requete,$connexion);
	print("<table border=\"1\">");
		print("<tr>");
			print("<td>Date</td>");
			print("<td>Passages</td>");
			print("<td>Moins de 1 an</td>");
			print("<td>Plus de 75 ans</td>");
			print("<td>Hospitalis�s</td>");
			print("<td>UHCD</td>");
			print("<td>Transferts</td>");
		print("</tr>");
		while($rub=mysql_fetch_array($resultat))
		{
			print("<tr>");
				print("<td>".$rub['date']."</td>");
				print("<td>".$rub['passage']."</td>");
				print("<td>".$rub['inf_1an']."</td>");
				print("<td>".$rub['sup_75an']."</td>");
				print("<td>".$rub['hosp']."</td>");
				print("<td>".$rub['uhcd']."</td>");
				print("<td>".$rub['transfert']."</td>");
				print("</tr>");
		}
	print("</table>");
}

function veilleSAU_uf($orgid)
{
	global $connexion;
	
	// identification de la structure
	$requete = "SELECT org_nom FROM organisme WHERE org_ID = '$orgid'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	print($rub['org_nom']."<br>Activit� des services d'urgence<br><br>");
	
	$requete = "SELECT date, passage, inf_1an, sup_75an, hosp,
					 uhcd, transfert,service_nom
					FROM veille_SAU, service
					WHERE veille_SAU.service_ID = service.service_ID
					AND  veille_SAU.org_ID = '$orgid'  
					GROUP BY service_nom,date
					ORDER BY service_nom
					";
	$resultat = ExecRequete($requete,$connexion);
	print("<table border=\"1\">");
		print("<tr>");
			print("<td>Date</td>");
			print("<td>service</td>");
			print("<td>Passages</td>");
			print("<td>Moins de 1 an</td>");
			print("<td>Plus de 75 ans</td>");
			print("<td>Hospitalis�s</td>");
			print("<td>UHCD</td>");
			print("<td>Transferts</td>");
		print("</tr>");
		while($rub=mysql_fetch_array($resultat))
		{
			print("<tr>");
				print("<td>".$rub['date']."</td>");
				print("<td>".$rub['service_nom']."</td>");
				print("<td>".$rub['passage']."</td>");
				print("<td>".$rub['inf_1an']."</td>");
				print("<td>".$rub['sup_75an']."</td>");
				print("<td>".$rub['hosp']."</td>");
				print("<td>".$rub['uhcd']."</td>");
				print("<td>".$rub['transfert']."</td>");
				print("</tr>");
		}
	print("</table>");
}

/**
*	UF par type d'activit�
*	$activite 1=Mco, 2 = SC, 3 = SI, 4 = REA,...
*/
function lits_activite_uf($activite)
{
	global $connexion;
	$requete = "SELECT uf.uf_ID,uf_code,uf_nom,date,lits_ouverts,lits_dispo						
					FROM journal_uf,uf
					WHERE journal_uf.uf_ID = uf.uf_ID
					AND uf_activite_ID = '$activite'
					AND uf_ouverte = 1
					AND date = (SELECT MAX(date) FROM journal_uf WHERE uf_ID = uf.uf_ID)
					ORDER BY date DESC
					";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print($rub[uf_ID]." ".$rub[uf_code]." ".$rub[uf_nom]." ".$rub[date]." ".$rub[lits_ouverts]." ".$rub[lits_dispo]."<br>");
		$total_lits_ouverts += $rub[lits_ouverts];
		$total_lits_dispo += $rub[lits_dispo];
	}
	$taux_occupation = $total_lits_dispo/$total_lits_ouverts;
	print("Total lits ouverts = ".$total_lits_ouverts."<br>");
	print("Total lits libres  = ".$total_lits_dispo."<br>");
	print("Taux d'occupation  = ".$taux_occupation."<br>");
}

/**
* 	r�cup�re les enregistrements les plus r�cents pour chaque UF
*	Les enregistrements sont regroup�s par UF. Dans chaque groupe, l'enregistrement
*	dont la date est la plus r�cente est retourn�
*	En pratique on obtient pour chaque UF, la date de la derni�re mise � jour
*	@todo limiter la recherche � un hopital ou une structure
*/
function derniers_enregistrements()
{
	global $connexion;
	
	// identification de la structure
				 	
	$requete = "SELECT uf.uf_ID,uf_nom,date FROM journal_uf,uf
					WHERE journal_uf.uf_ID = uf.uf_ID
					AND date = (SELECT MAX(date) FROM journal_uf)
					GROUP BY uf.uf_ID
					ORDER BY date DESC
					";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print($rub[uf_ID]." ".$rub[uf_nom]." ".$rub[date]."<br>");
	}
}
/**
pour corriger une erreur initiale dans la base de donn�e
* NE PLUS L'UTILISER
*/
/*
function correction($ufid)
{
	global $connexion;
	
	$requete = "SELECT * FROM journal_uf WHERE date < '2008-02-11' ORDER BY date";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
	
		$requete2 = "UPDATE journal_uf set
					lits_dispo = $rub[lits_sup],
					lits_fermes = $rub[lits_occupes],
					lits_sup = $rub[lits_fermes],
					lits_occupes = $rub[lits_dispo]
					WHERE journal_ID = $rub[journal_ID]
						";
		//$resultat2 = ExecRequete($requete2,$connexion);
		print($rub['date']." ".$requete2."<br>");
	}
}
*/

print("<body>");
	print("<form id=\"test\" action=\"\" method=\"post\">");
/**
* teste les fonctions
*/

$hopid = 6; // h�pital de Haguenau 
$ufid = 425; // r�animation Haguenau
							//get_UF_hopital($hopid);
print("<a href=\"test_page.php\">test</a>");

//lits($ufid);
//veilleSAU(85);
print("<br>");
//veilleSAU(90);
//derniers_enregistrements();
//veilleSAU_uf(85);
$activite = 4;
lits_activite_uf($activite);

	print("</form>");
print("</body>");
print("</html>");
?>
