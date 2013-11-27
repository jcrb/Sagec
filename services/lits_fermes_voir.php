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
/**
*	programme: 			lits_fermes_voir.php
*	@date de création: 	23/03/2005
*	@author:			jcb
*	description:		affiche la liste des services d'un établissement et le nombre de lits fermés
*						à une date donnée (du jour par défaut)
*	@version:			1.1 - $Id: lits_fermes_voir.php 10 2006-08-17 22:41:56Z jcb $
*	maj le:				08/08/2006
*	@package			Sagec
*/
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
if(!($_SESSION['auto_hopital']||$_SESSION['auto_service']||$_SESSION['auto_organisme']))header("Location:../logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require '../utilitaires/globals_string_lang.php';
require "../utilitairesHTML.php";
require("../date.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
print("<title> services à modifier </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("<LINK REL = \"stylesheet\" TYPE = \"text/css\" HREF = \"service2.css\">");
print("</head>");

print("<FORM name=\"voir_lits_fermes\" action=\"\">");


//print("session service: ".$_SESSION["service"]."<br>");
//$mot = $string_lang['LISTE_SERVICE_HOPITAL'][$langue];
$mot="Etat des fermetures de lits";
print("<H3>$mot</H3>");
$_service=$_GET['_service'];
$service_nom=$_GET['nom'];
print("<input type=\"hidden\" name=\"_service\" value=\"$_service\">");
print("<input type=\"hidden\" name=\"nom\" value=\"$service_nom\">");

$requete = "SELECT * FROM lits_fermes WHERE service_ID = '$_service' ORDER BY debut";
//print($requete);
$resultat = ExecRequete($requete,$connexion);

print("<FIELDSET>");
print("<legend>$service_nom</legend>");
print("<TABLE WIDTH=\"100%\" CLASS=\"Style22\">");
print("<tr>");
	print("<th>modifier</th>");
	print("<th>supprimer</th>");
	print("<th>début</th>");
	print("<th>fin</th>");
	print("<th>nombre de lits fermés</th>");
	print("<th>mise à jour</th>");
print("</tr>");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
	print("<th><A href=\"lits_fermes_nouveau.php?enregistrement=$rub[lits_ferme_id]\">modifier</A></th>");
	print("<th><A href=\"lits_fermes_voir.php?_service=$_service&supprimer=$rub[lits_ferme_id]\">supprimer</A></th>");
	print("<td>".uDate2French($rub[debut])."</td>");
	print("<td>".uDate2French($rub[fin])."</td>");
	print("<td>$rub[nb_lits_fermes]</td>");
	print("<td>".uDate2French($rub[date_maj])."</td>");
	print("</tr>");
}
print("</TABLE>");
print("</FIELDSET>");

print("</FORM>");
print("</BODY>");
print("</html>");
?>
