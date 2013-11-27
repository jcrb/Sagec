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
//	programme: 		lits_fermes_nouveau.php
//	date de création: 	23/03/2005
//	auteur:			jcb
//	description:		service à modifier
//	version:			1.1
//	maj le:			03/09/2005
//
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

print("<html>");
print("<head>");
print("<title> services à modifier </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("<LINK REL = \"stylesheet\" TYPE = \"text/css\" HREF = \"service2.css\">");
print("</head>");

print("<FORM name=\"nouveu_lits_fermes\" action=\"lits_fermes_enregistre.php\">");

//print("session service: ".$_SESSION["service"]."<br>");

if($_GET['erreur']!=0)
{
	print("<DIV class=\"alerte\">");
	switch($_GET['erreur']){
		case 1:print("Le service n'existe pas");break;
		case 2:print("Il manque la date de début");break;
		case 3:print("Il manque la date de fin");break;
		case 4:print("Il manque le nombre de lits fermés");break;
		case 5:print("Les dates sont erronées ou incompatibles ".$_GET['erreur']);break;
		case 8:print("Les dates sont erronées ou incompatibles ".$_GET['erreur']);break;
		case 6:print("Le nombre de lits fermés doit au moins être égal à 1");break;
		case 7:print("Il y a déjà des lits fermés pour cette période");break;
	}
	print("</DIV>");
}
//print("session service: ".$_SESSION["service"]."<br>");
//$mot = $string_lang['LISTE_SERVICE_HOPITAL'][$langue];
if($_GET['enregistrement'])
{
	$mot="Modifier une période de fermeture de lits";
	$requete = "SELECT lits_fermes.service_ID,debut,fin,nb_lits_fermes,service_nom
			FROM lits_fermes,service
			WHERE lits_ferme_id = '$_GET[enregistrement]'
			AND service.service_ID = lits_fermes.service_ID
			";
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	$_service=$rub['service_ID'];
	$service_nom = $rub['service_nom'];
	$vd = date("j/m/Y",$rub['debut']);
	$vf = date("j/m/Y",$rub['fin']);
	$lf = $rub['nb_lits_fermes'];
}
else
{
	$mot="Ajouter une nouvelle période de fermeture de lits";
	$_service=$_GET['_service'];
	$service_nom=$_GET['nom'];
	$vd = $_GET['debut'];
	if(!$vd)$vd=date("j/m/Y");
	$vf = $_GET['fin'];
	if(!$vf)$vf=date("j/m/Y");
	$lf = $_GET['lits_fermes'];
}
print("<H3>$mot</H3>");

print("<input type=\"hidden\" name=\"_service\" value=\"$_service\">");
print("<input type=\"hidden\" name=\"nom\" value=\"$service_nom\">");
print("<input type=\"hidden\" name=\"enregistrement\" value=\"$_GET[enregistrement]\">");

/** Variables transmises
*@param $debut date de début de la fermeture
*@param $fin date de fin de la fermeture
*@param $lits_fermes nombre de lits fermés
*/
print("<FIELDSET>");
print("<legend>$service_nom</legend>");
print("<TABLE WIDTH=\"100%\" CLASS=\"Style22\">");
print("<tr>");
print("<td>période de fermeture:</td>");
print("<td>début (jj-mm-aaaa)</td>");
//$vd = $_GET['debut'];
//if(!$vd)$vd=date("j/m/Y");
print("<td><input type=\"text\" name=\"debut\" value=\"$vd\"></td>");
print("</tr>");
print("<tr>");
print("<td>&nbsp;</td>");
print("<td>fin (jj-mm-aaaa)</td>");
//$vf = $_GET['fin'];
//if(!$vf)$vf=date("j/m/Y");
print("<td><input type=\"text\" name=\"fin\" value=\"$vf\"></td>");
print("</tr>");
print("<tr>");
print("<td>nombre de lits fermés</td>");
print("<td>&nbsp;</td>");
print("<td><input type=\"text\" name=\"lits_fermes\" value=\"$lf\"></td>");
print("<td><input type=\"submit\" name=\"ok\" value=\"valider\">");
print("</tr>");
print("</TABLE>");
print("</FIELDSET>");

print("</FORM>");
print("</BODY>");
print("</html>");
?>
