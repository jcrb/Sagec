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
//													//
//	programme: 		apa_territoire.php							//
//	date de cr�ation: 	03/10/2003								//
//	auteur:			jcb									//
//	description:		associe une liste de communes � une APA avec les d�lais de route	//
//	version:		1.2									//
//	maj le:			02/11/2003	suppression bouton recherche				//
//													//
//---------------------------------------------------------------------------------------------------------
session_start();

//if(! $_SESSION['auto_sagec'])header("Location:logout.php");

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

print("<FORM name =\"Territoire\"  ACTION=\"apa_territoire_enregistre.php\" METHOD=\"GET\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete="SELECT org_nom FROM organisme WHERE org_ID = '$_SESSION[organisation]'";
$resultat = ExecRequete($requete,$connexion);
$rub = mysql_fetch_array($resultat);
$organisme = $rub[0];

entete_sagec($organisme);print("<BR>");

print("<Table width=\"100%\" class=\"time\">");
print("<TR align=\"center\">");
	print("<TD>Organisme: </TD>");
	print("<TD>");print($organisme);print("</TD>");
print("</TR>");
print("<TR>");
print("</TR>");
print("<TR valign=\"top\" align=\"center\">");
	print("<TD>Commune</TD>");
	print("<TD>");select_commune($connexion,$item_select,$langue,$change="");print("</TD>");//commune_id
	print("<TD class=\"time_r\">D�lai de route (mn)</TD>");
	print("<TD>");print("<INPUT TYPE=\"TEXT\" NAME=\"delai\" value=\"5\" size=\"3\">");print("</TD>");
	print("<TD>");print("<INPUT TYPE=\"submit\" NAME=\"ok\" value=\"valider\">");print("</TD>");
	print("<TD class=\"time_v\">Territoire</TD>");
	print("<TD rowspan=\"4\">");select_territoire($connexion,$_SESSION['organisation'],$langue,$change="");print("</TD>");
print("</TR>");
print("<TR align=\"center\">");
	print("<TD rowspan=\"4\" colspan=\"4\">");
	Print("Vous pouvez d�dinir votre propre territoire d'intervention en s�lectionnant une ou plusieurs communes. pour chaque commune, il faut pr�ciser le d�lai de route, puis valider. En cas d'erreur, s�lectionner la commune erron�e dans la colonne territoire et cliquer sur supprimer");
	print("</TD>");
	//print("<TD>&nbsp;</TD>");
	//print("<TD>&nbsp;</TD>");
	//print("<TD>&nbsp;</TD>");
	print("<TD>");print("<INPUT TYPE=\"submit\" NAME=\"ok\" value=\"supprimer\">");print("</TD>");
print("</TR>");
print("</Table>");

print("<a href = \"../apa_menu.php\" class=\"time_r\">Menu principal</a><br>");
print("</FORM>");
print("</BODY>");
print("</HTML>");

?>