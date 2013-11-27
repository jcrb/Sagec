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
//----------------------------------------- SAGEC ---------------------------------------------
//												
//	programme: 		sagec67.php							
//	date de création: 	18/08/2003							
//	auteur:			jcb								
//	description:										
//	version:		1.0								
//	maj le:			26/12/2003	menu_administrateur
//				7/03/2004	supression de l'affichage de la langue		
//	
/**
 * Documents the class following
 * @package Sagec
 * @author JCB
 * @version $Id: sagec67.php 44 2008-04-16 06:55:34Z jcb $
 */											
//---------------------------------------------------------------------------------------------
session_start();
$langue = $_SESSION['langue'];
if(!$langue) $langue='FR';
$backPathToRoot = "./";
if(! $_SESSION['auto_sagec'])header("Location:langue.php");

include("utilitaires/table.php");
include("html.php");
require 'utilitaires/globals_string_lang.php';
require $backPathToRoot."autorisations/droits.php";

print("<html>");
print("<head>");
print("<meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-15\">");
print("<title> SAGEC 67 </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("<link rel=\"shortcut icon\" href=\"images/sagec67.ico\" />");
print("</head>");		

print("<body>");
// TITRE
TblDebut(0,"100%");
	TblDebutLigne();
	TblCellule(Image('images/SAMU.jpeg',50,50));
	//TblCellule("<B>Système d'Aide à la Gestion d'Evènements Catastrophiques</B>",1,1,"TITRE");
	$titre = $string_lang['SAGEC67'][$langue];
	TblCellule("<B> $titre</B>",1,1,"TITRE");
	TblCellule("SAMU 67",1,1);
	TblFinLigne();
/*
	TblDebutLigne();
		TblCellule("&nbsp;");
		TblCellule("Version de développement");
		TblCellule("&nbsp;");
	TblFinLigne();*/
