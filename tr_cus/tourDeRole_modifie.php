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
//	programme: 		tourDeRole_modifie.php
//	date de cr?ation: 	5/10/2004
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			11/04/2004
//
//---------------------------------------------------------------------------------------------//
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("utilitaire_tr.php");

print("<html>");
print("<head>");
print("<title> menu service </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

function ajoute()
{
	print("bonjour");
}

print("<BODY>");
print("<FORM name=\"tour\" method=\"get\" TARGET=\"bottom\" action=\"tourDeRole_maj.php\">");

print("<fieldset class=\"time_v\">");
print("<legend> Définir le tour de rôle </legend>");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//maj_tabGarde($connexion);

// récupérer le tour de rôle courant
$requete="SELECT * FROM apa_tour";
$resultat = ExecRequete($requete,$connexion);
$nb_lines = 0; //nb de lignes de la table
while($rub=mysql_fetch_array($resultat))
{
	$tour[$rub[ordre]] = $rub[org_ID];
	$nb_lines++;
}
// liste des assu
$requete="SELECT org_nom,organisme.org_ID
		FROM organisme, apa_assu WHERE secteur_apa_ID='6'
		AND organisme.org_ID=apa_assu.org_ID";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	$assu_nom[] = $rub['org_nom'];
	$assu_org[] = $rub['org_ID'];
	//print($rub['org_nom']."<br>");
}

//Affichage de la table courante
print("<table width=\"100%\">");
$ordre = $nb_lines-1;
for($i=0;$i<$nb_lines;$i++)
{
	//$resultat = ExecRequete($requete,$connexion);
	print("<TR><TD>");
	$n = $i+1;
	print("ASSU ".$n." ");
	print("<select name=\"ID_assu[]\" size=\"1\">");
	print("<OPTION VALUE = \"0\">Aucune</OPTION> \n");
	for($j=0;$j < count($assu_nom);$j++)
	{
		print("<OPTION VALUE=\"$assu_org[$j]\" ");
		if($tour[$ordre] == $assu_org[$j]) print(" SELECTED");
		print("> $assu_nom[$j] </OPTION> \n");
	}
	$ordre--;
	print("</SELECT>\n");
	print("</TD></TR>");
}
@mysql_free_result($resultat);
print("</table>");
print("</fieldset>");
print("<INPUT TYPE=\"submit\" name=\"ok\" value=\"Modifier\">");
print("<INPUT TYPE=\"submit\" name=\"ajoute\" value=\"Ajouter\">");
?>
