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
//	programme: 		dossier_med.php
//	date de création: 	12/11/2004
//	auteur:			jcb
//	description:		Fonctionalité permise à l'administrateur
//	version:			1.2
//	maj le:			14/10/2004
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../date.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma2.css\" TYPE =\"text/css\"></HEAD>");

print("<FORM name =\"veille\"  ACTION=\"veille_enregistre.php\" METHOD=\"get\">");
$today="";
if($_GET['enregistrement'])// si la var existe, récupérer les valeurs
{
	$requete = "SELECT * FROM veille_samu WHERE veille_samu_ID='$_GET[enregistrement]'";
	$resultat = ExecRequete($requete,$connexion);
	$val = mysql_fetch_array($resultat);
	$today = uDate2French($val['date']);
}else //vérifie si déjà un enregistrement pour ce jour
{
	$today = mktime(0,0,0,date('m'),date('j')-1,date('Y'));
	//print($today);
	$requete = "SELECT * FROM veille_samu WHERE date ='$today'AND service_ID = '$_SESSION[service]'";
	$resultat = ExecRequete($requete,$connexion);
	$val = mysql_fetch_array($resultat);
	$today = date("j/m/Y",$today);
}

//if($today="")
//	$today = date("j/m/Y");

print("Pour un SAMU <br>");
print("<br>");
print("<table bgcolor=\"#ccccff\" width=\"75%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
print("<TR>");
	print("<TD>Date</TD>");
	print("<TD><input type=\"text\" class=\"date\" name=\"date\" value=\"$today\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre d'affaires traitées traitées par le SAMU</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_affaires\" value=\"$val[nb_affaires]\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre de primaires SMUR</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_primaires\" value=\"$val[nb_primaires]\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre de secondaires SMUR</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_secondaires\" value=\"$val[nb_secondaires]\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre de transports néonataux</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_neonat\" value=\"$val[nb_neonat]\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre de transports infirmiers inter-hospitaliers</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_tiih\" value=\"$val[nb_tiih]\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre de transports par ambulances privées demandés par le SAMU</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_apa\" value=\"$val[nb_apa]\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre d'interventions SDIS déclenchées par le SAMU (a l'exclusion des prompt-secours déclenchés par le SDIS)</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_vsav\" value=\"$val[nb_vsav]\"></TD>");
print("</TR>");
// Demandes non exigées par l'INVS
print("<TR>");
	print("<TD>Nombre de conseils médicaux</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_conseils\" value=\"$val[conseils]\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre d'envoi de médecins</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_med\" value=\"$val[nb_med]\"></TD>");
print("</TR>");
print("</table>");
print("<br><input type=\"submit\" name=\"samu\" value=\"valider\">");
print("</form>");
?>
