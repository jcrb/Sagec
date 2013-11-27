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
//		
//----------------------------------------- SAGEC --------------------------------------------------------
//
/** 		Services.php
*	date de création: 	18/08/2003
*	@author:			jcb
*	description:		Saisie/lecture des données d'un service. Seule une personne appartenant au
*						SAMU67 peut modifier le contenu de cette page (cf.ligne 301)
*	@version:			1.3 - $Id: services.php 23 2007-09-21 03:50:41Z jcb $
*	modifié le			25/06/2005
* 	@package			sagec
*/
//---------------------------------------------------------------------------------------------------------
// Création / mise à jour d'un service
// appelé par Service_maj. Le service_ID est transmis par la variable $ttservice qui vaut 0
// pour un nouveau service
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "";
$sservice=$_SESSION["service"];
include("utilitaires/table.php");
require 'utilitaires/globals_string_lang.php';
include("utilitairesHTML.php");
require("dbConnection.php");
require ("menu_gestion_lits.php");
include("contact_main.php");
include_once($backPathToRoot."login/init_security.php");

$langue = $_SESSION['langue'];
$ttservice = $_GET['ttservice'];
$back = $_GET['back'];

if($_SESSION['auto_sagec'])
	menu_lits($langue, $titre=$string_lang['SERVICE'][$langue]);

print("<html>");
print("<head>");
print("<title> Gestion des services </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
//print("<script language=\"javascript\" src=\"contact/contact_scripts.js\">");
?>
<script>
function Choix(form)
{
	document.Intervenants.submit();
}
</script>
<?php
print("</head>");
print("<DIV ALIGN=\"RIGHT\"><A HREF = \"$back?ID_hopital=$_GET[orgID]&type_s=$_GET[type_service]\">RETOUR</A></DIV>");

// cherche toutes les caractéristiques du service dont l'identifiant est $ttservice
$service_carac = ChercheService($ttservice,$connexion);
$lits_du_service = ChercheLit($service_carac->service_ID,$connexion);
//print_r($service_carac);

// création d'une form
print("<FORM name =\"Services\"  ACTION=\"service_enregistre.php\" METHOD=\"GET\">");
// mémorisation dans un champ caché de $ttservice pour se rappeler s'il s'agit d'une MAJ
// ou d'une création
print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj\" VALUE=\"$ttservice\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"back\" VALUE=\"$back\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"orgID\" VALUE=\"$_GET[orgID]\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"type_service\" VALUE=\"$_GET[type_service]\">");

