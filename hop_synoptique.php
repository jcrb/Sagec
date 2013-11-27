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
//
//----------------------------------------- SAGEC ---------------------------------------------//
//
//	programme: 		hop_synoptique.php
//	date de création: 	2004
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			2004
//						25/05/2007 totalement réécrit
//
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'] && !$_SESSION["auto_victime"])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
require("pma_requete.php");
require("pma_connect.php");
require("pma_connexion.php");
require("en_tete.php");
require("utilitairesHTML.php");
require 'date.php';
require("login/init_security.php");

//======================= En Tête ====================================
print("<HTML><HEAD>");
print("<TITLE>synoptique hôpitaux</TITLE>");
print("<meta http-equiv=\"refresh\" content=\"30\">");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("<link rel=\"shortcut icon\" href=\"images/sagec67.ico\" />");
print("</HEAD>");
//====================== Corps =======================================
print("<BODY>");
print("<FORM NAME=\"\" ACTION=\"\" METHOD=\"POST\">");
entete($member_id,$langue);

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

function entete_tableau()
{
	print("<TR>");
		print("<TD WIDTH=\"300\" BGCOLOR=\"#dde6ee\">&nbsp;</TD>");
		print("<TD WIDTH=\"45\" bgcolor=\"#000099\"><CENTER><B><FONT COLOR=\"#ffffff\" size=\"4\" FACE=\"arial\">U</B></FONT></TD>");
		print("<TD WIDTH=\"45\" bgcolor=\"#ff0000\"><CENTER><B><FONT COLOR=\"#ffffff\" FACE=\"arial\">UA</B></FONT></TD>");
		print("<TD WIDTH=\"45\" bgcolor=\"#ffff00\"><CENTER><B><FONT COLOR=\"#000000\" FACE=\"arial\">UR</B></FONT></TD>");
		print("<TD WIDTH=\"45\" bgcolor=\"#00ff00\"><CENTER><B><FONT COLOR=\"#000000\" FACE=\"arial\">U3</B></FONT></TD>");
		print("<TD WIDTH=\"45\" bgcolor=\"#000000\"><CENTER><B><FONT COLOR=\"#ffffff\" FACE=\"arial\">DCD</B></FONT></D>");
		print("<TD WIDTH=\"80\" bgcolor=\"#dde6ee\"><CENTER><B><FONT COLOR=\"#000000\" FACE=\"arial\">Total</B></FONT></TD>");
	print("</TR>");
}
/*
$requete="SELECT gravite, org_nom
		FROM victime, organisme
		WHERE victime.Hop_ID = organisme.org_ID
		ORDER by gravite
		";*/
$requete="SELECT gravite, Hop_nom
		FROM victime, hopital
		WHERE victime.Hop_ID = hopital.Hop_ID
		AND victime.evenement_ID = '$_SESSION[evenement]'
		ORDER by gravite
		";
$resultat = ExecRequete($requete,$connexion);
$nombre = array();
while($rub=mysql_fetch_array($resultat))
{
	$nombre[Security::db2str($rub['Hop_nom'])][$rub['gravite']]++;
}
//print_r($nombre);
$gravite = array(0);
$color=array("#009999","#f48b809","#ffff80","#8bf878","#999999","#dde6ee");

if($langue=='FR') $mot='Répartition des victimes dans les hôpitaux '.dateHeureComplete(time(),$langue);
else if($langue=='GE') $mot='Verteilung der Verletzungen in Krankenhäusern '.dateHeureComplete(time(),$langue);
else if($langue=='UK') $mot='Distribution of injuries in hospital '.dateHeureComplete(time(),$langue);
print("<fieldset>");
print("<legend><font face=\"arial\" size=\"2\">$mot</font></legend>");
print("<Table  width=\"75%\" BORDER=\"0\" CELLSPACING=\"1\" CELLPADDING=\"0\">");
// en tête du tableau
entete_tableau();
// lignes

$total_ligne = 0;
$total_general = 0;
$total_colonne = array(0);

