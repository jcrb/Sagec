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
//
/**
 * Documents the class following
 * @package Sagec
 * @version $Id: hopital_enregistre.php 42 2008-03-09 22:45:00Z jcb $
 * @author JCB
 */
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$backPathToRoot = ""; 
include_once($backPathToRoot."dbConnection.php");
include($backPathToRoot."adresse_ajout.php");
include_once($backPathToRoot."login/init_security.php");
//
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//
//$connexion = connexion(NOM,PASSE,BASE,SERVEUR);
//
// Teste si un hôpital du même nom existe déjà
function hopital_existe($nom,$connexion)
{
	$requete="SELECT org_nom FROM organisme WHERE org_nom = '$nom'";
	$resultat = ExecRequete($requete,$connexion);
	$donnees = mysql_fetch_array($resultat);
	if($donnees)return true;
	else return false;
}
//
// enregistrement de la partie adresse
$adresse = Security::str2db($_REQUEST['adresse_ID']);
$z1 = Security::str2db($_REQUEST['z1']);
$z2 = Security::str2db($_REQUEST['z2']);
$zip = Security::str2db($_REQUEST['zip']);
$lat = Security::str2db($_REQUEST['latitude']);
$lng = Security::str2db($_REQUEST['longitude']);
$ad_id = enregistre_adresse($adresse,$z1,$z2,$_REQUEST['id_ville'],$zip,'V',$lat,$lng);

$maj = $_REQUEST['maj'];

$_REQUEST['nom_hop'] = Security::str2db($_REQUEST['nom_hop']);

