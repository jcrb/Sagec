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
//	programme: 		med_territoire.php							
//	date de création: 	08/12/2005								
//	auteur:			jcb									
//	description:	Liste des communes constituant un territoire	
//	version:		1.0									
//	maj le:			08/12/2005				
//													
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

require("../moyens_commune_menu.php");
include("../utilitairesHTML.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require '../utilitaires/globals_string_lang.php';
//require("../html.php");

print("<HTML><HEAD><TITLE>APA</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</HEAD>");

print("<BODY onload=\"document.Territoire.delai.focus()\">");

print("<FORM name =\"Territoire\"  ACTION=\"med_territoire_enregistre.php\" METHOD=\"GET\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete="SELECT org_nom FROM organisme WHERE org_ID = '$_SESSION[organisation]'";
$resultat = ExecRequete($requete,$connexion);
$rub = mysql_fetch_array($resultat);

$organisme = $rub[0];

print("<Table width=\"100%\" class=\"time\">");
print("<TR align=\"center\">");
	print("<TD>Organisme: </TD>");
	print("<TD>");print($organisme);print("</TD>");
print("</TR>");
print("<TR>");
print("</TR>");
print("<TR valign=\"top\" align=\"center\">");
	print("<TD>Commune</TD>");
	print("<TD>");select_n_commune($connexion,$item_select,$langue,$change="");print("</TD>");//commune_id
print("</TR>");
print("<TR align=\"center\">");
	print("<TD rowspan=\"4\" colspan=\"4\">");
	Print("Vous pouvez dédinir votre propre territoire d'intervention en sélectionnant une ou plusieurs communes. pour chaque commune, il faut préciser le délai de route, puis valider. En cas d'erreur, sélectionner la commune erronée dans la colonne territoire et cliquer sur supprimer");
	print("</TD>");
	print("<TD>");print("<INPUT TYPE=\"submit\" NAME=\"ok\" value=\"Ajouter\">");print("</TD>");
print("</TR>");
print("</Table>");

print("</FORM>");
print("</BODY>");
print("</HTML>");

?>