while(list($hop) = each($nombre))
{
	//print($hop." ");
	while(list($g,$n) = each($nombre[$hop])) //$g = gravité, $n = nombre
	{
		switch($g){
			case 1:
			case 7:$g = 1;break;
			case 2:
			case 8:$g = 2;break;
			case 6:
			case 9:$g = 3;break;
			case 5:$g = 4;break;
			default: $g = 0;break;
		}	
		$gravite[$g] += $n;
		$total_ligne += $n;
		$total_colonne[$g] += $n;
		$total_general += $n;
	}
	//print($hop.' ');
	print("<TR>");
	print("<TD WIDTH=\"300\" BGCOLOR=\"#dde6ee\"><FONT size=\"2\">$hop</font></TD>");
	for($i=0; $i<5;$i++)
	{
		if($gravite[$i]==0)
			print("<TD WIDTH=\"45\" bgcolor=\"$color[$i]\"><CENTER>&nbsp;</TD>");
		else
		{
			print("<TD WIDTH=\"45\" bgcolor=\"$color[$i]\"><FONT size=\"2\"><CENTER>$gravite[$i]</font></TD>");
			//print($gravite[$i].' ');
			$gravite[$i] = 0;
		}
	}
	print("<TD WIDTH=\"80\" BGCOLOR=\"#dde6ee\"><FONT size=\"2\"><CENTER>$total_ligne</font></TD>");
	print("</TR>");
	//print($total_ligne);
	$total_ligne = 0;
	//print('<br>');
}
print("<TR>");
print("<TD WIDTH=\"\" BGCOLOR=\"#dde6ee\"><FONT size=\"2\"> TOTAL </font></TD>");
for($i=0; $i<5;$i++)
{
	if($total_colonne[$i]==0)
		print("<TD WIDTH=\"45\" bgcolor=\"$color[$i]\"><CENTER>&nbsp;</TD>");
	else
		print("<TD WIDTH=\"45\" bgcolor=\"$color[$i]\"><FONT size=\"2\"><CENTER>$total_colonne[$i]</font></TD>");
	//print($total_colonne[$i].' ');
}
//print('<br>');
//print($total_general.'<br>');
print("<TD WIDTH=\"80\" BGCOLOR=\"#dde6ee\"><FONT size=\"2\"><CENTER>$total_general</font></TD>");
print("</Table>");
print("</fieldset>");


print("<fieldset>");
if($langue=='FR') $mot='Répartition des victimes sans destination '.dateHeureComplete(time(),$langue);
else if($langue=='GE') $mot='Verteilung der Verletzungen ohne Bestimmung '.dateHeureComplete(time(),$langue);
else if($langue=='UK') $mot='Distribution of injuries without destination '.dateHeureComplete(time(),$langue);

print("<legend><font face=\"arial\" size=\"2\">$mot</font></legend>");
print("<Table  width=\"75%\" BORDER=\"0\" CELLSPACING=\"1\" CELLPADDING=\"0\">");
// en tête du tableau
entete_tableau();
$requete = "SELECT gravite FROM victime WHERE victime.Hop_ID = 0 AND victime.evenement_ID = '$_SESSION[evenement]'ORDER by gravite";
$resultat = ExecRequete($requete,$connexion);
$gravite = array();
$total_general = 0;
while($rep = mysql_fetch_array($resultat))
{
	$g = $rep['gravite'];
	switch($g)
	{
		case 1:
		case 7:$g = 1;break;
		case 2:
		case 8:$g = 2;break;
		case 6:
		case 9:$g = 3;break;
		case 5:$g = 4;break;
		case 11:$g = 0;break;
		default: $g = 0;break;
	}	
	$gravite[$g]++;
	$total_general++;
}
print("<TR>");
	print("<TD WIDTH=\"300\" BGCOLOR=\"#dde6ee\"><FONT size=\"2\">$hop</font></TD>");
	for($i=0; $i<5;$i++)
	{
		if($gravite[$i]==0)
			print("<TD WIDTH=\"45\" bgcolor=\"$color[$i]\"><CENTER>&nbsp;</TD>");
		else
		{
			print("<TD WIDTH=\"45\" bgcolor=\"$color[$i]\"><FONT size=\"2\"><CENTER>$gravite[$i]</font></TD>");
			//print($gravite[$i].' ');
			$gravite[$i] = 0;
		}
	}
	print("<TD WIDTH=\"80\" BGCOLOR=\"#dde6ee\"><FONT size=\"2\"><CENTER>$total_general</font></TD>");
	print("</TR>");
print("</Table>");
print("</fieldset>");

print("</FORM>");
print("</BODY>");
print("</HTML>");
?>
