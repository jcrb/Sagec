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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		med_liste.php
//	date de création: 	26/10/2004
//	auteur:			jcb
//	description:		Liste des médicaments répertoriés
//	version:			1.0
//	maj le:			26/10/2004
//
//--------------------------------------------------------------------------------------------------------

session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
include("utilitaires_MED.php");

print("<html>");
print("<head>");
print("<title> Médicaments </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("<LINK REL = stylesheet TYPE = \"text/css\" HREF = \"pharma.css\">");
print("</head>");

print("<BODY BGCOLOR=\"#ffffff\" >");
print("<FORM name =\"Services\"  ACTION=\"medicament_enregistre\" METHOD=\"GET\">");

liste_med($connexion,1,$_REQUEST[tri],$_REQUEST[ordre]);

print("</FORM>");
print("</html>")
?>
