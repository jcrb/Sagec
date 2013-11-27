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
//----------------------------------------- SAGEC --------------------------------
//
//	programme: 		init.php
//	date de création: 	26/12/2003
//	auteur:			jcb
//	description:		Fonctionalité permise à l'administrateur
//	version:			1.2
//	maj le:			14/10/2004
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>8) header("Location:logout.php");

include("../html.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';

$langue = $_SESSION['langue'];

// ENTETE
print("<html>");
print("<head>");
print("<title> Evènement courant </title>");
print("<meta name=\"author\" content=\"JCB\">");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

// CORPS
print("<BODY>");
print("<FORM ACTION =\"\" METHOD=\"POST\">");
//entete_sagec("Evenement courant");
print("<table>");

$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

$requete = 	"SELECT evenement_nom, vigiepirate_niveau
			FROM alerte,evenement,vigiepirate
			WHERE alerte.evenement_ID = evenement.evenement_ID
			AND alerte.vigiepirate_ID = vigiepirate.vigiepirate_ID
			";
$resultat = ExecRequete($requete,$connect);
$rub=mysql_fetch_array($resultat);

print("<TR>");
	print("<TD>Evènement courant</TD>");
	print("<TD>");
		print("<input type=\"text\" name=\"titre\" value=\"$rub[evenement_nom]\" size=\"30\">");
	print("</TD>");
	//print("<TD>");
	//	print("<input type=\"submit\" name=\"ok\" value=\"Valider\">");
	//print("</TD>");
print("</TR>");

print("<TR>");
	print("<TD>Vigie Pirate niveau</TD>");
		$niveaux=array("BLANC","JAUNE","ORANGE","ROUGE","ECARLATE");
		$n = $niveaux[$rub['vigiepirate_niveau']];
		print("<TD><input type=\"text\" name=\"titre\" value=\"$n\" size=\"30\"></TD>");
	print("</TD>");
print("</TR>");
//print("<p><font color=\"#FF0000\"><blink><big><strong>PLAN ROUGE EN COURS</strong></big></blink></font>");
print("<t/able>");
print("</form>");
print("</body>");
print("</html>");
?>
