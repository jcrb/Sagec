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
/**
*	apa_saisie_planning.php
*  @version $Id: apa_saisie_planning.php 39 2008-02-28 17:59:09Z jcb $
*/
require("UtilitairesHTML.php");
require("PMA_Connect.php");
require("PMA_Connexion.php");
require("PMA_Requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);	

print("<H2>Planning de permanence</H2><BR>");

// tableau extérieur
print("<TABLE WIDTH=\"100%\">");
print("<TR>");
print("<TD>");
// tableau intérieur 1
print("<TABLE WIDTH=\"100%\">");
print("<TR>");
	print("<TD>Jour</TD>");
	print("<TD>");
		print("<SELECT NAME=\"jour\">");
		for($i = 1; $i< 32; $i++)
			print("<OPTION VALUE = \"$i\"> $i </OPTION>\n");
		print("</SELECT>");
	print("</TD>");
print("</TR>");
print("<TR>");
	print("<TD>Mois</TD>");
	print("<TD>");
		print("<SELECT NAME=\"jour\">");
		for($i = 1; $i< 13; $i++)
			print("<OPTION VALUE = \"$i\"> $i </OPTION>\n");
		print("</SELECT>");
	print("</TD>");
print("</TR>");
print("<TR>");
	print("<TD>Année</TD>");
	print("<TD>");
		print("<SELECT NAME=\"jour\">");
		for($i = 2003; $i< 2009; $i++)
			print("<OPTION VALUE = \"$i\"> $i </OPTION>\n");
		print("</SELECT>");
	print("</TD>");
print("</TR>");
print("</TABLE>");
print("</TD>");// cellule 1
// tableau intérieur 2
print("<TD>");// cellule 2
print("<TABLE WIDTH=\"100%\" bgcolor=\"beige\">");
print("<TR>");
	print("<TD colspan=\"4\" align=\"center\"><B>Permanence par secteur</B></TD>");	
print("</TR>");
print("<TR>");
	for($i = 1; $i< 5; $i++)
		print("<TD>Secteur $i</TD>");
print("</TR>");
print("<TR>");
	for($i = 1; $i< 5; $i++)
	{
		print("<TD>");
			liste_apa_du_secteur($connexion,$i,"");
		print("</TD>");
	}
print("</TR>");
print("<TR>");
	for($i = 5; $i< 9; $i++)
		print("<TD>Secteur $i</TD>");
print("</TR>");
print("<TR>");
	for($i = 5; $i< 9; $i++)
	{
		print("<TD>");
			liste_apa_du_secteur($connexion,$i,"");
		print("</TD>");
	}
print("</TR>");
print("<TR>");
	for($i = 9; $i< 10; $i++)
		print("<TD>Secteur $i</TD>");
print("</TR>");
print("<TR>");
	for($i = 9; $i< 10; $i++)
	{
		print("<TD>");
			liste_apa_du_secteur($connexion,$i,"");
		print("</TD>");
	}
print("</TR>");
	print("<TD colspan=\"4\" align=\"center\">--0--</TD>");
print("<TR>");
print("</TR>");
print("</TABLE>");
print("</TD>");// cellule 2
print("</TR>");
print("</TABLE>");
?>
