<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
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
//----------------------------------------- SAGEC --------------------------------------------------------
/**
*	programme: 			fermeture_regionale.php
*	@date de cr�ation: 	23/03/2005
*	@author:			jcb
*	description:		affiche la liste des services d'une r�gion et le nombre de lits ferm�s
*						� une date donn�e (du jour par d�faut) et par type de services
*	@version:			1.1 - $Id: fermeture_regionale.php 17 2006-10-27 12:56:56Z jcb $
*	maj le:				08/08/2006
*	@package			Sagec
*/
//--------------------------------------------------------------------------------------------------------
session_start();
//if(! $_SESSION['auto_hopital'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/globals_string_lang.php';
require "../utilitairesHTML.php";
require("../pma_requete.php");
require("../date.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
print("<title> services � modifier </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("<LINK REL = \"stylesheet\" TYPE = \"text/css\" HREF = \"service2.css\">");
print("</head>");

print("<FORM name=\"fermeture_regionale\" action=\"fermeture_regionale.php\">");
$mot="Etat des fermetures de lits par sp�cialit�s";
print("<H3>$mot</H3>");
print("<TABLE WIDTH=\"100%\" CLASS=\"Style22\">");
print("<tr>");
	print("<td>S�lectionner une sp�cialit�</td>");
	print("<td>");
	selectTypeService($connexion,$_GET['type_s'],$langue,"");//type_s
	print("</td>");
	$debut = $_GET['debut'];
	if($debut==0) $debut=date("Y/m/d");
	$fin = $_GET['fin'];
	if($fin==0) $fin=date("Y/m/d");
	print("<td>d�but <input type=\"text\" name=\"debut\" value=\"$debut\" size=\"10\"></td>");
	print("<td>fin <input type=\"text\" name=\"fin\" value=\"$fin\" size=\"10\"></td>");
	print("<td><input type=\"submit\" name=\"ok\" value=\"voir\"></td>");
print("</tr>");

if($_GET['ok'])
{
	$pdebut = strtotime($_GET['debut']);
	$pfin = strtotime($_GET['fin']);

	$requete = "SELECT service.service_ID,service_nom,Hop_nom,lits_sp
		FROM service, hopital,lits
		WHERE Type_ID = '$_GET[type_s]'
		AND hopital.Hop_ID = service.Hop_ID
		AND lits.service_ID = service.service_ID
		";
	//print($requete);
	$resultat = ExecRequete($requete,$connexion);
	print("<TABLE WIDTH=\"100%\" CLASS=\"Style22\">");
print("<tr>");
	print("<th>hopital</th>");
	print("<th>service</th>");
	print("<th>d�but</th>");
	print("<th>fin</th>");
	print("<th>nombre de lits ferm�s</th>");
	print("<th>ratio lits ferm�s/lits autoris�s</th>");
	print("<th>mise � jour</th>");
print("</tr>");
while($rub=mysql_fetch_array($resultat))
{
	$requete = "SELECT *
		FROM lits_fermes
		WHERE service_ID = '$rub[service_ID]'
		AND debut < '$pfin'
		AND fin > '$pdebut'
		ORDER BY debut";
	$resultat2 = ExecRequete($requete,$connexion);
	$num_lignes = mysql_num_rows($resultat2);
	if($num_lignes==0)
	{
		print("<tr>");
			print("<td>$rub[Hop_nom]</td>");
			print("<td>$rub[service_nom]</td>");
			print("<td>&nbsp;</td>");
			print("<td>&nbsp;</td>");
			print("<td> 0 </td>");
			print("<td>0/$rub[lits_sp]</td>");
			$tot_autorises += $rub[lits_sp];
		print("</tr>");
	}
	else while($rub2=mysql_fetch_array($resultat2))
	{
		print("<tr>");
			print("<td>$rub[org_nom]</td>");
			print("<td>$rub[service_nom]</td>");
			print("<td>".uDate2French($rub2[debut])."</td>");
			print("<td>".uDate2French($rub2[fin])."</td>");
			print("<td>$rub2[nb_lits_fermes]</td>");
			print("<td>$rub2[nb_lits_fermes]/$rub[lits_sp]</td>");
			$tot_fermes += $rub2[nb_lits_fermes];
			$tot_autorises += $rub[lits_sp];
		print("</tr>");
	}
}
}
print("</table>");
print("<TABLE WIDTH=\"100%\" CLASS=\"Style22\">");
print("<tr>");
	print("<td>TOTAL</td>");
	print("<td>Lits ferm�s ".$tot_fermes."</td>");
	print("<td>Lits autoris�s ".$tot_autorises."</td>");
	if($tot_autorises != 0)
		$r = sprintf('%03.2f',100*$tot_fermes/$tot_autorises);
	print("<td>ratio ".$r." %</td>");
print("</tr>");
print("</table>");
//
?>
