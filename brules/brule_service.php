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
//	programme: 		brule_service.php
//	date de cr�ation: 	20/11/2005
//	auteur:			jcb
//	description:		Fonctionalit? permise ? l'administrateur
//	version:			1.0
//	maj le:			20/11/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require("../html.php");
require './../utilitaires/globals_string_lang.php';
include("./../utilitairesHTML.php");
require("./../pma_connect.php");
require("./../pma_connexion.php");
include("../contact_main.php");
include($backPathToRoot."login/init_security.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$langue = $_SESSION['langue'];

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
?><link rel="shortcut icon" href="../images/sagec67.ico" /><?php
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");
print("<title></title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM name=\"service\" method=\"get\" ACTION=\"\" target=\"middle\">");

$service_ID = $_REQUEST['service_ID'];
// cherche toutes les caract�ristiques du service dont l'identifiant est $service_ID
$service_carac = ChercheService($service_ID,$connexion);
$lits_du_service = ChercheLit($service_carac->service_ID,$connexion);

//========================================= IDENTIFICATION ===============================================
print("<FIELDSET>");
$mot=$string_lang['IDENTIFICATION'][$langue];
print("<LEGEND class=\"time\"> $mot </LEGEND>");
// d�but du tableau
//TblDebut(0,"100%","","",time_v);
print("<table width=\"100%\" classe=\"time_v\" bgcolor=\"#ccccccff\">");
	TblDebutLigne("Style25");
		TblCellule($string_lang['SERVICE'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$service_carac->service_nom\" NAME=\"nom\" SIZE = \"30\" ");
		//TblCellule("&nbsp;");
		//TblCellule("&nbsp;");
		$mot=$string_lang['HOPITAL'][$langue].": ";
		print("<td><a href=\"brule_hopital.php?ID_hopital=$service_carac->Hop_ID\">$mot</A></td>");
		print("<TD>");
		select_hopital($connexion,$service_carac->Hop_ID,$langue);
		print("</TD>");
		$mot=$string_lang['SAMU'][$langue].": ";
		if($service_carac->samu_id)
		{
			$retour="services.php?ttservice=$service_carac->service_ID";
			TblCellule("<a href=\"brule_service.php?service_ID=$service_carac->samu_id&back=$retour\">$mot</A>");
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
$service_caracid=$service_ID;
$type=0;//nouveau
$nature=4;//service
$back="services.php";//adresse de retour
$variable="ttservice";// variable de retour
print("<FIELDSET>");
print("<LEGEND class=\"time\">Contacts</LEGEND>");
contact($service_caracid,$type,$nature,$contact_id,$back,$variable,$_GET['tri']);
//contact($contact,$type,$nature,$contact_id,$back,$variable_retour)
print("</FIELDSET>");


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
// d�but du tableau
//TblDebut(0,"100%","","",time);
print("<table width=\"100%\" classe=\"Style22\" bgcolor=\"#cccccccc\">");
	TblDebutLigne("Style22");
		print("<TD class=\"time_r\">");
		print($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_DISPO'][$langue].": ");
		print("</TD>");
		$lv = $lits_du_service->lits_sp - $lits_du_service->lits_occ;
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lv\" NAME=\"lits_vides\" SIZE = \"5\" ");
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_AUTO'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_sp\" NAME=\"lits\" SIZE = \"5\" ");

		//--------------------- Lits r�serv�s
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_RESERVE'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_reserve\" NAME=\"lits_reserve\" SIZE = \"5\" ");

	TblFinLigne();
	//============================================ Uniquement si SAU
	if($service_carac->Type_ID == 1 && $langue=="FR")
	{
		TblDebutLigne("Style22");
			TblCellule("Lits de d�chocage");
			TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lit_spe1\" NAME=\"spe1\" SIZE = \"5\" ");
			TblCellule("Lits d'HTCD");
			TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lit_spe2\" NAME=\"spe2\" SIZE = \"5\" ");
		TblFinLigne();
	}
	//============================================ Uniquement si Br�l�s
	if($service_carac->Type_ID == 10)
	{
		TblDebutLigne("Style22");
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

	TblDebutLigne("Style22");
		//---------------------- Lits lib�rables
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_LIB'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_liberable\" NAME=\"lits_lib\" SIZE = \"5\" ");
		//--------------------- Lits install�s
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_INSTALLE'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_installe\" NAME=\"instal\" SIZE = \"5\" ");

		//--------------------- Lits en isolement
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_ISOLEMENT'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_pneg\" NAME=\"isole\" SIZE = \"5\" ");
	TblFinLigne();
	//=============================================================================================================
	TblDebutLigne("Style22");
		//--------------------- Lits suppl�mentaires
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_SUP'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_supp\" NAME=\"lits_sup\" SIZE = \"5\" ");

		//--------------------- Lits ferm�s
		TblCellule($string_lang['NOMBRE_DE'][$langue].$string_lang['LITS_FERME'][$langue].": ");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$lits_du_service->lits_ferme\" NAME=\"lits_ferme\" SIZE = \"5\" ");
		TblCellule("");
		TblCellule("");
		// l'usage du bouton valider est r�serv� � ? SAMU67 = 111
		if($sservice==111)
			TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"Valider\" NAME=\"ok\" SIZE = \"30\" ");
	TblFinLigne();
TblFin();
print("</FIELDSET>");

//================================================== MOYENS SPECIFIQUES ==============================================
print("<FIELDSET>");
$mot = $string_lang['MOYENS_SPECIFIQUES'][$langue];
print("<LEGEND class=\"time\"> $mot </LEGEND>");
print("<table width=\"100%\" classe=\"Style22\" bgcolor=\"#cccccccc\">");
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

print("</form>");
print("</body>");
print("</HTML>");
?>