//========================================= IDENTIFICATION ===============================================
print("<FIELDSET>");
$mot=$string_lang['IDENTIFICATION'][$langue];
print("<LEGEND class=\"time\"> $mot </LEGEND>");
// début du tableau
//TblDebut(0,"100%","","",time_v);
print("<table width=\"100%\" classe=\"time_v\" bgcolor=\"#ccccccff\">");
	TblDebutLigne("Style25");
		TblCellule($string_lang['SERVICE'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$service_carac->service_nom\" NAME=\"nom\" SIZE = \"30\" ");
		//TblCellule("&nbsp;");
		//TblCellule("&nbsp;");
		$mot=$string_lang['HOPITAL'][$langue].": ";
		print("<td><a href=\"hopital.php?ID_hopital=$service_carac->Hop_ID\">$mot</A></td>");
		print("<TD>");
		select_hopital($connexion,$service_carac->Hop_ID,$langue);
		print("</TD>");
		$mot=$string_lang['SAMU'][$langue].": ";
		if($service_carac->samu_id)
		{
			$retour="services.php?ttservice=$service_carac->service_ID";
			TblCellule("<a href=\"services.php?ttservice=$service_carac->samu_id&back=$retour\">$mot</A>");
		}
		else
		{
			TblCellule($mot);
		}
		print("<TD>");
		select_samu($connexion,$service_carac->samu_id);//retourne le service_ID dans samu
		print("</TD>");
	TblFinLigne();
TblFin();

print("<table width=\"100%\" classe=\"time_v\" bgcolor=\"#ccccccff\">");
	TblDebutLigne("Style25");
		print("<td>Groupe</td>");
		print("<td>");
			SelectGroupe($connexion,$service_carac->service_groupe_ID);//groupe_ID
		print("</td>");
		print("<td>Discipline</td>");
		print("<td>");
			SelectDiscipline($connexion,$service_carac->service_discipline_ID); //discipline_id
		print("</td>");
		
		TblCellule($string_lang['TYPE'][$langue]." ".$string_lang['SERVICE'][$langue].": ","Style22");
		print("<TD classe=\"Style22\">");
		selectTypeService($connexion,$service_carac->Type_ID,$langue,"document.Services.submit();");
		print("</TD>");
		TblCellule($string_lang['SPECIALITE'][$langue]);
		print("<TD classe=\"Style22\">");
		select_specialite($connexion,$service_carac->specialite_ID,$langue);
		print("</TD>");
		if($service_carac->service_adulte=='o')$c='checked';else $c='';
		print("<td><input type=\"checkbox\" name=\"adulte\" $c> ".$string_lang['ADULTE'][$langue]."</td>");
		if($service_carac->service_enfant=='o')$c='checked';else $c='';
		print("<td><input type=\"checkbox\" name=\"enfant\" $c> ".$string_lang['ENFANT'][$langue]."</td>");
		print("<td>".$string_lang['A_PARTIR'][$langue]."<input type=\"text\" name=\"age\" value=\"$service_carac->age_min\" size=\"3\">".$string_lang['ANS'][$langue]."</td>");
	TblFinLigne();
TblFin();

//===============================  affichage des contacts  =====================================================
$service_caracid=$ttservice;
$type=0;//nouveau
$nature=4;//service
$back="'../services.php'";//adresse de retour
$variable="'ttservice'";// variable de retour
print("<FIELDSET>");
print("<LEGEND class=\"time\">Contacts</LEGEND>");
if($ttservice)
	contact($service_caracid,$type,$nature,$contact_id,$back,$variable,$_GET['tri']);
//contact($contact,$type,$nature,$contact_id,$back,$variable_retour)
print("</FIELDSET>");
//============================================================================================================== 

print("<table width=\"100%\" classe=\"time_v\" bgcolor=\"#cccccccc\">");
	TblDebutLigne("Style25");
		TblCellule($string_lang['CODE_SERVICE'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$service_carac->service_code\" NAME=\"code\" SIZE = \"15\" ");

	TblFinLigne();
	TblDebutLigne("Style25");
		TblCellule($string_lang['BATIMENT'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$service_carac->service_batiment\" NAME=\"batiment\" SIZE = \"30\" ");
		TblCellule($string_lang['ETAGE'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$service_carac->service_etage\" NAME=\"etage\" SIZE = \"15\" ");
		TblCellule($string_lang['ASCENCEUR'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$service_carac->service_ascenceur\" NAME=\"ascenceur\" SIZE=\"15\" ");
	TblFinLigne();
	TblDebutLigne("Style25");
		TblCellule($string_lang['PRIORITE_ALERTE'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$service_carac->Priorite_Alerte\" NAME=\"priorite\" SIZE = \"5\"> ");
		TblCellule("&nbsp;");
		if($service_carac->Service_Alerte)
			$check = "CHECKED";
		else $check="";
		$mot = $string_lang['SERVICE_ALERTE'][$langue];
		TblCellule("<INPUT TYPE=\"CHECKBOX\" VALUE=\"1\" NAME=\"alerte\" $check> $mot ");
		$mot = $string_lang['HEURE_ALERTE'][$langue];
		TblCellule($mot.": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$service_carac->heure_alerte\" NAME=\"h_alerte\" SIZE = \"15\"> ");
	TblFinLigne();
TblFin();
print("</FIELDSET>");

//========================================= LITS ===============================================
print("<FIELDSET>");
$mot = $string_lang['LITS'][$langue];
print("<LEGEND class=\"time\"> $mot </LEGEND>");
// début du tableau
//TblDebut(0,"100%","","",time);
print("<table width=\"100%\" classe=\"time\" bgcolor=\"#cccccccc\">");
	TblDebutLigne("Style25");
		print("<TD class=\"time_r\">");
		print($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_DISPO'][$langue].": ");
		print("</TD>");
		$lv = $lits_du_service->lits_sp - $lits_du_service->lits_occ;
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lv\" NAME=\"lits_vides\" SIZE = \"5\" ");
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_AUTO'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_sp\" NAME=\"lits\" SIZE = \"5\" ");

		//--------------------- Lits réservés
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_RESERVE'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_reserve\" NAME=\"lits_reserve\" SIZE = \"5\" ");

	TblFinLigne();
	//============================================ Uniquement si SAU
	if($service_carac->Type_ID == 1 && $langue=="FR")
	{
		TblDebutLigne("Style25");
			TblCellule("Lits de déchocage");
			TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lit_spe1\" NAME=\"spe1\" SIZE = \"5\" ");
			TblCellule("Lits d'HTCD");
			TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lit_spe2\" NAME=\"spe2\" SIZE = \"5\" ");
		TblFinLigne();
	}
	//============================================ Uniquement si Brûlés
	if($service_carac->Type_ID == 10)
	{
		TblDebutLigne("Style25");
			TblCellule($string_lang['LITS_REA'][$langue]);
			TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lit_spe1\" NAME=\"spe1\" SIZE = \"5\" ");
			TblCellule($string_lang['LITS_ADULTES'][$langue]);
			TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lit_spe2\" NAME=\"spe2\" SIZE = \"5\" ");
			TblCellule($string_lang['LITS_ENFANTS'][$langue]);
			TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lit_spe3\" NAME=\"spe3\" SIZE = \"5\" ");
		TblFinLigne();
		TblDebutLigne("time_r");
			print("<td rowspan=\"2\">".$string_lang['DISPO_ACTUEL'][$langue]."</td>");
			TblCellule($string_lang['ADULTE_N_VENTILE'][$langue]);
			TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lit_spe4\" NAME=\"spe4\" SIZE = \"5\" ");
			TblCellule($string_lang['ADULTE_VENTILE'][$langue]);
			TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lit_spe5\" NAME=\"spe5\" SIZE = \"5\" ");
		TblFinLigne();
		TblDebutLigne("time_r");
			TblCellule($string_lang['ENFANT_N_VENTILE'][$langue]);
			TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lit_spe6\" NAME=\"spe6\" SIZE = \"5\" ");
			TblCellule($string_lang['ENFANT_VENTILE'][$langue]);
			TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lit_spe7\" NAME=\"spe7\" SIZE = \"5\" ");
		TblFinLigne();
	}//==========================================

	TblDebutLigne("Style25");
		//---------------------- Lits libérables
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_LIB'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_liberable\" NAME=\"lits_lib\" SIZE = \"5\" ");
		//--------------------- Lits installés
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_INSTALLE'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_installe\" NAME=\"instal\" SIZE = \"5\" ");

		//--------------------- Lits en isolement
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_ISOLEMENT'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_pneg\" NAME=\"isole\" SIZE = \"5\" ");
	TblFinLigne();
	//=============================================================================================================
	TblDebutLigne("Style25");
		//--------------------- Lits supplémentaires
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_SUP'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_supp\" NAME=\"lits_sup\" SIZE = \"5\" ");

		//--------------------- Lits fermés
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_FERME'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_ferme\" NAME=\"lits_ferme\" SIZE = \"5\" ");
		TblCellule("");
		TblCellule("");
		// l'usage du bouton valider est réservé à ? SAMU67 = 111
		if($sservice==111)
			TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"Valider\" NAME=\"ok\" SIZE = \"30\" ");
	TblFinLigne();
