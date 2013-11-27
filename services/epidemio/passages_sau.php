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
//	programme: 		passages_sau.php
//	date de cr?ation: 	19/04/2005
//	auteur:			jcb
//	description:		donn?es ?pid?miologiques du SAU
//	version:			1.1
//	maj le:			24/06/2005
//
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
//if(! $_SESSION['auto_hopital'])header("Location:../logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../../pma_connect.php");
require("../../pma_connexion.php");
require("../../pma_requete.php");

print("<head>");
print("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-15\">");
print("<title>SAU</title>");
print("<LINK REL = \"stylesheet\" TYPE = \"text/css\" HREF =\"style.css\">");
print("</head>");
include("passage_sau_sup.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$modifie = FALSE; // nouvel enregistrement ou maj ?

//================================ Données SAU =============================================

print("<form name=\"passages\" action=\"passage_sau_enregistre.php\" method=\"get\">");

print("<INPUT TYPE=\"HIDDEN\" name=\"service\" VALUE=\"$_GET[service]\">");

if($_GET['enregistrement'])// si la var existe, récupérer les valeurs
{
	$requete = "SELECT * FROM veille_sau WHERE veille_ID='$_GET[enregistrement]'";
	$resultat = ExecRequete($requete,$connexion);
	$val = mysql_fetch_array($resultat);
	$modifie = TRUE;
}else //vérifie si déjà un enregistrement pour ce jour
{
	$today = mktime(0,0,0,date('m'),date('j')-1,date('Y'));
	print($today);
	$requete = "SELECT * FROM veille_sau WHERE date ='$today'AND service_ID='$_GET[service]'";
	$resultat = ExecRequete($requete,$connexion);
	$val = mysql_fetch_array($resultat);
}

print("<br>");

$date_fr="j/m/Y";
$date_us="Y/m/j";
print("<table bgcolor=\"#ccccff\" width=\"75%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
print("<TR>");
	print("<TD>Date</TD>");
	if($val['date']) $today = date($date_us,$val['date']);
	else $today = date("Y/m/j",mktime(0,0,0,date('m'),date('j')-1,date('Y')));
	print("<TD><input type=\"text\" class=\"date\" name=\"date\" value=\"$today\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre de passages de moins de 1 an</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_1_an\" value=\"$val[inf_1_an]\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre de passages de plus de 75 ans</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_75_an\" value=\"$val[sup_75_an]\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre de passages de 1 à 75 ans</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_1_a_75_an\" value=\"$val[entre1_75]\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre d'hospitalisations (hors UHCD)</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_hospitalise\" value=\"$val[hospitalise]\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre d'hospitalisation en UHCD</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_uhcd\" value=\"$val[uhcd]\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Nombre de transports vers un autre établissement</TD>");
	print("<TD><input type=\"text\" class=\"nombre\" name=\"nb_transferts\" value=\"$val[transfert]\"></TD>");
print("</TR>");
print("</table>");
print("<br><input type=\"submit\" class=\"ok\" name=\"ok\" value=\"valider\">");
if($_SESSION['autorisation']>8)
	print("<input type=\"submit\" class=\"ok\" name=\"ok\" value=\"supprimer\">");
print("</form>");
?>
