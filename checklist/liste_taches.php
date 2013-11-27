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
//												//
//	programme: 		sagec67.php							//
//	date de cr?ation: 	18/08/2003							//
//	auteur:			jcb								//
//	description:										//
//	version:		1.0								//
//	maj le:			26/12/2003	menu_administrateur
//				7/03/2004	supression de l'affichage de la langue		//
//												//
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
print("<html>");
print("<head>");
print("<title> Gestion des t�ches </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY>");
print("<FORM name =\"taches\"  ACTION=\"tache_principale.php\" METHOD=\"get\" TARGET = \"midle\">");
print("Liste des t�ches:<BR>");
$requete = "SELECT tache_nom, tache_ID from tache";
$resultat = ExecRequete($requete,$connexion);
print("<select name=\"id_tache\" size=\"1\" onChange='document.taches.submit();'>");
print("<OPTION VALUE=\"0\"> nouvelle </OPTION> \n ");
while($rub=mysql_fetch_array($resultat))
{
	print("<OPTION VALUE=\"$rub[tache_ID]\" ");
	print("> $rub[tache_nom] </OPTION> \n");
}
@mysql_free_result($resultat);
print("</SELECT>\n");
print("<BR>");
print("<INPUT TYPE=\"submit\" NAME=\"ok\" VALUE=\"voir\">");
print("</FORM>");
print("</BODY>");
print("</html>");
?>
