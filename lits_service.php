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
//	programme: 		lits_service
//	date de création: 	15/08/03
//	auteur:			jcb
//	description:		Affiche la liste des services d'un hôpital donné
//	version:			1.3
//	maj le:			10/09/2005
//	@version $Id: lits_service.php 30 2008-01-23 15:58:04Z jcb $
//--------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "";
require("dbConnection.php");
require "utilitairesHTML.php";
require 'utilitaires/globals_string_lang.php';
require ("menu_gestion_lits.php");
require ("services_utilitaires.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
include_once($backPathToRoot."login/init_security.php");

print("<html>");
print("<head>");
print("<title> menu service </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
?>
<script>
var fenetreContact
function cree_fenetreContact(id,truc)
{
	var nom = "service";
	url="intervenant_info.php?personne_id="+ id +"&nom="+ nom +"&nature_contact=4";
	//url="intervenant_info.php?personne_id="+ id +"&nature_contact=4";
	fenetreContact = window.open(url, "fenetreContact","width=300, height=20, location=no,toolbar=no,scrollbars=yes,resizable=yes,directories=no,status=no");
}
</script>
<?php
print("</head>");

print("<BODY>");
print("<FORM name=\"menu\" method=\"get\" action=\"lits_service.php\">");
// Affichage de l'entête
//MenuLits($langue);
$titre = $string_lang['GESTION_LITS'][$langue];
menu_lits($langue,$titre);
//------------------ Choix de l'hopital et du service -----------------------------------------------------
// choix de l'hôpital
$mot = $string_lang['LISTE_SERVICE_HOPITAL'][$langue];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
TblDebut(0,"100%",2,4,"time");
	TblDebutLigne();
		$mot = $string_lang['SELECT_HOPITAL'][$langue];
		TblCellule("$mot");
			print("<TD>");
				select_hopital($connexion,$_GET['ID_hopital'],$langue);// retourne ID_hopital
			print("</TD>");
		$mot = $string_lang['SELECT_SERVICE'][$langue];
		TblCellule("$mot");
			print("<TD>");
			SelectTypeService($connexion,$_GET['type_s'],$langue);
			print("</TD>");
		print("<TD>");

$back = "lits_service.php";
$dp=$_GET['dpt'];
			print("<a href=\"lits_imprime.php?hop=$_GET[ID_hopital]&serv=$_GET[type_s]&langue=$langue&back=$back&dp=$_GET[dpt]&tri=$_GET[tri]\" target=\"_blank\">imprimer</a>");
		print("</TD>");
		
		$mot = $string_lang['VALIDER'][$langue];
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\" ");
	TblFinLigne();
TblFin();

//------------------ Liste des pays ----------------------------------------------------------------------
if($_GET['type_s']==10) // brûlés
{
	print("<fieldset class=\"Style22\">");print("<legend>Choisir les pays actifs</legend>");
	TblDebut(0,"100%");
	print("<table width = \"100%\" bgcolor=\"#cccccc\">");
	TblDebutLigne();
	$requete="SELECT * FROM pays ORDER BY pays_nom";
	$resultat = ExecRequete($requete,$connexion);
	$n=0;
	while($rub = mysql_fetch_array($resultat))
	{
		$mot = $string_lang[$rub['pays_nom']][$langue];
		if(!$mot)$mot=$rub['pays_nom'];
		if(count($_GET['dpt']) && in_array($rub[pays_ID],$_GET['dpt']))
			print("<TD class=\"Style22\"><input type =\"checkbox\" Checked name=\"dpt[]\" value=\"$rub[pays_ID]\" >$mot</TD>");
		else
			print("<TD class=\"Style22\"><input type =\"checkbox\" name=\"dpt[]\"value=\"$rub[pays_ID]\"><class=\"time\">$mot</TD>");
		$n++;
		if($n>10){
			$n=0;
			print("</tr><tr>");
		}
	}
	TblFinLigne();
	TblFin();
	print("</fieldset>");
}
else
{
//------------------ Liste des départements ---------------------------------------------------------------
	print("<fieldset class=\"Style22\">");print("<legend>Choisir les départements actifs</legend>");
	TblDebut(0,"100%");
	print("<table width = \"100%\" bgcolor=\"#cccccc\">");
	TblDebutLigne();
	$requete="SELECT * FROM departement ORDER BY departement_id";
	$resultat = ExecRequete($requete,$connexion);
	while($rub = mysql_fetch_array($resultat))
	{
		if(count($_GET['dpt']) && in_array($rub[departement_ID],$_GET['dpt']))
		print("<TD class=\"Style22\"><input type =\"checkbox\" Checked name=\"dpt[]\" value=\"$rub[departement_ID]\" >$rub[departement_ID]</TD>");
		else
		print("<TD class=\"Style22\"><input type =\"checkbox\" name=\"dpt[]\" value=\"$rub[departement_ID]\"><class=\"time\">$rub[departement_ID]</TD>");
	}
}
print("</TD>");
TblFinLigne();
TblFin();
print("</fieldset>");
//----------------------------------------------------------------------------------------------------------
$back = "lits_service.php";
$tri=$_GET['tri'];
Table_Lits3($connexion,$_GET['ID_hopital'],$_GET['type_s'],$langue,$back,$_GET['dpt'],$tri,'true');

print("</FORM>");
print("</BODY>");
print("</html>");
?>
