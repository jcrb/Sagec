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
 * Documents the class hopital_enregistre_PB.php
 * @package Sagec
 * @version $Id$
 * @author JCB
 */
$backPathToRoot = ""; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include($backPathToRoot."adresse_ajout.php");
//
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$maj = $_REQUEST[maj];
//
$l1 = Security::esc2Db($_REQUEST['l1']);
$l2 = Security::esc2Db($_REQUEST['l2']);
$l3 = Security::esc2Db($_REQUEST['l3']);
$l4 = Security::esc2Db($_REQUEST['l4']);
$l5 = Security::esc2Db($_REQUEST['l5']);
$l6 = Security::esc2Db($_REQUEST['l6']);
$l7 = Security::esc2Db($_REQUEST['l7']);
$l8 = Security::esc2Db($_REQUEST['l8']);
$l9 = Security::esc2Db($_REQUEST['l9']);
$l10 = Security::esc2Db($_REQUEST['l10']);
$l11 = Security::esc2Db($_REQUEST['l11']);
$l12 = Security::esc2Db($_REQUEST['l12']);
$l13 = Security::esc2Db($_REQUEST['l13']);
$l14 = Security::esc2Db($_REQUEST['l14']);
$l15 = Security::esc2Db($_REQUEST['l15']);
$l16 = Security::esc2Db($_REQUEST['l16']);
$l17 = Security::esc2Db($_REQUEST['l17']);
$l18 = Security::esc2Db($_REQUEST['l18']);
$l19 = Security::esc2Db($_REQUEST['l19']);
$l20 = Security::esc2Db($_REQUEST['l20']);
$l21 = Security::esc2Db($_REQUEST['l21']);
$l22 = Security::esc2Db($_REQUEST['l22']);
$l23 = Security::esc2Db($_REQUEST['l23']);
$l24 = Security::esc2Db($_REQUEST['l24']);
$l25 = Security::esc2Db($_REQUEST['l25']);
$l26 = Security::esc2Db($_REQUEST['l26']);
$l27 = Security::esc2Db($_REQUEST['l27']);
$l28 = Security::esc2Db($_REQUEST['l28']);
$l29 = Security::esc2Db($_REQUEST['l29']);
$l30 = Security::esc2Db($_REQUEST['l30']);
$l31 = Security::esc2Db($_REQUEST['l31']);
$bioch = Security::esc2Db($_REQUEST[bioch]);
$bioch_p = Security::esc2Db($_REQUEST[bioch_p]);
$bacterio = Security::esc2Db($_REQUEST[bacterio]);
$bacterio_p = Security::esc2Db($_REQUEST[bacterio_p]);
$viro = Security::esc2Db($_REQUEST[viro]);
$viro_p = Security::esc2Db($_REQUEST[viro_p]);
$parasito = Security::esc2Db($_REQUEST[parasito]);
$parasito_p = Security::esc2Db($_REQUEST[parasito_p]);
$toxico = Security::esc2Db($_REQUEST[toxico]);
$toxico_p = Security::esc2Db($_REQUEST[toxico_p]);
$pharma = Security::esc2Db($_REQUEST[pharma]);
$pharma_st = Security::esc2Db($_REQUEST[pharma_st]);
$pharma_t = Security::esc2Db($_REQUEST[pharma_t]);
$rx_std = Security::esc2Db($_REQUEST[rx_std]);
$rx_scan = Security::esc2Db($_REQUEST[rx_scan]);
$rx_irm = Security::esc2Db($_REQUEST[rx_irm]);
$rx_echo = Security::esc2Db($_REQUEST[rx_echo]);
$rx_angio = Security::esc2Db($_REQUEST[rx_angio]);
$conta = Security::esc2Db($_REQUEST[conta]);
$conta_tot = Security::esc2Db($_REQUEST[conta_tot]);
$respi_p = Security::esc2Db($_REQUEST[respi_p]);
$respi_f = Security::esc2Db($_REQUEST[respi_f]);
$b5 = Security::esc2Db($_REQUEST[b5]);
$b15 = Security::esc2Db($_REQUEST[b15]);
$b50 = Security::esc2Db($_REQUEST[b50]);
$litscamp = Security::esc2Db($_REQUEST[litscamp]);
$brancard = Security::esc2Db($_REQUEST[brancard]);
$couverture = Security::esc2Db($_REQUEST[couverture]);
$douche_m = Security::esc2Db($_REQUEST[douche_m]);
$douche_f = Security::esc2Db($_REQUEST[douche_f]);
$douche_f_r = Security::esc2Db($_REQUEST[douche_f_r]);
$tom = Security::esc2Db($_REQUEST[tom]);
$tychem_c = Security::esc2Db($_REQUEST[tychem_c]);
$tychem_f = Security::esc2Db($_REQUEST[tychem_f]);
$med_tot = Security::esc2Db($_REQUEST[med_tot]);
$med_nucl = Security::esc2Db($_REQUEST[med_nucl]);
$med_radio = Security::esc2Db($_REQUEST[med_radio]);
$med_radiot = Security::esc2Db($_REQUEST[med_radiot]);
$med_infec = Security::esc2Db($_REQUEST[med_infec]);
$med_leg = Security::esc2Db($_REQUEST[med_leg]);
$med_urg = Security::esc2Db($_REQUEST[med_urg]);
$med_ped = Security::esc2Db($_REQUEST[med_ped]);
$chir_tot = Security::esc2Db($_REQUEST[chir_tot]);
$chir_ortho = Security::esc2Db($_REQUEST[chir_ortho]);
$chir_dig = Security::esc2Db($_REQUEST[chir_dig]);
$chir_neuro = Security::esc2Db($_REQUEST[chir_neuro]);
$chir_main = Security::esc2Db($_REQUEST[chir_main]);
$chir_orl = Security::esc2Db($_REQUEST[chir_orl]);
$chir_opht = Security::esc2Db($_REQUEST[chir_opht]);
$chir_max = Security::esc2Db($_REQUEST[chir_max]);
$chir_thorax = Security::esc2Db($_REQUEST[chir_thorax]);
$chir_vasc = Security::esc2Db($_REQUEST[chir_vasc]);
$chir_ped = Security::esc2Db($_REQUEST[chir_ped]);
$anes_rea = Security::esc2Db($_REQUEST[anes_rea]);
$med_pharma = Security::esc2Db($_REQUEST[med_pharma]);
$med_bio = Security::esc2Db($_REQUEST[med_bio]);
$med_psy = Security::esc2Db($_REQUEST[med_psy]);
$s_femme = Security::esc2Db($_REQUEST[s_femme]);
$n_med_tot = Security::esc2Db($_REQUEST[n_med_tot]);
$psycho = Security::esc2Db($_REQUEST[psycho]);
$brancardier = Security::esc2Db($_REQUEST[brancardier]);
$ambu = Security::esc2Db($_REQUEST[ambu]);
$inf_tot = Security::esc2Db($_REQUEST[inf_tot]);
$ide = Security::esc2Db($_REQUEST[ide]);
$iade = Security::esc2Db($_REQUEST[iade]);
$ibode = Security::esc2Db($_REQUEST[ibode]);
$a_s = Security::esc2Db($_REQUEST[a_s]);
$manip = Security::esc2Db($_REQUEST[manip]);
$labor = Security::esc2Db($_REQUEST[labor]);
$uat0 = Security::esc2Db($_REQUEST[uat0]);
$uat1 = Security::esc2Db($_REQUEST[uat30]);
$uat2 = Security::esc2Db($_REQUEST[uat60]);
$urt0 = Security::esc2Db($_REQUEST[urt0]);
$urt1 = Security::esc2Db($_REQUEST[urt30]);
$urt2 = Security::esc2Db($_REQUEST[urt60]);
$it0 = Security::esc2Db($_REQUEST[it0]);
$it1 = Security::esc2Db($_REQUEST[it30]);
$it2 = Security::esc2Db($_REQUEST[it60]);
$pblanc = Security::esc2Db($_REQUEST[pblanc]);

	$requete="UPDATE hopital SET
					lit_ur_tot = '$l1',
					lit_ur_cd = '$l2',
					lit_ur_dechoc = '$l3',
					lit_med_tot = '$l4',
					lit_med_infec = '$l5',
					lit_med_ped = '$l6',
					lit_chir_tot = '$l7',
					lit_chir_ortho = '$l8',
					lit_chir_neuro = '$l9',
					lit_chir_vasc = '$l10',
					lit_chir_max = '$l11',
					lit_chir_thorax = '$l12',
					lit_chir_ped = '$l13',
					lit_chir_orl = '$l14',
					lit_chir_opht = '$l15',
					lit_psy_tot = '$l16',
					lit_ssr_tot = '$l17',
					lit_ls_tot = '$l18',
					lit_rea_tot = '$l19',
					lit_rea_ad = '$l20',
					lit_rea_ped = '$l21',
					reveil_tot = '$l22',
					bloc_tot = '$l23',
					bloc_ambu = '$l24',
					brule_tot = '$l25',
					brule_rea = '$l26',
					brule_chir = '$l27',
					ch_ste = '$l28',
					ch_pp = '$l29',
					ch_pn = '$l30',
					dialyse_tot = '$l31',
					bioch = '$bioch',
					bioch_p = '$bioch_p',
					bacterio = '$bacterio',
					bacterio_p = '$bacterio_p',
					viro = '$viro',
					viro_p = '$viro_p',
					parasito = '$parasito',
					parasito_p = '$parasito_p',
					toxico = '$toxico',
					toxico_p = '$toxico_p',
					pharma = '$pharma',
					pharma_st = '$pharma_st',
					pharma_t = '$pharma_t',
					rx_std = '$rx_std',
					rx_scan = '$rx_scan',
					rx_irm = '$rx_irm',
					rx_echo = '$rx_echo',
					rx_angio = '$rx_angio',
					conta = '$conta',
					conta_tot = '$conta_tot',
					respi_p = '$respi_p',
					respi_f = '$respi_f',
					b5 = '$b5',
					b15 = '$b15',
					b50 = '$b50',
					litscamp = '$litscamp',
					brancard = '$brancard',
					couverture = '$couverture',
					douche_m = '$douche_m',
					douche_f = '$douche_f',
					douche_f_r = '$douche_f_r',
					tom = '$tom',
					tychem_c = '$tychem_c',
					tychem_f = '$tychem_f',
					med_tot = '$med_tot',
					med_nucl = '$med_nucl',
					med_radio = '$med_radio',
					med_radiot = '$med_radiot',
					med_infec = '$med_infec',
					med_leg = '$med_leg',
					med_urg = '$med_urg',
					med_ped = '$med_ped',
					chir_tot = '$chir_tot',
					chir_ortho = '$chir_ortho',
					chir_dig = '$chir_dig',
					chir_neuro = '$chir_neuro',
					chir_main = '$chir_main',
					chir_orl = '$chir_orl',
					chir_opht = '$chir_opht',
					chir_max = '$chir_max',
					chir_thorax = '$chir_thorax',
					chir_vasc = '$chir_vasc',
					chir_ped = '$chir_ped',
					anes_rea = '$anes_rea',
					med_pharma = '$med_pharma',
					med_bio = '$med_bio',
					med_psy = '$med_psy',
					s_femme = '$s_femme',
					n_med_tot = '$n_med_tot',
					psycho = '$psycho',
					brancardier = '$brancardier',
					ambu = '$ambu',
					inf_tot = '$inf_tot',
					ide = '$ide',
					iade = '$iade',
					ibode = '$ibode',
					a_s = '$a_s',
					manip = '$manip',
					labor = '$labor',
					uat0 = '$uat0',
					uat1 = '$uat30',
					uat2 = '$uat60',
					urt0 = '$urt0',
					urt1 = '$urt30',
					urt2 = '$urt60',
					it0 = '$it0',
					it1 = '$it30',
					it2 = '$it60'
				WHERE Hop_ID = '$maj'";

	$resultat = ExecRequete($requete,$connexion);

//print($requete);
header("Location:hopital.php?ID_hopital=$_REQUEST[maj]");

?>