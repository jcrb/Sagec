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
//	programme: 		modifier_lits.php
//	date de cr�ation: 	30/08/2005
//	auteur:			jcb
//	description:		Affiche le journal des lits dispo pour un service donn�
//	version:			1.0
//	maj le:			15/08/2005
//
//--------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_hopital'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../../pma_connect.php");
require("../../pma_connexion.php");
require '../../utilitaires/globals_string_lang.php';
require "../../utilitairesHTML.php";
require "../../date.php";

print("<html>");
print("<head>");
print("<title> modifier_lits </title>");
print("<LINK REL=stylesheet HREF=\"../../pma.css\" TYPE =\"text/css\">");
print("<LINK REL = \"stylesheet\" TYPE = \"text/css\" HREF = \"../service.css\">");
print("</head>");

print("<form name=\"services\" method=\"get\" action=\"saisie_rapide.php\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$service = $_GET['service'];
$service_nom = $_GET['nom'];
print("Identifiant du service: ".$service."<br>");
print("Nom du service: ".$service_nom);

$requete="SELECT * FROM lits_journal WHERE service_ID = '$service' ORDER BY date";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
while($rub=mysql_fetch_array($resultat))
{
	$mot = $string_lang['MODIFIER'][$langue];
	print("<tr><td>".uDate2Frenchdatetime($rub[date])."</td><td>$rub[lits_dispo]</td><td><a href=\"\">$mot</a></td></tr>");
}
print("</table>");
?>