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
//
//	programme: 		choix_lire_table.php
//	date de cr�ation: 	10/11/2004
//	auteur:			jcb
//	description:		choisir une table � downloader
//	version:			1.2
//	maj le:			10/11/2004
//
//--------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
if(!$_SESSION["autorisation"]>8) header("Location:".$backPathToRoot."logout.php");
//include_once($backPathToRoot."dbConnection.php");

include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require("../html.php");
require("utilitaires_table.php");
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

/**
*Cr�e et affiche une liste d�roulante des tables de la base de donn�es.
*@package choix_export_table.php
*@return int $table contient la table s�lectionn�e.
*@param string variable de connexion.
*@version 1.0
*/
/*
function listetable($connect)
{
	$requete = "SHOW TABLES";
	$resultat = ExecRequete($requete,$connect);
	print("<select name=\"table\" size=\"1\" onChange='$onChange'>");
	$mot = "-- aucune --";
	print("<OPTION VALUE = \"$mot\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[0]\" ");
		if($item_select == $rub[0]) print(" SELECTED");
		print("> $rub[0] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
*/
print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");
print("<FORM name =\"taches\"  ACTION=\"modifie_table.php\" METHOD=\"post\">");

print("R�cup�rer le contenu d'une table<br><br>");
print("Nom de la table: ");
listetable($connect);
//print("<input type=\"text\" name=\"table\" value=\"$v\">");
print("<INPUT TYPE=\"submit\" NAME=\"ok\" VALUE=\"valider\">");
print("<a href=\"../administrateur_menu.php\"> Retour au menu pr�c�dant</a>");
print("</FORM>");
print("</HTML>");
?>
