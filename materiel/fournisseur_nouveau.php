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
//	programme: 		a.php
//	date de cr?ation: 	2004
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			2004
//
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
require("../pma_requete.php");
require("../pma_connect.php");
require("../pma_connexion.php");
include("../html.php");
include("materiel_utilitaires.php");

//======================= En T?te ====================================
print("<HTML><HEAD>");
print("<TITLE>Fournisseur</TITLE>");
print("<LINK REL=stylesheet HREF=\"./../pma.css\" TYPE =\"text/css\">");
print("</HEAD>");
//====================== Corps =======================================
print("<BODY>");
print("<FORM NAME=\"\" ACTION=\"fournisseur_enregistre.php\" METHOD=\"GET\">");
print("<input type=\"hidden\" name=\"back\" value=\"$_GET[back]\">");
entete_sagec("Fournisseur");

print("<br><table class=\"Style24\">");
print("<TR>");
	print("<TD class=\"grise\">nom</TD>");
	print("<TD><input type=\"text\" name=\"nom\" value=\"\"></TD>");
	print("<TD><input type=\"submit\" name=\"bouton\" value=\"Enregistrer\"></TD>");
print("</TR>");
print("<TR>");
print("<TD class=\"blue\"><a href=$_GET[back]>Retour</a> </TD>");
print("</TR>");

//$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//liste_fournisseurs($connexion,$item_select,$langue,$change="");

print("</table>");

print("</FORM>");
print("</BODY>");
print("</HTML>");
?>
