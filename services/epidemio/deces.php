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
/**	programme: 			deces.php
* @date de création: 	19/04/2005
* @author:			jcb
* description:		données épidémiologiques du SAU
* @version:			1.1
* @package Sagec
* @version $Id$
* maj le:				18/11/2006 - Ajout de la vérification javascript
*						03/01/2007 - Ajout de parseInt pour forcer le type des var d1 et d2, sinon erreur ds les tests
*/
//--------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_hopital'])header("Location:../logout.php");
require '../../utilitaires/globals_string_lang.php';
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../../pma_connect.php");
require("../../pma_connexion.php");
require("../../pma_requete.php");

print("<head>");
print("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-15\">");
print("<title>Convertisseur euros - dollars</title>");
?>
<script>
 function verifier()
 {
 	var date = document.forms[0].elements[0].value;// date saisie
	var delim1 = date.indexOf("/");// positionnement des séparateurs
	var delim2 = date.lastIndexOf("/");
	var year = parseInt(date.substring(0,delim1),10);// isolement de l'année, du mois, du jour
	var mois = parseInt(date.substring(delim1+1,delim2),10);
	var day = parseInt(date.substring(delim2+1),10);
	date2 = new Date();// date courante
	if(year - date2.getFullYear() > 0){
		alert("Il y a un problème avec l'année");
		return false;
	}
	if(mois < 1 || mois > 12){
		alert("Il y a un problème avec le mois");
		return false;
	}
	if(day < 1 || day > 31){
		alert("Il y a un problème avec le jour");
		return false;
	}
	var d1 = parseInt(document.forms[0].elements[1].value);
	var d2 = parseInt(document.forms[0].elements[2].value);
	
	if(d2 > d1 || d1<0 || d2 <0) {
		alert(year + ' Données incohérentes'+d1+' '+d2);
		return false;
	}
	return true;
 }
</script>
<?php
print("</head>");
include("deces_sup.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

//================================ Données SAU =============================================

print("<form name=\"passages\" action=\"deces_enregistre.php\" method=\"get\" onSubmit=\"return verifier()\">");

if($_GET['enregistrement'])// si la var existe, récupérer les valeurs
{
	$requete = "SELECT * FROM veille_dg WHERE veille_dg_ID='$_GET[enregistrement]'";
	$resultat = ExecRequete($requete,$connexion);
	$val = mysql_fetch_array($resultat);
}

print("<br>");
if($_GET[erreur] == 1) print("L'enregistrement existe déjà<br>");

print("<table bgcolor=\"#ccccff\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
print("<TR>");
	$mot=$string_lang["DATE"][$langue];
	print("<TD>".$mot." (aaaa/mm/jj)</TD>");
	if($val['date']) $today = date("Y/m/j",$val['date']);
	else $today = date("Y/m/j");
	print("<TD><input type=\"text\" name=\"date\" value=\"$today\"></TD>");
print("</TR>");
print("<TR>");
	$mot=$string_lang["NOMBRE_DE_DECES"][$langue];
	print("<TD>$mot</TD>");
	print("<TD><input type=\"text\" name=\"nb_deces\" value=\"$val[nb_tot_dcd]\"></TD>");
print("</TR>");
print("<TR>");
	$mot=$string_lang["NOMBRE_DE_DECES_75"][$langue];
	print("<TD>$mot</TD>");
	print("<TD><input type=\"text\" name=\"nb_deces_75an\" value=\"$val[nb_dcd_sup75]\"></TD>");
print("</TR>");

print("</table>");
$mot=$string_lang["VALIDER"][$langue];
print("<br><input type=\"submit\" name=\"sau\" value=\"$mot\">");
print("</form>");
?>