$pblanc = Security::esc2Db($_REQUEST[pblanc]);
//
// Création d'un nouvel enregistrement
if(!$_REQUEST['maj'])
{/*
	if(!hopital_existe($nom,$connexion))
	{}*/

		$requete="INSERT INTO hopital (`Hop_ID`, `Hop_nom`, `Hop_finess`, `adresse_ID`, `type_etablissement_ID`, `org_ID`, `Hop_DZ`, `Hop_Scanner`, `Hop_IRM`, 
		`Hop_Angio`, `Hop_Echo`, `Hop_Crane`, `Hop_Dialyse`, `Hop_Smur`, `Hop_Samu`, `Hop_Petscan`, `Hop_Orthopedie`, `Hop_Neurochir`, `Hop_ChirVasc`, `Hop_Cardiovasc`, 
		`Hop_Maxillo`, `Hop_ChirTho`, `Hop_ChirInf`, `Hop_Orl`, `Hop_Ophtalmo`, `Hop_main`, `Hop_Rea`, `Hop_ReaPed`, `Hop_SAU`, `Hop_upatou`, `Hop_psm1`, `Hop_psm2`, 
		`Hop_brule`, `Hop_polytrauma`, `Hop_caisson`, `Hop_visceral`, `Hop_urologie`, `Hop_stroke`,`total_lits`,`niveau_planBlanc`)
							VALUES ('',
							'$_REQUEST[nom_hop]',
							'$_REQUEST[finess]',
							'$ad_id',
							'$_REQUEST[id_type_etablissement]',
							'$_REQUEST[orgID]',
							'$_REQUEST[dz]',
							'$_REQUEST[scanner]',
							'$_REQUEST[irm]',
							'$_REQUEST[angio]',
							'$_REQUEST[echo]',
							'$_REQUEST[crane]',
							'$_REQUEST[dialyse]',
							'$_REQUEST[smur]',
							'$_REQUEST[samu]',
							'$_REQUEST[petscan]',
							'$_REQUEST[orthopedie]',
							'$_REQUEST[neurochir]',
							'$_REQUEST[chirvasc]',
							'$_REQUEST[cardiovasc]',
							'$_REQUEST[maxillo]',
							'$_REQUEST[chirtho]',
							'$_REQUEST[chirinf]',
							'$_REQUEST[orl]',
							'$_REQUEST[ophtalmo]',
							'$_REQUEST[mains]',
							'$_REQUEST[rea]',
							'$_REQUEST[reaped]',
							'$_REQUEST[Hop_sau]',
							'$_REQUEST[upatou]',
							'$_REQUEST[psm1]',
							'$_REQUEST[psm2]',
							'$_REQUEST[brule]',
							'$_REQUEST[polytrauma]',
							'$_REQUEST[caisson]',
							'$_REQUEST[visceral]',
							'$_REQUEST[urologie]',
							'$_REQUEST[stroke]',
							'$_REQUEST[tot_lits]',
							'$pblanc'
							";
				/*
				for($i=0;$i<100;$i++)
					$requete .= "'',";
				$requete .= "'$_REQUEST[tot_lits]'";
				*/
				$requete.=")";
		$resultat = ExecRequete($requete,$connexion);
		$maj = $adresse_ID = mysql_insert_id();
		// Supprimé le 15/8/03, car ne correspond à rien
		//Create_Lits($connexion,$nom,$hopital,$lits,$lits_sup,$lits_lib,$lits_vides);
}
else
{
	$orgID = Security::esc2Db($_REQUEST['orgID']);
	
	$requete="UPDATE hopital SET
					Hop_nom = '$_REQUEST[nom_hop]',
					org_ID = '$orgID',
					adresse_ID = '$ad_id',
					Hop_DZ = '$_REQUEST[dz]',
					Hop_Scanner ='$_REQUEST[scanner]',
					Hop_IRM ='$_REQUEST[irm]',
					Hop_Angio ='$_REQUEST[angio]',
					Hop_Echo ='$_REQUEST[echo]',
					Hop_Crane = '$_REQUEST[crane]',
					Hop_Dialyse = '$_REQUEST[dialyse]',
					Hop_SMUR = '$_REQUEST[smur]',
					Hop_SAMU = '$_REQUEST[samu]',
					Hop_Petscan = '$_REQUEST[petscan]',
					Hop_Orthopedie = '$_REQUEST[orthopedie]',
					Hop_Neurochir = '$_REQUEST[neurochir]',
					Hop_ChirVasc = '$_REQUEST[chirvasc]',
					Hop_Cardiovasc = '$_REQUEST[cardiovasc]',
					Hop_Maxillo = '$_REQUEST[maxillo]',
					Hop_ChirTho = '$_REQUEST[chirtho]',
					Hop_ChirInf = '$_REQUEST[chirinf]',
					Hop_Orl = '$_REQUEST[orl]',
					Hop_Ophtalmo = '$_REQUEST[ophtalmo]',
					Hop_main = '$_REQUEST[mains]',
					Hop_Rea = '$_REQUEST[rea]',
					Hop_ReaPed = '$_REQUEST[reaped]',
					Hop_SAU = '$_REQUEST[sau]',
					Hop_upatou = '$_REQUEST[upatou]',
					Hop_finess = '$_REQUEST[finess]',
					Hop_psm1 = '$_REQUEST[psm1]',
					Hop_psm2 = '$_REQUEST[psm2]',
					Hop_brule = '$_REQUEST[brule]',
					type_etablissement_ID = '$_REQUEST[id_type_etablissement]',
					Hop_polytrauma = '$_REQUEST[polytrauma]',
					Hop_caisson = '$_REQUEST[caisson]',
					Hop_visceral = '$_REQUEST[visceral]',
					Hop_urologie = '$_REQUEST[urologie]',
					Hop_stroke = '$_REQUEST[stroke]',
					total_lits = '$_REQUEST[tot_lits]',
					niveau_planBlanc = '$pblanc'
				WHERE Hop_ID = '$_REQUEST[maj]'";

	//print($requete);

	$resultat = ExecRequete($requete,$connexion);
	
	/*
	$requete = "UPDATE organisme SET ville_ID = '$_REQUEST[id_ville]',
					org_nom = '$_REQUEST[nom]',
					ad_zone1 = '$_REQUEST[adresse]',
					tel1 = '$_REQUEST[tel]'
				WHERE org_ID = '$_REQUEST[maj]'";
	$resultat = ExecRequete($requete,$connexion);
	*/
}
//print($requete);
header("Location:hopital.php?ID_hopital=$maj");

