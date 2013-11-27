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
//	programme: 		identite.php
//	date de création: 	10/06/2005
//	auteur:			jcb
//	description:		saisies de constantes
//	version:			1.0
//	maj le:			10/06/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require("../pma_requete.php");
require("../pma_connect.php");
require("../pma_connexion.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$langue = $_SESSION['langue'];

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

print("<FORM name =\"identite\"  ACTION=\"identite_enregistre.php\" METHOD=\"get\">");
print("&nbsp;<BR>");
$dossier=$_GET['dossier'];
$requete="SELECT * FROM victime WHERE victime_ID = '$dossier'";
$resultat = ExecRequete($requete,$connexion);
$rub = mysql_fetch_array($resultat);
@mysql_free_result($resultat);
//--------------------------------------------- Etat-civil ---------------------------------
print("<fieldset>");
print("<legend> Dossier n° $dossier</legend>");
print("<table bgcolor=\"#ccccff\" width=\"75%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
print("<TR>");
	print("<TD>nom <input type=\"text\" name=\"nom\" size=\"10\" value=\"$rub[nom]\"></TD>");
	print("<TD>prénom <input type=\"text\" name=\"prenom\" size=\"10\" value=\"$rub[prenom]\"></TD>");
	print("<TD><input type=\"submit\" name=\"valider\" value=\"valider\"></TD>");
print("</TR>");
print("</table>");
print("</fieldset>");
print("<FORM name>");
?>