TblFin();
print("</FIELDSET>");

//========================================= PLACES ===============================================
print("<FIELDSET>");
$mot = $string_lang['PLACES'][$langue];
print("<LEGEND class=\"time\"> $mot </LEGEND>");
print("<table width=\"100%\" classe=\"time\" bgcolor=\"#cccccccc\">");
	TblDebutLigne("Style25");
		print("<TD class=\"time_r\">");
		print($string_lang['NOMBRE_DE'][$langue].$string_lang['PLACES_DISPO'][$langue].": ");
		print("</TD>");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->places_dispo\" NAME=\"places_dispo\" SIZE = \"5\" ");
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['PLACES_AUTO'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->places_auto\" NAME=\"places_auto\" SIZE = \"5\" ");
		print("<TD>&nbsp;</TD>");
		print("<TD>&nbsp;</TD>");
TblFin();
print("</FIELDSET>");
//================================================== MOYENS SPECIFIQUES ==============================================
print("<FIELDSET>");
$mot = $string_lang['MOYENS_SPECIFIQUES'][$langue];
print("<LEGEND class=\"time\"> $mot </LEGEND>");
print("<table width=\"100%\" classe=\"time\" bgcolor=\"#cccccccc\">");
	TblDebutLigne("Style25");//"Style25"
		//----------------------- Respirateurs
		TblCellule($string_lang['RESPI_DISPO'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_respi\" NAME=\"respi\" SIZE = \"5\" ");

		//----------------------- Postes de dialyse
		$mot=$string_lang['DIALYSEUR'][$langue];
		TblCellule($mot);
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_dialyse\" NAME=\"dialyse\" SIZE = \"5\" ");
	TblFinLigne();

	TblDebutLigne("Style25");//"Style25"

		TblCellule($string_lang['CHAMBRES_PP'][$langue]);
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_ppos\" NAME=\"ppos\" SIZE = \"5\" ");

		TblCellule($string_lang['CHAMBRES_PN'][$langue]);
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_pneg\" NAME=\"pneg\" SIZE = \"5\" ");

		TblCellule($string_lang['CHAMBRES_ST'][$langue]);
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_sterile\" NAME=\"sterile\" SIZE = \"5\" ");
	TblFinLigne();
TblFin();
print("</FIELDSET>");

print("<HR>");
print("</FORM>");
print("</html>");
?>