/**
lit_ur_tot = '$_REQUEST[l1]',
					lit_ur_cd = '$_REQUEST[l2]',
					lit_ur_dechoc = '$_REQUEST[l3]',
					lit_med_tot = '$_REQUEST[l4]',
					lit_med_infec = '$_REQUEST[l5]',
					lit_med_ped = '$_REQUEST[l6]',
					lit_chir_tot = '$_REQUEST[l7]',
					lit_chir_ortho = '$_REQUEST[l8]',
					lit_chir_neuro = '$_REQUEST[l9]',
					lit_chir_vasc = '$_REQUEST[l10]',
					lit_chir_max = '$_REQUEST[l11]',
					lit_chir_thorax = '$_REQUEST[l12]',
					lit_chir_ped = '$_REQUEST[l13]',
					lit_chir_orl = '$_REQUEST[l14]',
					lit_chir_opht = '$_REQUEST[l15]',
					lit_psy_tot = '$_REQUEST[l16]',
					lit_ssr_tot = '$_REQUEST[l17]',
					lit_ls_tot = '$_REQUEST[l18]',
					lit_rea_tot = '$_REQUEST[l19]',
					lit_rea_ad = '$_REQUEST[l20]',
					lit_rea_ped = '$_REQUEST[l21]',
					reveil_tot = '$_REQUEST[l22]',
					bloc_tot = '$_REQUEST[l23]',
					bloc_ambu = '$_REQUEST[l24]',
					brule_tot = '$_REQUEST[l25]',
					brule_rea = '$_REQUEST[l26]',
					brule_chir = '$_REQUEST[l27]',
					ch_ste = '$_REQUEST[l28]',
					ch_pp = '$_REQUEST[l29]',
					ch_pn = '$_REQUEST[l30]',
					dialyse_tot = '$_REQUEST[l31]',
					bioch = '$_REQUEST[bioch]',
					bioch_p = '$_REQUEST[bioch_p]',
					bacterio = '$_REQUEST[bacterio]',
					bacterio_p = '$_REQUEST[bacterio_p]',
					viro = '$_REQUEST[viro]',
					viro_p = '$_REQUEST[viro_p]',
					parasito = '$_REQUEST[parasito]',
					parasito_p = '$_REQUEST[parasito_p]',
					toxico = '$_REQUEST[toxico]',
					toxico_p = '$_REQUEST[toxico_p]',
					pharma = '$_REQUEST[pharma]',
					pharma_st = '$_REQUEST[pharma_st]',
					pharma_t = '$_REQUEST[pharma_t]',
					rx_std = '$_REQUEST[rx_std]',
					rx_scan = '$_REQUEST[rx_scan]',
					rx_irm = '$_REQUEST[rx_irm]',
					rx_echo = '$_REQUEST[rx_echo]',
					rx_angio = '$_REQUEST[rx_angio]',
					conta = '$_REQUEST[conta]',
					conta_tot = '$_REQUEST[conta_tot]',
					respi_p = '$_REQUEST[respi_p]',
					respi_f = '$_REQUEST[respi_f]',
					b5 = '$_REQUEST[b5]',
					b15 = '$_REQUEST[b15]',
					b50 = '$_REQUEST[b50]',
					litscamp = '$_REQUEST[litscamp]',
					brancard = '$_REQUEST[brancard]',
					couverture = '$_REQUEST[couverture]',
					douche_m = '$_REQUEST[douche_m]',
					douche_f = '$_REQUEST[douche_f]',
					douche_f_r = '$_REQUEST[douche_f_r]',
					tom = '$_REQUEST[tom]',
					tychem_c = '$_REQUEST[tychem_c]',
					tychem_f = '$_REQUEST[tychem_f]',
					med_tot = '$_REQUEST[med_tot]',
					med_nucl = '$_REQUEST[med_nucl]',
					med_radio = '$_REQUEST[med_radio]',
					med_radiot = '$_REQUEST[med_radiot]',
					med_infec = '$_REQUEST[med_infec]',
					med_leg = '$_REQUEST[med_leg]',
					med_urg = '$_REQUEST[med_urg]',
					med_ped = '$_REQUEST[med_ped]',
					chir_tot = '$_REQUEST[chir_tot]',
					chir_ortho = '$_REQUEST[chir_ortho]',
					chir_dig = '$_REQUEST[chir_dig]',
					chir_neuro = '$_REQUEST[chir_neuro]',
					chir_main = '$_REQUEST[chir_main]',
					chir_orl = '$_REQUEST[chir_orl]',
					chir_opht = '$_REQUEST[chir_opht]',
					chir_max = '$_REQUEST[chir_max]',
					chir_thorax = '$_REQUEST[chir_thorax]',
					chir_vasc = '$_REQUEST[chir_vasc]',
					chir_ped = '$_REQUEST[chir_ped]',
					anes_rea = '$_REQUEST[anes_rea]',
					med_pharma = '$_REQUEST[med_pharma]',
					med_bio = '$_REQUEST[med_bio]',
					med_psy = '$_REQUEST[med_psy]',
					s_femme = '$_REQUEST[s_femme]',
					n_med_tot = '$_REQUEST[n_med_tot]',
					psycho = '$_REQUEST[psycho]',
					brancardier = '$_REQUEST[brancardier]',
					ambu = '$_REQUEST[ambu]',
					inf_tot = '$_REQUEST[inf_tot]',
					ide = '$_REQUEST[ide]',
					iade = '$_REQUEST[iade]',
					ibode = '$_REQUEST[ibode]',
					a_s = '$_REQUEST[a_s]',
					manip = '$_REQUEST[manip]',
					labor = '$_REQUEST[labor]',
					*/
?>