TblFin();
print("<hr>");// barre horizontale	
TblDebut(0,"100%",0);
$_style = "A2";
	TblDebutLigne("$_style");
		$mot = strToUpper($string_lang['VICTIMES'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"gestion_des_victimes.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['LITS'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"lits_disponibles.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['INTERVENANTS'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"intervenants.php\"><B>$mot</B></a>");
		$mot = strToUpper($string_lang['VECTEURS'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"vecteur_head.php\"><B>$mot</B>");
		$mot = strToUpper($string_lang['DOC'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"documents.php\"><B>$mot</B>");
		$mot = "Aide";
		TblCellule("<div align=\"center\" ><a href=\"dokuwiki/index.php\"  rel=\"external\" target=\"_blank\"><B>$mot</B>");
	TblFinLigne();
	
	TblDebutLigne();
		print("<hr>");// barre horizontale
	TblFinLigne();
	
	TblDebutLigne("$_style");
		if(est_autorise("BIOTOX_LIRE"))
			TblCellule("<div align=\"center\"><a href=\"ror/ror_main.php\"><B>ROR</B>");
			
		if($_SESSION['autorisation']>8)
		{
			$mot = strToUpper($string_lang['ADMINISTRATEUR'][$langue]);
			TblCellule("<div align=\"center\"><a href=\"administrateur_menu.php\"><B>$mot</B>");
			TblCellule("<div align=\"center\"><a href=\"materiel/biotox_menu.php\"><B>Biotox</B>");
		}
			
		else
		{
			 TblCellule("&nbsp;");
			 TblCellule("&nbsp;");
		}
		$mot = strToUpper($string_lang['BLOCNOTE'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"blocnote/blocnote_lire.php?back=../sagec67.php\"><B>$mot</B>");
		//$mot = strToUpper($string_lang['SAMU'][$langue]);
		
		$mot= $string_lang['REGULATION'][$langue]."/".$string_lang['PDS'][$langue];
		TblCellule("<div align=\"center\"><a href=\"samu_menu.php\"><B>$mot</B>");
		
		$mot= "Régulation";
		TblCellule("<div align=\"center\"><a href=\"regulation/index.php\"><B>$mot</B>");
		
		$mot= "Secrétariat";
		TblCellule("<div align=\"center\"><a href=\"secretariat/index.php\"><B>$mot</B>");
		
		$mot = strToUpper($string_lang['QUITTER'][$langue]);
		TblCellule("<div align=\"center\"><a href=\"login2.php\"><B>$mot</B>");
		
		TblCellule("<div align=\"center\"><a href=\"\"><B>&nbsp;</B>");
	TblFinLigne();
TblFin();
print("<hr>");// barre horizontale
print("<div align=\"left\">");
//========================================== Utilitaires ==========================================
print("<fieldset>");
print("<LEGEND class=\"time_v\"> Utilitaires </LEGEND>");
	
	print("<A HREF = \" ppi/ppi_frameset.php\">PPI</A><BR>");
	
	print("<A HREF = \"veille_sanitaire/veille_frameset.php\">Veille sanitaire</A><BR>");
	
	print("<A HREF = \"https://www.formation.portailorsec.interieur.gouv.fr\" target=\"_blank\">SYNERGI exercice</A><BR>");
	print("<A HREF = \"https://www.portailorsec.interieur.gouv.fr\" target=\"_blank\">SYNERGI OPERATIONNEL</A><BR>");
	//----------------------------------- Spécifique SAMU 67 --------------------------------------
	require("pma_connect.php");
	require("pma_connexion.php");
	require("pma_requete.php");
	
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	$requete="SELECT service_ID from service WHERE service_nom ='SAMU 67'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	if($_SESSION['service']==$rub['service_ID'])
		print("<a href=\"tr_cus/tourDeRole_frameset.php\"><B>ASSU CUS</B></a><br>");
	if($_SESSION['autorisation']>2){
		print("<A HREF = \" gis/gis_frameset.php\">SIG</A><BR>");
		//print("<A HREF = \" hxp/have.php\">HAVE</A><BR>");
		print("<A HREF = \" hxp/hpx_menu.php\">HAVE</A><BR>");
		print("<A HREF = \" pma/MenuTemp_structure.php\">PMA</A><BR>");
		print("<A HREF = \" victime/victime_saisie.php\">Victime</A><BR>");
		print("<A HREF = \" medecin/medecin_frameset.php\">Medecins</A><BR>");
		print("<A HREF = \" mto/metar.php\">Météo</A><BR>");
		print("<A HREF = \" contact/annuaire.php\">Annuaire</A><BR>");
		print("<A HREF = \"arh/liste_hopitaux.php\">hôpitaux d'Alsace</A><BR>");
		print("<A HREF = \"liste_hopitaux_service.php\">hôpitaux & services</A><BR>");
		print("<A HREF = \"crra/crra_frameset.php\">CRRA</A><BR>");
		
	}
	if($_SESSION['autorisation']>9)
	{
		 print("<A HREF = \"wml_test.html\">WML</A><BR>");
		 
		 print("<A HREF = \"ppi/kml_parser.php\">KML</A><BR>");
		 print("<A HREF = \"page_de_test.php\">Ma page de tests</A><BR>");
		 print("<A HREF = \"mail_test.php\">Test Mail</A><BR>");
	}

print("</fieldset>");

// partie expérimentale

if($_SESSION['autorisation']>8)
{
	print("<fieldset class=\"Style22\">");
	print("<LEGEND > Développements en cours </LEGEND>");
	$filname="essai_archive.txt";
	$dir= "/var/www/html/SAGEC 67/archives".$filname;

	print("<A HREF = \"archive_create.php?dir=$dir&filname=$filname\"> Test fichier </A><BR>");
	print("<A HREF = \"checklist/tache_frameset.php\"> Check-List </A><BR>");
	print("<A HREF = \"evenement/resume.php\"> Résumé </A><BR>");
	print("<A HREF = \"ita/ita_saisie.php\">Indice thérapeuthique ambulatoire </A><BR>");
	print("<A HREF = \"carto2/cherche_moyen.php\">teste moyen</A><BR>");
	print("<A HREF = \"BD_Connect.php\">connexion à une autre BD</A><BR>");
	
	print("<A HREF = \"pharmacie/pharmacie_frameset.php\">Pharmacie</A><BR>");
	print("<A HREF = \"pharmacy/pharmacy_main.php\">Pharmacy</A><BR>");
	print("<A HREF = \"pharmacies/extract_med.php\">Medecin</A><BR>");
	
	print("<A HREF = \"veille_sanitaire/veille_frameset.php\">Veille sanitaire</A><BR>");
	print("<A HREF = \"dossier/dossier_frameset.php\">Dossier médical</A><BR>");
	print("<A HREF = \" download2.php\">download</A><BR>");
	print("<A HREF = \" synoptique/synoptique_frame.php\">Synoptique</A><BR>");
	print("<A HREF = \" reporting/reporting_choix.php\">Reporting</A><BR>");
	print("<A HREF = \" carto2/allemagne.php\">Allemagne</A><BR>");
	print("<A HREF = \" carto2/teste_rea.php\">Teste Réa</A><BR>");
	print("<A HREF = \" googlemap.php\">Google Map</A><BR>");
	print("<A HREF = \" googlemap/google_test.php\">Google test</A><BR>");
	print("<A HREF = \" blocop/bloc_test.php\">Bloc test</A><BR>");
	print("<A HREF = \" veille_sanitaire/alerte/alerte_menu.php\">Alarme</A><BR>");
	print("<A HREF = \" veille_sanitaire/rpu/rpu.php\">RPU</A><BR>");
	print("<A HREF = \" veille_sanitaire/test_sau.php\">test SAU</A><BR>");
	print("<A HREF = \" hxp/dataBase2xml.php\">Récupère data</A><BR>");


	// utilitaires temporaires
	//print("<A HREF = \" utilitaires/hop2service.php\">hopital->service</A><BR>");
	//print("<A HREF = \" utilitaires/nettoie_commune.php\">nettoie commune</A><BR>");
	print("<A HREF = \" cherche_adresse.php\">adresse</A><BR>");
	print("<A HREF = \" pds/pds_frameset.php\">PDS</A><BR>");
	print("<A HREF = \" reporting/teste_histogramme.php\">histogramme</A><BR>");
	print("<A HREF = \" reporting/teste_artichow.php\">Artichow</A><BR>");
	print("<A HREF = \" info_lits/analyse_fichiers.php\">sagec echange</A><BR>");
	
	print("</fieldset>");
}
if($_SESSION['auto_test'])
{
	print("<fieldset>");
		print("<A HREF = \" cadre_test.php\">Cadre test</A><BR>");
		print("<A HREF = \"arh/arh_request/arh_frameset.php\">Test ARH</A><BR>");
		print("<A HREF = \"hopital/score_pdl.php\">Score PDL</A><BR>");
	print("</fieldset>");
}

//========================== mofications ==================================================
print("<br>");
print("<fieldset>");
print("<LEGEND class=\"time_v\"> Version actuelle </LEGEND>");
include("sagec_version.php");
print("Version courante de SAGEC: ".version_sagec."<br>");
print("Dernière mise à jour: ".date_modif_sagec."<br>");
print("Version courante de la base de données: ".version_pma."<br>");
print("Dernière mise à jour: ".date_modif_pma."<br>");
print("</fieldset>");
print("</div>");

print_r(get_loaded_extensions());
if (!extension_loaded('freetype'))
	print("yes");
	else print("no");

print("</body>");
print("</html>");
?>
