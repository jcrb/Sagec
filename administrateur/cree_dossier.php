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
//	programme: 		cree_dossier.php
//	date de cr�ation: 	03/06/2005
//	auteur:			jcb
//	description:		cr�e un dossier. Par d�faut le dossier est cr�� dans le dossier
//					administrateur. Pour le cr��r dans le dosier principal,
//					commencer par ../mon_dossier
//	version:			1.0
//	maj le:			03/06/2005
//
//--------------------------------------------------------------------------------
//
session_start();
if(!$_SESSION['admin_id'])header("Location:logout.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("utilitaires_table.php");
$langue = $_SESSION['langue'];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
print("<head>");
print("<title>F2T</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");
//================================================================================
print("<BODY>");
print("<FORM name=\"menu\" method=\"post\" action=\"cree_dossier.php\">");

if($_POST['new_dossier'])
{
	if(mkdir($_POST['new_dossier'],0777))
		print("le dossier ".$_POST['new_dossier']." a �t� cr��");
	else print("Echec de la cr�ation du dossier ".$_POST['new_dossier']);
	print("<br>");
}

print("<br>Cr�er un dossier dans SAGEC<br><br>");
print("<table>");
print("<tr>");// fichier � charger
	print("<td>nom du dossier</td>");
	print("<td><input type=\"text\" lang=\"fr\" name=\"new_dossier\" value=\"../\"size=\"50\"></td>");
	print("<td><input type = \"submit\" name = \"ok\" value=\"Valider\"></td>");
print("</tr>");
print("<table>");
print("</BODY>");
?>
