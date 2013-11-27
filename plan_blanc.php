<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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

/**
 * Documents the class following plan_blanc.php
 * description: complète les données techniques d'un hôpital
 * @package Sagec
 * @version $Id$
 * @author JCB
 */

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");

/**< Langue courante */
$langue = $_SESSION['langue'];
/**< Identifiant de l'hôpital */
$id_hop = $_GET['ID_hopital'];

include("utilitaires/table.php");
require 'utilitaires/globals_string_lang.php';
include("utilitairesHTML.php");
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
require("menu_gestion_lits.php");
include("adresse_ajout.php");
include("contact_main.php");
//menuLits($langue);

print("<html>");
print("<head>");
print("<title> SAGEC 67 </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

/**
* Dessine une case à cocher et sa légende. En foction de la variable $x, la case sera cochée ou non
* @param $name nom interne de la case à cocher
* @param $x indique si la case doit être cochée ou non
* @param $titre légende de la case à cocher
*/
function check($name,$x,$titre)
{
	//print("<p>");
	if($x)
		print("<td class=\"time\"><INPUT TYPE=\"CHECKBOX\"  NAME=\"$name\" CHECKED value=\"o\" id=\"$name\">");
	else
		print("<td class=\"time_b\"><INPUT TYPE=\"CHECKBOX\"  NAME=\"$name\" id=\"$name\">");
	print("<label for=\"$name\">$titre</label></td>");
	//print("</p>");
}

function confinement($name,$select)
{
	print("<TD><select name=\"$name\" size=\"1\">");
	for($i=1;$i<5;$i++)
	{
		print("<OPTION VALUE=\"$i\" ");
		if($i == $select) print(" SELECTED");
			print("> P".$i." </OPTION> \n");
	}
	print("</SELECT></TD>");
}
function valider($langue)
{
	global $string_lang;
	$mot = $string_lang['VALIDER'][$langue];
	TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\"> ");
}

print("<BODY onload=\"document.Hopital.nom_hop.focus()\">");
menu_lits_maj($langue, $titre="Hôpitaux - Création & Mise à jour");
print("<br>");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
// création d'une form
print("<FORM name =\"Hopital\"  ACTION=\"hopital_enregistre_PB.php\" METHOD=\"GET\">");

$hop_id = $_REQUEST['hopID'];
if($hop_id)
{
	// mémorisation dans un champ caché de $maj_hop pour se rappeler s'il s'agit d'une MAJ
	// ou d'une création
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj\" VALUE=\"$hop_id\">");
	$requete = "SELECT * FROM hopital WHERE Hop_ID='$hop_id'";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mySql_fetch_array($resultat);
	$adresse_ID = $rub[adresse_ID];
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"adresse_ID\" VALUE=\"$adresse_ID\">");
}

$requete = "SELECT org_nom FROM organisme WHERE org_ID='$rub[org_ID]'";
$resultat = ExecRequete($requete,$connexion);
$org = LigneSuivante($resultat);

print("<div>");
	print("<p>".$rub['Hop_nom']."</p>");
print("</div>");


//==================================CAPACITES MAXIMALES ========================================================
print("<FIELDSET>");
print("<LEGEND class=\"time_r\"> Capacité maximales en cas de crise </LEGEND>");
print("<Table cellspacing=\"2\" class=\"time\" width=\"50%\">");
	TblDebutLigne();
		print("<td>&nbsp;</td>");
		print("<td>à T0</td>");
		print("<td>à T0+30 mn</td>");
		print("<td>à T0+60 mn</td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Urgences absolues</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[uat0]\" name=\"uat0\"></td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[uat1]\" name=\"uat30\"></td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[uat2]\" name=\"uat60\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Urgences relatives</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[urt0]\" name=\"urt0\"></td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[urt1]\" name=\"urt30\"></td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[urt2]\" name=\"urt60\"></td>");
	TblFinLigne();
TblDebutLigne();
		print("<td>Impliqués</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[it0]\" name=\"it0\"></td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[it1]\" name=\"it30\"></td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[it2]\" name=\"it60\"></td>");
		valider($langue);
	TblFinLigne();
