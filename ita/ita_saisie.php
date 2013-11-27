<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//=============================================================================
//
//	ita_saisie.php
//	Organisation des intervenants
//	crée le 04/06/2004
//=============================================================================
session_start();
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
include("../utilitaires/table.php");

//include_once ("intervenants_menu.php");
//menu_intervenants($_SESSION['langue']);

print("<html>");
print("<head>");
print("<title> ITA saisie </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM name =\"ita\"  ACTION=\"ita_enregistre.php\" METHOD=\"GET\">");

//======================================== Dossier ======================================
print("<FIELDSET>");
print("<LEGEND class=\"time\"> Dossier</LEGEND>");
print("<TABLE width=\"100%\" bgcolor=\"wheat\" class=\"time\">");
print("<TR valign=\"top\" align=\"left\">");
	TblCellule("N° de dossier <INPUT TYPE=\"TEXT\"  NAME=\"dossier\">","","","time");
	TblCellule("CCMU <INPUT TYPE=\"TEXT\"  NAME=\"ccmu\" >","","","time");
	TblCellule("<INPUT TYPE=\"submit\"  NAME=\"ok\"  value=\"Valider\">","","","time");
print("</TR>");
print("</TABLE>");
print("</FIELDSET>");
$rub = NULL;
$check = Null;
//================================================== Appareil Respiratoire ========================================
print("<FIELDSET>");
print("<LEGEND class=\"time\"> Appareil Respiratoire </LEGEND>");
print("<TABLE width=\"100%\" bgcolor=\"wheat\" class=\"time\">");
print("<TR valign=\"top\" align=\"left\">");
//-------------------------- VA ----------------------------------
	if($rub->va) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"va\" $check value=\"o\"> VA","","","time_v");
	$check = "";
//-------------------------- IOT ----------------------------------
	if($rub->iot) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"iot\" $check value=\"o\"> IOT","","","time_v");
	$check = "";
//-------------------------- Bronchoaspiration ----------------------------------
	if($rub->bronchoaspiration) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"bronchoaspiration\" $check value=\"o\"> Bronchoaspiration","","","time_v");
	TblCellule("&nbsp;");
	TblCellule("&nbsp;");
print("</TR>");
print("<TR valign=\"top\" align=\"left\">");
//-------------------------- VNI ----------------------------------
	if($rub->vni) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"vni\" $check value=\"o\"> VNI","","","time_v");
	$check = "";
//-------------------------- INT ----------------------------------
	if($rub->int) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"int\" $check value=\"o\"> INT","","","time_v");
	$check = "";
//-------------------------- Drainage tho ----------------------------------
	if($rub->bronchoaspiration) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"drainage_tho\" $check value=\"o\"> Drainage Thoracique","","","time_v");
	$check = "";
	TblCellule("&nbsp;");
	TblCellule("&nbsp;");
print("</TR>");

print("<TR valign=\"top\" align=\"left\">");
//-------------------------- O2 ----------------------------------
	if($rub->o2) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"o2\" $check value=\"o\"> O2","","","time_v");
	$check = "";
//-------------------------- IOT rétrograde ----------------------------------
	if($rub->retrograde) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"retrograde\" $check value=\"o\"> IOT rétrograde","","","time_v");
	$check = "";
//-------------------------- Heimlich ----------------------------------
	if($rub->heimlich) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"heimlich\" $check value=\"o\"> Heimlich","","","time_v");
	TblCellule("&nbsp;");
	TblCellule("&nbsp;");
print("</TR>");
print("<TR valign=\"top\" align=\"left\">");
//-------------------------- AG ----------------------------------
	if($rub->ag) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"ag\" $check value=\"o\"> Anesthésie générale","","","time_v");
	$check = "";
//-------------------------- masque laryngé ----------------------------------
	if($rub->masque_larynge) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"masque_larynge\" $check value=\"o\">  masque laryngé","","","time_v");
	$check = "";
//-------------------------- désobstruction ----------------------------------
	if($rub->desobstruction) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"desobstruction\" $check value=\"o\"> Désobstruction instrumentale VAS","","","time_v");
	$check = "";
	TblCellule("&nbsp;");
	TblCellule("&nbsp;");
print("</TR>");
print("<TR valign=\"top\" align=\"left\">");
//-------------------------- Sédation ----------------------------------
	if($rub->ag) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"ag\" $check value=\"o\"> Anesthésie générale","","","time_v");
	$check = "";
//--------------------------   ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- Aérosol ----------------------------------
	if($rub->aerosoln) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"aerosol\" $check value=\"o\">  Aérosol","","","time_v");
	$check = "";
	TblCellule("&nbsp;");
	TblCellule("&nbsp;");
