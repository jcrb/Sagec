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
//													
//	programme: 			med_affiche_territoire.php							
//	date de création: 	08/12/2005								
//	auteur:				jcb									
//	description:		
//	version:			1.0									
//	maj le:				08/12/2005
//													
//---------------------------------------------------------------------------------------------------------
session_start();
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//
print("<HTML><HEAD><TITLE>APA</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</HEAD>");

print("<BODY>");

if($_GET['action']=='supprimer')
{
	$requete = "DELETE FROM mg67_territoire WHERE com_ID = '$_GET[com_id]' AND med_ID = '$_GET[med]'";
	$resultat = ExecRequete($requete,$connexion);
}

print("<FORM name =\"Territoire\"  ACTION=\"\" METHOD=\"GET\">");
$medecin = $_SESSION['member_id'];

print("<Table width=\"50%\" class=\"time\">");
print("<TR align=\"center\">");
	print("<TD>Commune</TD>");
	print("<TD>Population</TD>");
	print("<TD>délai</TD>");
	print("<TD>&nbsp;</TD>");
	print("<TD>&nbsp;</TD>");
print("</TR>");

$requete = "SELECT delai,com_nom,mg67_territoire.com_ID,pop99
			FROM mg67_territoire,commune
			WHERE med_ID = '$medecin'
			AND mg67_territoire.com_ID = commune.com_ID
			";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	print("<TR>");
	print("<TD>$rub[com_nom]</TD>");
	$r=$rub[pop99]*1000;
	print("<TD align=\"right\">$r</TD>");
	$pop += $rub['pop99']*1000;
	print("<TD align=\"right\">$rub[delai]</TD>");
	print("<TD><a href=\"\">modifier</a></TD>");
	print("<TD><a href=\"med_affiche_territoire.php?action=supprimer&com_id=$rub[com_ID]&med=$medecin\">supprimer</a></TD>");
	print("</TR>");
}
print("<tr><td>&nbsp;</td><td align=\"right\">$pop</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>");
print("</Table>");

print("</FORM>");
print("</BODY>");
print("</HTML>");
?>