TblFin();
print("</FIELDSET>");
//================================== Activités de soins ========================================================
print("<FIELDSET>");
print("<LEGEND class=\"time_r\"> Activités de soins </LEGEND>");
print("<Table cellspacing=\"2\" class=\"time\" width=\"50%\">");
	TblDebutLigne();
		print("<td>&nbsp;</td>");
		print("<td>Nombre de lits installés</td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Urgences</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_ur_tot]\" name=\"l1\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont hospitalisation de très courte durée</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_ur_cd]\" name=\"l2\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont postes de déchocage</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_ur_dechoc]\" name=\"l3\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Médecine</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_med_tot]\" name=\"l4\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont maladies infectieuses</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_med_infec]\" name=\"l5\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont pédiatrie</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_med_ped]\" name=\"l6\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Chirurgie</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_chir_tot]\" name=\"l7\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont orthopédie</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_chir_ortho]\" name=\"l8\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont neuro-chirurgie</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_chir_neuro]\" name=\"l9\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont vasculaire</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_chir_vasc]\" name=\"l10\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont maxillo-faciale</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_chir_max]\" name=\"l11\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont thoraco-pulmonaire</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_chir_thorax]\" name=\"l12\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont infantile</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_chir_ped]\" name=\"l13\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont ORL</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_chir_orl]\" name=\"l14\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont ophtalmologie</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_chir_opht]\" name=\"l15\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Psychiatrie</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_psy_tot]\" name=\"l16\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Soins de suite</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_ssr_tot]\" name=\"l17\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Long séjour</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_ls_tot]\" name=\"l18\"></td>");
		valider($langue);
	TblFinLigne();
TblFin();
print("</FIELDSET>");
//================================== Activités Spécialisées ========================================================
print("<FIELDSET>");
print("<LEGEND class=\"time_r\"> Activités spécialisées </LEGEND>");
print("<Table cellspacing=\"2\" class=\"time\" width=\"50%\">");
	TblDebutLigne();
		print("<td>&nbsp;</td>");
		print("<td>Nombre de lits installés</td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Réanimation</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_rea_tot]\" name=\"l19\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">adulte</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_rea_ad]\" name=\"l20\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">pédiatrique</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[lit_rea_ped]\" name=\"l21\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Nombre de places en salles de réveil</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[reveil_tot]\" name=\"l22\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Nombre de blocs opératoires disponibles</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[bloc_tot]\" name=\"l23\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont blocs de chirurgie ambulatoire</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[bloc_ambu]\" name=\"l24\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Brûlés</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[brule_tot]\" name=\"l25\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont brûlés \"réanimation\"</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[brule_rea]\" name=\"l26\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont brûlés \"chirurgicaux\"</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[brule_chir]\" name=\"l27\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Nombre de chambres stériles</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[ch_ste]\" name=\"l28\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Nombre de chambres en pression positive</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[ch_pp]\" name=\"l29\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Nombre de chambres en pression négatives</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[ch_pn]\" name=\"l30\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Nombre de postes de dialyse</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[dialyse_tot]\" name=\"l31\"></td>");
		valider($langue);
	TblFinLigne();
TblFin();
print("</FIELDSET>");
//================================== Services médico-techniques =======================================
print("<FIELDSET>");
print("<LEGEND class=\"time_r\"> Services médico-techniques </LEGEND>");
print("<Table cellspacing=\"2\" class=\"time\" width=\"100%\">");
	TblDebutLigne();
		print("<td bgcolor=\"yellow\"><b>LABORATOIRE</b></td>");
		print("<td>Oui/Non</td>");
		print("<td>niveau de confinement</td>");
		print("<td>Analyses réalisables</td>");
	TblFinLigne();
	TblDebutLigne();
		$name = $string_lang["BIOCHIMIE"][$langue];
		print("<td>$name</td>");
		check('bioch',$rub[bioch],'oui');
		confinement("bioch_p",$rub[bioch_p]);
		print("<td><input type=\"text\" size=\"80\" value=\"\" name=\"bioch_exam\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Bactériologie</td>");
		$name = $string_lang["BACTERIO"][$langue];
		check('bacterio',$rub[bacterio],'oui');
		confinement('bacterio_p',$rub[bacterio_p]);
		print("<td><input type=\"text\" size=\"80\" value=\"\" name=\"\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Virologie</td>");
		$name = $string_lang["VIRO"][$langue];
		check('viro',$rub[viro],'oui');
		confinement('viro_p',$rub[viro_p]);
		print("<td><input type=\"text\" size=\"80\" value=\"\" name=\"\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Parasitologie</td>");
		$name = $string_lang["PARASITO"][$langue];
		check('parasito',$rub[parasito],'oui');
		confinement('parasito_p',$rub[parasito_p]);
		print("<td><input type=\"text\" size=\"80\" value=\"\" name=\"\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Toxicologie</td>");
		$name = $string_lang["TOXICO"][$langue];
		check('toxico',$rub[toxico],'oui');
		confinement('toxico_p',$rub[toxico_p]);
		print("<td><input type=\"text\" size=\"80\" value=\"\" name=\"\"></td>");
	TblFinLigne();