print("</TR>");
print("</TABLE>");
print("</FIELDSET>");
//======================================== Appareil Circulatoire & médicaments ======================================
print("<FIELDSET>");
print("<LEGEND class=\"time\"> Appareil Circulatoire & médicaments </LEGEND>");
print("<TABLE width=\"100%\" bgcolor=\"wheat\" class=\"time\">");
print("<TR valign=\"top\" align=\"left\">");
//-------------------------- 1 VVP ----------------------------------
	if($rub->vvp1) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"vvp1\" $check value=\"o\"> 1 VVP","","","time_r");
	$check = "";
//-------------------------- Injection IM, IV, SC ----------------------------------
	if($rub->injection) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"injection\" $check value=\"o\"> Injection (autre médicament)","","","time_r");
	$check = "";
//-------------------------- remplissage < 20% ----------------------------------
	if($rub->remplissage_20) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"remplissage_20\" $check value=\"o\"> Remplissage  < 20%","","","time_r");
//-------------------------- Bicar ----------------------------------
	if($rub->bicar) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"bicar\" $check value=\"o\"> Bicarbonates","","","time_r");
	$check = "";
print("</TR>");
print("<TR valign=\"top\" align=\"left\">");
//-------------------------- 2 VVP ----------------------------------
	if($rub->vvp2) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"vvp2\" $check value=\"o\"> 2 VVP","","","time_r");
	$check = "";
//-------------------------- 1 médicament vasoactif ----------------------------------
	if($rub->medic1) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"medic1\" $check value=\"o\"> 1 médicament vasoactif","","","time_r");
	$check = "";
//-------------------------- Remplissage < 50% ----------------------------------
	if($rub->remplissage_inf50) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"remplissage_inf50\" $check value=\"o\"> Remplissage < 50%","","","time_r");
	$check = "";
//-------------------------- Thrombolyse ----------------------------------
	if($rub->thrombolyse) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"thrombolyse\" $check value=\"o\"> Thrombolyse","","","time_r");
	$check = "";
print("</TR>");

print("<TR valign=\"top\" align=\"left\">");
//-------------------------- Voie IO ----------------------------------
	if($rub->io) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"io\" $check value=\"o\"> IO","","","time_r");
	$check = "";
//-------------------------- 2 medicaments ----------------------------------
	if($rub->medic2) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"medic2\" $check value=\"o\"> 2 médicaments vasoactifs","","","time_r");
	$check = "";
//-------------------------- Remplissage > 50%m ----------------------------------
	if($rub->remplissage_sup50) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"remplissage_sup50\" $check value=\"o\"> Remplissage > 50%","","","time_r");
//-------------------------- Antiarythmique ----------------------------------
	if($rub->antiarythmique) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"antiarythmique\" $check value=\"o\"> Antiarythmique","","","time_r");
	$check = "";
print("</TR>");

print("<TR valign=\"top\" align=\"left\">");
//-------------------------- VVC ----------------------------------
	if($rub->vvc) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"vvc\" $check value=\"o\"> VVC","","","time_r");
	$check = "";
//-------------------------- Hémothorax ----------------------------------
	if($rub->autotransfusion) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"autotransfusion\" $check value=\"o\"> Autotransfusion hémotorax","","","time_r");
	$check = "";
//-------------------------- case vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- diurétique ----------------------------------
	if($rub->diuretique) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"diuretique\" $check value=\"o\"> Diurétiques","","","time_r");
	$check = "";
print("</TR>");

print("<TR valign=\"top\" align=\"left\">");
//-------------------------- vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- Transfusion ----------------------------------
	if($rub->transfusion) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"transfusion\" $check value=\"o\"> Transfusion sanguine","","","time_r");
	$check = "";
//-------------------------- case vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- ttt crise convulsive ----------------------------------
	if($rub->convulsion) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"convulsion\" $check value=\"o\"> TTT convulsions","","","time_r");
	$check = "";
print("</TR>");

print("<TR valign=\"top\" align=\"left\">");
//-------------------------- vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- Saignée ----------------------------------
	if($rub->saigne) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"saigne\" $check value=\"o\"> Saignée","","","time_r");
	$check = "";
//-------------------------- Tamponnade ----------------------------------
	if($rub->pericarde) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"pericarde\" $check value=\"o\"> Ponction péricarde","","","time_r");
	$check = "";
//-------------------------- Antibiotique ----------------------------------
	if($rub->antibiotique) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"antibiotique\" $check value=\"o\"> Antibiothérapie","","","time_r");
	$check = "";
print("</TR>");

print("<TR valign=\"top\" align=\"left\">");
//-------------------------- vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- hémostase ----------------------------------
	if($rub->hemostase) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"hemostase\" $check value=\"o\"> Hémostase","","","time_r");
	$check = "";
//-------------------------- Antidote ----------------------------------
	if($rub->antidote) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"antidote\" $check value=\"o\"> Antidote IV","","","time_r");
	$check = "";
print("</TR>");

print("<TR valign=\"top\" align=\"left\">");
//-------------------------- vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- épuration ----------------------------------
	if($rub->epuration) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"epuration\" $check value=\"o\"> Epuration digestive","","","time_r");
	$check = "";
