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
/**	programme: 			evenement_nouveau.php
*	date de création: 	12/11/2004
*	@author:			jcb
*	description:		Fonctionalité permise à l'administrateur
*	@version:			1.2 - $Id: evenement_nouveau.php 23 2007-09-21 03:50:41Z jcb $
*	maj le:				14/10/2004
*	@package			Sagec
*/
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>100) header("Location:../logout.php");
$backPathToRoot = "../";
include($backPathToRoot."html.php");
require($backPathToRoot."pma_connect.php");
require($backPathToRoot."pma_connexion.php");
require $backPathToRoot.'utilitaires/requete.php';
require $backPathToRoot.'utilitaires/liste.php';
include_once($backPathToRoot."date.php");


//
$langue = $_SESSION['langue'];
//
// ENTETE
print("<html>");
print("<head>");
print("<title> Evènement courant </title>");
print("<meta name=\"author\" content=\"JCB\">");
print("<LINK REL=stylesheet HREF=\"".$backPathToRoot."pma.css\" TYPE =\"text/css\">");
print("</head>");

// CORPS
print("<BODY>");
print("<FORM ACTION =\"evenement_create.php\" METHOD=\"get\">");
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);



//================================================ Debut ======================================================
// affichage du texte
$requete = "SELECT * FROM evenement WHERE evenement_ID = '$_SESSION[evenement]'";
$resultat = ExecRequete($requete,$connect);
$rub=mysql_fetch_array($resultat);
// on enregistre dans un champ caché la valeur de l'évènement courant précédant
print("<input type=\"hidden\" name=\"ev_courant_prec\" value=\"$rub[evenement_ID]\">");
print("<table>");
/*
print("<TR>");
	print("<TD>Evènement courant</TD>");
	print("<TD><input type=\"text\" name=\"ev_courant\" value=\"$rub[evenement_nom]\" size=\"50\"></TD>");
	print("<TD><input type=\"submit\" name=\"ok\" value=\"Valider\"></TD>");
print("</TR>");
*/
print("<TR>");
	print("<TD>Nouvel évènement</TD>");
	print("<TD><input type=\"text\" name=\"titre\" value=\"\" size=\"50\"></TD>");
	print("<TD><input type=\"submit\" name=\"ok\" value=\"Valider\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Date de création</TD>");
	$date = date("Y-m-j");
	print("<TD><input type=\"text\" name=\"date1\" value=\"$date\" size=\"10\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Heure de création</TD>");
	$heure = date("H:i:s");
	print("<TD><input type=\"text\" name=\"heure1\" value=\"$heure\" size=\"10\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Commentaires</TD>");
	print("<TD><TEXTAREA name=\"comment\" value=\"$rub[comment]\" cols=\"50\" rows=\"5\"></textarea></TD>");
print("</TR>");
print("<TR>");
	print("<TD>N° dossier SAMU</TD>");
	print("<TD><input type=\"text\" name=\"dossier_samu\" value=\"$rub[dossier_samu]\" size=\"10\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>N° dossier SDIS</TD>");
	print("<TD><input type=\"text\" name=\"dossier_sdis\" value=\"$rub[dossier_sdis]\" size=\"10\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>PPI associé</TD>");
	print("<TD>");
		$null["aucun"]=0;
		genere_select("ppi_id", "ppi","ppi_ID","ppi_nom",$connect,'',$null,'','',false);
	print("</TD>");
print("</TR>");
print("<TR>");
	print("<tr><td><input type=\"checkbox\" name=\"actif\" value=\"o\" checked> en faire l'évènement ACTIF ?</tr>");
	print("<tr><td><input type=\"checkbox\" name=\"chantier\" value=\"o\" checked> créer un premier chantier</tr>");
	print("<tr><td><input type=\"checkbox\" name=\"pma\" value=\"o\" checked> créer un premier PMA</tr>");
	print("<tr><td><input type=\"checkbox\" name=\"pco\" value=\"o\" checked> créer un premier PCO</tr>");
print("</TR>");

print("</table>");
print("</BODY>");
print("</FORM>");
print("</html>");
?>