TblFin();

print("<Table cellspacing=\"2\" class=\"time\" width=\"100%\">");
	TblDebutLigne();
		print("<td bgcolor=\"yellow\"><b>PHARMACIE</b></td>");
		check('pharma',$rub[pharma],'Mon établissement dispose d\'une pharmacie');
	TblFinLigne();
	TblDebutLigne();
		print("<td>&nbsp;</td>");
		check('pharma_st',$rub[pharma_st],'Il existe un stock minimum de fonctionnement');
		print("<td>Si oui quelle est la durée corresondante<input type=\"text\" size=\"5\" value=\"$rub[pharma_t]\" name=\"pharma_t\"> jours</td>");
	TblFinLigne();
TblFin();

print("<Table cellspacing=\"2\" class=\"time\" width=\"50%\">");
	TblDebutLigne();
		print("<td bgcolor=\"yellow\"><b>RADIOLOGIE</b></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Disposez-vous sur site des équipements suivants?</td>");
		print("<td>Nombre</td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">radiologie standard</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[rx_std]\" name=\"rx_std\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">scanner</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[rx_scan]\" name=\"rx_scan\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">IRM</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[rx_irm]\" name=\"rx_irm\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">échographie</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[rx_echo]\" name=\"rx_echo\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">angiographie</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[rx_angio]\" name=\"rx_angio\"></td>");
		valider($langue);
	TblFinLigne();
TblFin();
print("</FIELDSET>");
//================================== Autres équipements hors SAMU/SMUR ===========================================
print("<FIELDSET>");
print("<LEGEND class=\"time_r\"> AUTRES EQUIPEMENTS HORS SAMU/SMUR </LEGEND><HR>");
print("<B>Pavillon \"personnes contagieuses\"</b>");
print("<Table cellspacing=\"2\" class=\"time\" width=\"100%\">");
	TblDebutLigne();
		print("<td>Pavillon disponible en 24h pouvant être dédié à l'accueil de personnes hautement contagieuses</td>");
		check('conta',$rub['conta'],'Oui');
		print("<td>Si oui, quelle capacité? <input type=\"text\" size=\"5\" value=\"$rub[conta_tot]\" name=\"conta_tot\"></td>");
	TblFinLigne();
TblFin();
print("<hr>");
print("<B>Respirateurs</b>");
print("<Table cellspacing=\"2\" class=\"time\" width=\"100%\">");
	TblDebutLigne();
		print("<td>&nbsp;</td>");
		print("<td>nombre</td>");
		print("<td>services</td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>portables</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[respi_p]\" name=\"respi_p\"></td>");
		print("<td><input type=\"text\" size=\"80\" value=\"\" name=\"\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>non portables</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[respi_f]\" name=\"respi_f\"></td>");
		print("<td><input type=\"text\" size=\"80\" value=\"\" name=\"\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Oxygène: capacité en bouteilles B5</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[b5]\" name=\"b5\"></td>");
		print("<td><input type=\"text\" size=\"80\" value=\"\" name=\"\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Oxygène: capacité en bouteilles B15</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[b15]\" name=\"b15\"></td>");
		print("<td><input type=\"text\" size=\"80\" value=\"\" name=\"\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Oxygène: capacité en bouteilles B50</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[b50]\" name=\"b50\"></td>");
		print("<td><input type=\"text\" size=\"80\" value=\"\" name=\"\"></td>");
	TblFinLigne();
TblFin();
print("<hr>");
print("<B>Lots de catastrophe hors PSM</b>");
print("<Table cellspacing=\"2\" class=\"time\" width=\"40%\">");
	TblDebutLigne();
		print("<td>Nombre de lits de camps</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[litscamp]\" name=\"litscamp\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Nombre de brancards</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[brancard]\" name=\"brancard\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Nombre de couvertures</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[couverture]\" name=\"couverture\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Nombre de douches projetables</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[douche_m]\" name=\"douche_m\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Nombre de douches sur site?</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[douche_f]\" name=\"douche_f\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">dont avec récupération des eaux de décontamination?</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[douche_f_r]\" name=\"douche_f_r\"></td>");
		valider($langue);
	TblFinLigne();
