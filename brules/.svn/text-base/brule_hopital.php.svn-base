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
//	programme: 		brule_hopital.php
//	date de création: 	21/11/2005
//	auteur:			jcb
//	description:	
//	version:		1.0
//	modifié le		21/11/2005
//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

/**< Langue courante */
$langue = $_SESSION['langue'];
/**< Identifiant de l'hôpital */
$id_hop = $_GET['ID_hopital'];

include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
include("../utilitairesHTML.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");;
include("../adresse_ajout.php");
include("../contact_main.php");
//menuLits($langue);

print("<html>");
print("<head>");
print("<title> SAGEC 67 </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

/**
* Dessine une case à cocher et sa légende. En foction de la variable $x, la case sera cochée ou non
* @param $name nom interne de la case à cocher
* @param $x indique si la case doit être cochée ou non
* @param $titre légende de la case à cocher
*/
function check($name,$x,$titre)
{
	if($x)
		print("<td class=\"time\"><INPUT TYPE=\"CHECKBOX\"  NAME=\"$name\" CHECKED value=\"o\"> $titre</td>");
	else
		print("<td class=\"time_b\"><INPUT TYPE=\"CHECKBOX\"  NAME=\"$name\" > $titre</td>");
}

print("<BODY onload=\"document.Hopital.nom_hop.focus()\">");
//menu_lits_maj($langue, $titre="Hôpitaux - Création & Mise à jour");
print("<br>");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
// création d'une form
print("<FORM name =\"Hopital\"  ACTION=\"#\" METHOD=\"GET\">");

if($_GET['ID_hopital'])
{
	// mémorisation dans un champ caché de $maj_hop pour se rappeler s'il s'agit d'une MAJ
	// ou d'une création
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj\" VALUE=\"$_GET[ID_hopital]\">");
	$requete = "SELECT * FROM hopital WHERE Hop_ID='$_GET[ID_hopital]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub = LigneSuivante($resultat);
	$adresse_ID = $rub->adresse_ID;
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"adresse_ID\" VALUE=\"$adresse_ID\">");
}

$requete = "SELECT org_nom FROM organisme WHERE org_ID='$rub->org_ID'";
$resultat = ExecRequete($requete,$connexion);
$org = LigneSuivante($resultat);

// début du tableau
//========================================= IDENTIFICATION ===============================================
print("<FIELDSET>");
print("<LEGEND class=\"time\"> Identification</LEGEND>");
TblDebut(0,"100%","1","0",time_v);
	TblDebutLigne();
		TblCellule($string_lang['HOPITAL'][$langue].":");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$rub->Hop_nom\" NAME=\"nom_hop\" SIZE = \"30\"> ");
		TblCellule($string_lang['ORGANISME'][$langue].":");

		print("<TD>");
			SelectOrganisme($connexion,$rub->org_ID,$langue,'');//$org_type contient le type_ID
		print("</TD>");
		TblCellule("Type");
		print("<TD>");
		select_type_etablissement($connexion,$rub->type_etablissement_ID,$langue);//retourne id_type_etablissement
		print("</TD>");
	TblFinLigne();

	TblDebutLigne();
		TblCellule("FINESS:");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$rub->Hop_finess\" NAME=\"finess\" SIZE = \"9\">");
		TblCellule("<A HREF=\"http://finess.sante.gouv.fr/finess\"> finess </A> ");
	TblFinLigne();
TblFin();
print("</FIELDSET>");
//===============================  affichage du champ adresse  =================================================
get_adresse($adresse_ID,'V');
//===============================  affichage des contacts  =====================================================
$hopid=$_GET['ID_hopital'];
$type=0;//nouveau
$nature=5;//hopital
$back="hopital.php";
$variable="ID_hopital";
print("<FIELDSET>");
print("<LEGEND class=\"time\">Contacts</LEGEND>");
contact($hopid,$type,$nature,$contact_id,$back,$variable,$_GET['tri']);
//contact($contact,$type,$nature,$contact_id,$back,$variable_retour)
print("</FIELDSET>");
//========================================= PLATEAU TECHNIQUE ===============================================
//print("<BR>");
print("<FIELDSET>");
print("<LEGEND class=\"time_r\"> Plateau technique</LEGEND>");
TblDebut(0,"100%","","","time");//
	TblDebutLigne();
		//-------------------------- DZ ----------------------------------
		$mot="DZ";
		check("dz",$rub->Hop_DZ,$mot);
		//-------------------------- Dialyse -----------------------------
		$mot = $string_lang["DIALYSEUR"][$langue];
		check("dialyse",$rub->Hop_Dialyse,$mot);
		//-------------------------- Crâne grave -----------------------------
		$mot = $string_lang["TRAUMA_CRANE"][$langue];
		check("crane",$rub->Hop_Crane,$mot);
		//-------------------------- Polytraumatisé -----------------------------
		$mot = $string_lang["POLYTRAU"][$langue];
		check("polytrauma",$rub->Hop_polytrauma,$mot);
		//-------------------------- Brûlés -----------------------------
		$mot="Brûlés";
		$mot = $string_lang["BRÛLES"][$langue];
		check("brule",$rub->Hop_brule,$mot);
	TblFinLigne();

	TblDebutLigne();
		//-------------------------- SAMU -----------------------------
		$mot = $string_lang["SAMU"][$langue];
		check("samu",$rub->Hop_Samu,$mot);
		//-------------------------- SMUR -----------------------------
		$mot = $string_lang["SMUR"][$langue];
		check("smur",$rub->Hop_Smur,$mot);
		//-------------------------- PSM2 -----------------------------
		$mot="PSM2";
		check("psm2",$rub->Hop_psm2,$mot);
		//-------------------------- PSM1 -----------------------------
		$mot="PSM1";
		check("psm1",$rub->Hop_psm1,$mot);
		//-------------------------- SAU -----------------------------
		$mot = $string_lang["SAU"][$langue];
		check("sau",$rub->Hop_sau,$mot);
		//-------------------------- UPATOU -----------------------------
		$mot = $string_lang["UPATOU"][$langue];
		check("upatou",$rub->Hop_upatou,$mot);
		//-------------------------- Caisson hyperbare ----------------------------------
		$mot = $string_lang["CAISSON"][$langue];
		check("caisson",$rub->Hop_caisson,$mot);
	TblFinLigne();