print("</TR>");
print("</TABLE>");
print("</FIELDSET>");
//======================================== Examens et monitorage ======================================
print("<FIELDSET>");
print("<LEGEND class=\"time\"> Examens & monitorage </LEGEND>");
print("<TABLE width=\"100%\" bgcolor=\"wheat\" class=\"time\">");
print("<TR valign=\"top\" align=\"left\">");
//-------------------------- ECG ----------------------------------
	if($rub->ecg) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"ecg\" $check value=\"o\"> ECG","","","time_r");
	$check = "";
//-------------------------- Hématocrite ----------------------------------
	if($rub->hematocrite) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"hematocrite\" $check value=\"o\"> Micohématocrite","","","time_r");
	$check = "";
//-------------------------- CEE ----------------------------------
	if($rub->cee) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"cee\" $check value=\"o\"> CEE","","","time_r");
//-------------------------- PAC ----------------------------------
	if($rub->pac) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"pac\" $check value=\"o\"> PAC (gonflé)","","","time_r");
	$check = "";
print("</TR>");
print("<TR valign=\"top\" align=\"left\">");
//-------------------------- Dextro ----------------------------------
	if($rub->dextro) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"dextro\" $check value=\"o\"> Glycémie","","","time_r");
	$check = "";
//-------------------------- Scope ----------------------------------
	if($rub->scope) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"scope\" $check value=\"o\"> Scope","","","time_r");
	$check = "";
//-------------------------- RCP ----------------------------------
	if($rub->rcp) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"rcp\" $check value=\"o\"> RCP","","","time_r");
//-------------------------- Coquille ----------------------------------
	if($rub->coquille) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"coquille\" $check value=\"o\"> Coquille","","","time_r");
	$check = "";
print("</TR>");
print("<TR valign=\"top\" align=\"left\">");
//-------------------------- Température ----------------------------------
	if($rub->temp) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"temp\" $check value=\"o\"> Température","","","time_r");
	$check = "";
//-------------------------- ETCO2 ----------------------------------
	if($rub->etco2) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"etco2\" $check value=\"o\"> etCo2","","","time_r");
	$check = "";
//-------------------------- EESE ----------------------------------
	if($rub->eese) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"eese\" $check value=\"o\"> EESE","","","time_r");
//-------------------------- fracture 1 ----------------------------------
	if($rub->fracture1) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"fracture1\" $check value=\"o\"> immobilisation 1 fracture","","","time_r");
	$check = "";
print("</TR>");
print("<TR valign=\"top\" align=\"left\">");
//-------------------------- prise de sang ----------------------------------
	if($rub->bilan_sang) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"bilan_sang\" $check value=\"o\"> Prise de sang","","","time_r");
	$check = "";
//-------------------------- enzymologie ----------------------------------
	if($rub->enzyme_card) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"enzyme_card\" $check value=\"o\"> Enzymes cardiaques","","","time_r");
	$check = "";
//-------------------------- vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- fracture2 ----------------------------------
	if($rub->fracture2) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"fracture2\" $check value=\"o\"> Immobilisation de 2 fractures ou plus","","","time_r");
	$check = "";
print("</TR>");
print("<TR valign=\"top\" align=\"left\">");
//-------------------------- SNG ----------------------------------
	if($rub->sbg) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"sng\" $check value=\"o\"> SNG","","","time_r");
	$check = "";
//-------------------------- vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- Bicar ----------------------------------
	if($rub->traction) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"traction\" $check value=\"o\"> Traction orthopédique","","","time_r");
	$check = "";
print("</TR>");
print("<TR valign=\"top\" align=\"left\">");
//-------------------------- SU ----------------------------------
	if($rub->su) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"su\" $check value=\"o\"> Sondage urinaire","","","time_r");
	$check = "";
//-------------------------- vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- vide ----------------------------------
	TblCellule("&nbsp;");
//-------------------------- Refroidissement ----------------------------------
	if($rub->refroidissement) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"refroidissement\" $check value=\"o\"> Refroidissement externe","","","time_r");
	$check = "";
print("</TR>");

print("</TABLE>");
print("</FIELDSET>");

//======================================== Divers ======================================
print("<FIELDSET>");
print("<LEGEND class=\"time\"> Divers </LEGEND>");
print("<TABLE width=\"100%\" bgcolor=\"wheat\" class=\"time\">");
	if($rub->desincar) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"desincar\" $check value=\"o\"> Désincarcération","","","time_r");
	$check = "";
	if($rub->accouchement) $check = "CHECKED";
	TblCellule("<INPUT TYPE=\"CHECKBOX\"  NAME=\"accouchement\" $check value=\"o\"> Accouchement","","","time_r");
	$check = "";
print("</TABLE>");
print("</FIELDSET>");
print("</FORM>");
print("</HTML>");