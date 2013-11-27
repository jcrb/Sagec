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
//	programme: 		modifie_fichier.php
//	date de création: 	21/08/2007
//	auteur:			jcb
//	description:	manipulation de dossiers et de fichiers
//						commencer par ../mon_dossier
//	version:			1.0
//	maj le:			21/08/2007
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
require_once("./../file_manip.php");
$langue = $_SESSION['langue'];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
print("<head>");
print("<title>F2T</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");
//================================================================================
print("<BODY>");
print("<FORM name=\"filemanip\" method=\"post\" action=\"modifie_fichier.php\">");

if($_POST['button1']=='OK')
{
	switch($_POST['choix'])
	{
		case 1:
			if(mkdir($_POST['new_dossier'],0777))
			print("le dossier ".$_POST['new_dossier']." a été créé");
			else print("Echec de la création du dossier ".$_POST['new_dossier']);
			print("<br>");
			break;
		case 5:
			if(remove_file($_POST['new_dossier']))
				print("le fichier ".$_POST['new_dossier']." a été supprimé");
				else print("Echec de la sppression du fichier ".$_POST['new_dossier']);
			break;
		case 6:
			if(rename_file($_POST['new_dossier'], $_POST['$new_name']))
				print("le fichier ".$_POST['new_dossier']." a été renommé");
				else print("Echec du renommage du fichier ".$_POST['new_dossier']);
			break;
	}
	
}

print("<br>");
print("<br><input type=\"radio\" name=\"choix\" value=\"1\">Créer un dossier dans SAGEC");
print("<br><input type=\"radio\" name=\"choix\" value=\"2\">Supprimer un dossier dans SAGEC");
print("<br><input type=\"radio\" name=\"choix\" value=\"3\">Renommer un dossier dans SAGEC");
print("<br><input type=\"radio\" name=\"choix\" value=\"4\">Créer un fichier dans SAGEC");
print("<br><input type=\"radio\" name=\"choix\" value=\"5\">Supprimer un fichier dans SAGEC");
print("<br><input type=\"radio\" name=\"choix\" value=\"6\">Renommer un fichier dans SAGEC");
print("<table><br>");
print("<tr>");// fichier à charger
	print("<td>nom du dossier ou du fichier</td>");
	print("<td><input type=\"file\" lang=\"fr\" name=\"new_dossier\" value=\"../\"size=\"50\"></td>");
print("</tr>");
print("<tr>");
	print("<td>nouveau nom (si indiqué)</td>");
	print("<td><input type=\"text\" lang=\"fr\" name=\"new_name\" value=\"\"size=\"50\"></td>");
	print("</tr>");
print("<tr>");
	print("<td><input type = \"submit\" name = \"button1\" value=\"OK\"></td>");
print("</tr>");
print("<table>");
print("</BODY>");
?>