TblFin();
print("</FIELDSET>");
//========================================= MEDICO-TECHNIQUE ===============================================
print("<FIELDSET>");
print("<LEGEND class=\"time_r\"> Radiologie </LEGEND>");
//TblDebut(0,"75%","","",time);
print("<Table cellspacing=\"2\" width=\"75%\">");//class=\"time\"
	TblDebutLigne();
	//-------------------------- IRM -----------------------------
		$mot = $string_lang["IRM"][$langue];
		check("irm",$rub->Hop_IRM,$mot);

	//-------------------------- artério -----------------------------
		$mot = $string_lang["ARTERIO"][$langue];
		check("angio",$rub->Hop_Angio,$mot);

	//-------------------------- Echo -----------------------------
		$mot = $string_lang["ECHO"][$langue];
		check("echo",$rub->Hop_Echo,$mot);

	//-------------------------- Scanner -----------------------------
		$mot = $string_lang["SCANNER"][$langue];
		check("scanner",$rub->Hop_Scanner,$mot);

	//-------------------------- Pet Scan -----------------------------
		$mot = $string_lang["PET_SCAN"][$langue];
		check("petscan",$rub->Hop_Petscan,$mot);

	TblFinLigne();
TblFin();
print("</FIELDSET>");
//========================================= SERVICES ========================================================
print("<FIELDSET>");
print("<LEGEND class=\"time_r\"> Services MCO </LEGEND>");
print("<Table cellspacing=\"2\" class=\"time\" width=\"100%\">");
	TblDebutLigne();
	//-------------------------- Orthopédie -----------------------------
		$mot = $string_lang["ORTHOPEDIE"][$langue];
		check("orthopedie",$rub->Hop_Orthopedie,$mot);

	//-------------------------- Neuro-Chirurgie -----------------------------
		$mot = $string_lang["NEUROCHIR"][$langue];
		check("neurochir",$rub->Hop_Neurochir,$mot);

	//-------------------------- Vasculaire -----------------------------
		$mot = $string_lang["CHIR_VASC"][$langue];
		check("chirvasc",$rub->Hop_ChirVasc,$mot);

	//-------------------------- Cardiaque -----------------------------
		$mot = $string_lang["CHIR_CARD"][$langue];
		check("cardiovasc",$rub->Hop_Cardiovasc,$mot);

	//-------------------------- Maxillo-faciale -----------------------------
		$mot = $string_lang["MAXILLO"][$langue];
		check("maxillo",$rub->Hop_Maxillo,$mot);
TblFinLigne();
TblDebutLigne();
	//-------------------------- Thoracique -----------------------------
		$mot = $string_lang["CHIR_THO"][$langue];
		check("chirtho",$rub->Hop_ChirTho,$mot);
	//-------------------------- Infantile -----------------------------
		$mot = $string_lang["CHIR_INF"][$langue];
		check("chirinf",$rub->Hop_ChirInf,$mot);

	//-------------------------- ORL -----------------------------
		$mot = $string_lang["ORL"][$langue];
		check("orl",$rub->Hop_Orl,$mot);

	//-------------------------- Ophtalmo -----------------------------
		$mot = $string_lang["OPHTALMO"][$langue];
		check("ophtalmo",$rub->Hop_Ophtalmo,$mot);
TblFinLigne();
TblDebutLigne();
	//-------------------------- Réanimation adulte -----------------------------
		$mot = $string_lang["REA"][$langue];
		check("rea",$rub->Hop_Rea,$mot);

	//-------------------------- Réanimation pédiatrique -----------------------------
		$mot = $string_lang["REA_PED"][$langue];
		check("reaped",$rub->Hop_ReaPed,$mot);

	//-------------------------- Chirurgie Viscérale -----------------------------
		$mot = $string_lang["CHIR_VISC"][$langue];
		check("visceral",$rub->Hop_visceral,$mot);

	//-------------------------- Chirurgie Urologique -----------------------------
		$mot = $string_lang["CHIR_URO"][$langue];
		check("urologie",$rub->Hop_visceral,$mot);


	TblFinLigne();
TblFin();
print("</FIELDSET>");
//===========================================================================================================
print("<HR>");
print("</FORM>");
print("<BODY>");
print("<html>");

?>