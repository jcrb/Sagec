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
// n° tache dans la variable $_GET['id_tache']
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");

print("<html>");
print("<head>");
print("<title> Gestion des tâches </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY bgcolor=\"yellow\">");
print("<FORM name =\"taches\"  ACTION=\"tache_enregistre.php\" METHOD=\"get\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
if($_REQUEST['id_tache'] > 0)
{
	$requete = "SELECT * from tache WHERE tache_ID = '$_GET[id_tache]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	print("<INPUT TYPE=\"hidden\" NAME = \"no_tache\" VALUE = \"$rub[0]\">");
}
print("Descriptif de la tâche:");
print("<BR>");

print("<TABLE 100%>");
	print("<TR>");
		print("<TD>");
		print("nom:");
		print("</TD>");
		print("<TD>");
		print("<INPUT TYPE=\"input\" NAME=\"tache\" VALUE=\"$rub[tache_nom]\" size=\"20\">");
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>");
		print("priorité:");
		print("</TD>");
		print("<TD>");
		print("<INPUT TYPE=\"input\" NAME=\"priorite\" VALUE=\"$rub[tache_priorite]\">");
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>");
		print("valider");
		print("</TD>");
		print("<TD>");
		print("<INPUT TYPE=\"submit\" NAME=\"ok\" VALUE=\"valider\">");
		print("</TD>");
	print("</TR>");
print("</TABLE>");
print("commentaires:");
print("<TEXTAREA COLS=\"35\" ROWS=\"6\" NAME=\"comment\">$rub[tache_comment]</TEXTAREA><br>");

//if($_GET[fait]) $date=date("Y-m-j H:m");
if($rub[tache_faite]=="o"){
	$check = "checked";
}
else {
	$check = "";
}
print("<br><input type=\"checkbox\" name=\"fait\" value=\"o\" $check> tâche effectuée<br>");

print("</FORM>");
print("</BODY>");
print("</html>");
?>
