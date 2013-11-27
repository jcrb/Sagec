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
//	programme: 		centaure.php
//	date de création: 	06/02/2005
//	auteur:			jcb
//	description:		Met le contenu du fichier dans une table
//	version:			1.0
//	maj le:			06/02/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require "../classe_dessin.php";
require("utilitaires_table.php");
$langue = $_SESSION['langue'];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
print("<head>");
print("<title>F2T</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");
//================================================================================
print("<BODY>");
print("<FORM name=\"menu\" method=\"post\" enctype=\"multipart/form-data\" action=\"centaure_execute.php\">");

print("Saisie de données à partir d'un fichier 'TEXT' créé à partir de Centaure 15<br><br>");
print("<table>");
print("<tr>");// fichier à charger
	print("<td>Fichier source</td>");
	print("<td><input type=\"file\" lang=\"fr\" name=\"fichier\" size=\"50\"></td>");
	print("<td><input type = \"submit\" name = \"ok\" value=\"Valider\"></td>");
print("<table>");
print("</BODY>");
?>