TblFin();
print("</FIELDSET>");
//================================== Tenues de protection ===========================================
print("<FIELDSET>");
print("<LEGEND class=\"time_r\"> TENUES DE PROTECTION </LEGEND><HR>");
print("<Table cellspacing=\"2\" class=\"time\" width=\"40%\">");
	TblDebutLigne();
		print("<td align=\"right\">tenues TOM</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[tom]\" name=\"tom\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">tenues TYCHEM C</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[tychem_c]\" name=\"tychem_c\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">tenues TYCHEM F</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[tychem_f]\" name=\"tychem_f\"></td>");
		valider($langue);
	TblFinLigne();
TblFin();
print("</FIELDSET>");
//================================== Personnel ===========================================
print("<FIELDSET>");
print("<LEGEND class=\"time_r\"> PERSONNEL </LEGEND>");
print("<Table cellspacing=\"2\" class=\"time\" width=\"50%\">");
	TblDebutLigne();
		print("<td>Médical (sauf internes)</td>");
		print("<td>Nombre mobilisable</td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td><u>Médecins</u></td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[med_tot]\" name=\"med_tot\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">médecine nucléaire</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[med_nucl]\" name=\"med_nucl\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">radiologues</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[med_radio]\" name=\"med_radio\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">radiothérapeutes</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[med_radiot]\" name=\"med_radiot\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">maladies infectieuses</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[med_infec]\" name=\"med_infec\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">légistes</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[med_leg]\" name=\"med_leg\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">urgentistes</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[med_urg]\" name=\"med_urg\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">pédiatres</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[med_ped]\" name=\"med_ped\"></td>");
	TblFinLigne();

	TblDebutLigne();
		print("<td>Chirurgiens</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[chir_tot]\" name=\"chir_tot\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">orthopédistes</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[chir_ortho]\" name=\"chir_ortho\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">viscéraux</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[chir_dig]\" name=\"chir_dig\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">neuro-chirurgiens</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[chir_neuro]\" name=\"chir_neuro\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">de la main</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[chir_main]\" name=\"chir_main\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">ORL</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[chir_orl]\" name=\"chir_orl\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">ophtalmo</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[chir_opht]\" name=\"chir_opht\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">maxillo-faciale</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[chir_max]\" name=\"chir_max\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">cardio-thoracique</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[chir_thorax]\" name=\"chir_thorax\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">vasculaire</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[chir_vasc]\" name=\"chir_vasc\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">infantiles</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[chir_ped]\" name=\"chir_ped\"></td>");
	TblFinLigne();

	TblDebutLigne();
		print("<td>Anesthésistes-réanimateurs</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[anes_rea]\" name=\"anes_rea\"></td>");
		valider($langue);
	TblFinLigne();
	TblDebutLigne();
		print("<td>Pharmaciens</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[med_pharma]\" name=\"med_pharma\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Biologistes</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[med_bio]\" name=\"med_bio\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Psychiatres</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[med_psy]\" name=\"med_psy\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Sages femmes</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[s_femme]\" name=\"s_femme\"></td>");
	TblFinLigne();

	TblDebutLigne();
		print("<td bgcolor=\"yellow\"><b>Personnel non Médical</B></td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[n_med_tot]\" name=\"n_med_tot\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Psychologues</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[psycho]\" name=\"psycho\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Brancardiers</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[brancardier]\" name=\"brancardier\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Ambulanciers</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[ambu]\" name=\"ambu\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Infirmières</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[inf_tot]\" name=\"inf_tot\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">IDE</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[ide]\" name=\"ide\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">IADE</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[iade]\" name=\"iade\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td align=\"right\">IBODE</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[ibode]\" name=\"ibode\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Aides soignants</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[a_s]\" name=\"a_s\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Manipulateurs radio</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[manip]\" name=\"manip\"></td>");
	TblFinLigne();
	TblDebutLigne();
		print("<td>Laborantins</td>");
		print("<td><input type=\"text\" size=\"5\" value=\"$rub[labor]\" name=\"labor\"></td>");
		valider($langue);
	TblFinLigne();
TblFin();
print("</FIELDSET>");
//===========================================================================================================
print("<HR>");
print("</FORM>");
print("<BODY>");
print("<html>");
?>
