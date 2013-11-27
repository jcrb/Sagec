<?php
//----------------------------------------- SAGEC --------------------------------------------------------
// This file is part of SAGEC67 Copyright (C) 2003-2004 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------------------------------

include("utilitaires/table.php");
include("html.php");
print("<html>");
print("<head>");
print("<title> SAGEC 67 - Documentation </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");		

// TITRE
TblDebut(0,"100%");
	TblDebutLigne();
	TblCellule(Image('images/SAMU.jpeg',50,50));
	TblCellule("<B>SAGEC 67 - DOCUMENTATION</B>",1,1,"TITRE");
	TblCellule("<a href='sagec67.php'>Retour",1,1);// \"SAGEC67.php\"
	TblFinLigne();
TblFin();
print("<hr>");// barre horizontale	
TblDebut(0,"100%",0);
$_style = "";

// Doc SAGEC
	TblDebutLigne();
		TblCellule("<B>Doc SAGEC</B>");
		TblCellule("<div align=\"left\"><a href=\"../docs/sagec.pdf\"><B>Mode d'emploi (version provisoire en cours de développement)</B></a>");
		TblCellule("<div align=\"left\"><a href=\"wikini\"><B>Wikini Sagec</B></a>");
	TblFinLigne();
	TblDebutLigne();TblCellule("___________");TblFinLigne();

	// GENERALITE
	TblDebutLigne();
		TblCellule("<B>Doc générale</B>");
		TblCellule("<div align=\"left\"><a href=\"../docs/vp_samu.pdf\"><B>Consignes Vigie Pirate</B></a>");
		TblCellule("<div align=\"left\"><a href=\"http://encyclopedia.airliquide.com/safety-result.asp?MSDSLanguage_ID=2&LanguageID=2&CountryID=19\" target=\"_blanck\"><B>Encyclopédie des gaz</B></a>");
	TblFinLigne();
	
	// PLAN BLANC
	TblDebutLigne();TblCellule("___________");TblFinLigne();
	TblDebutLigne();
		TblCellule("<B>Plan Blanc</B>");
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_blanc/circ_020503.pdf\"><B>Circulaire</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("<B>PPI Bayer</B>");
		TblCellule("<div align=\"left\"><a href=\"../docs/ppi/bayer/Bayer.pdf\"><B>Fiche réflexe</B></a>");
		TblCellule("<div align=\"left\"><a href=\"../docs/ppi/bayer/carte1.jpg\"><B>Localisation</B></a>");
		TblCellule("<div align=\"left\"><a href=\"../docs/ppi/bayer/fiches_tox/ACRYLO.htm\"><B>Acrylonitrile</B></a>");
		TblCellule("<div align=\"left\"><a href=\"../docs/ppi/bayer/fiches_tox/AMMONIAC.htm\"><B>Ammoniaque</B></a>");
		TblCellule("<div align=\"left\"><a href=\"../docs/ppi/bayer/fiches_tox/BUTADIEN.htm\"><B>Butadiène</B></a>");
	TblFinLigne();

	// BIOTOX
	TblDebutLigne();TblCellule("___________");TblFinLigne();
	TblDebutLigne();
		TblCellule("<B>BIOTOX</B>");
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_biotox/fiche1.pdf\"><B>fiche 1 - Le « Plan national de réponse à une menace de variole »</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_biotox/fiche2.pdf\"><B>fiche 2 - Stratégie de réponse graduée</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");	
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_biotox/fiche3.pdf\"><B>fiche 3 - Equipe nationale d’intervention contre la variole</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_biotox/fiche4.pdf\"><B>fiche 4 - Contre-indications à la vaccination contre la variole</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_biotox/fiche5.pdf\"><B>fiche 5 - Variole : le virus et la maladie</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");	
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_biotox/fiche6.pdf\"><B>fiche 6 - Le vaccin contre la variole</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_biotox/fiche7.pdf\"><B>fiche 7 - Les vaccins contre la variole : les effets secondaires</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_biotox/fiche8.pdf\"><B>fiche 8 - Variole : les vaccins disponibles</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");	
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_biotox/fiche9.pdf\"><B>fiche 9 - Définition des cas de variole,signalement et notification à l’autorité sanitaire</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_biotox/fiche10.pdf\"><B>fiche 10 - Prise en charge des malades atteints ou susceptibles d'être atteints par la variole</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_biotox/fiche11.pdf\"><B>fiche 11 - Prise en charge des sujets contacts (personnes exposées au virus)</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");	
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_biotox/fiche12.pdf\"><B>fiche 12 - Organisation de la vaccination collective</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");	
		TblCellule("<div align=\"left\"><a href=\"../docs/plan_biotox/fiche13.pdf\"><B>fiche 13 - Les plans étrangers de réponse à une attaque de variole</B></a>");
	TblFinLigne();
	
	// SELON LE GERME
	TblDebutLigne();TblCellule("___________");TblFinLigne();
	TblDebutLigne("$_style");
		TblCellule("<div align=\"left\"> Charbon-Anthrax");
		TblCellule("<div align=\"left\"><a href=\"../docs/charbon.pdf\"><B>Charbon</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/cipro.pdf\"><B>Ciflox</B></a>");
	TblFinLigne();

	// PIRATOME
	TblDebutLigne();TblCellule("___________");TblFinLigne();
	TblDebutLigne();
		TblCellule("<B>PIRATOME</B>");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratome/guide_national/GENERALITES.PDF\"><B>Généralités</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratome/guide_national/GUIDE_NUCLEAIRE.PDF\"><B>Intervention médicale en cas d'évènement nucléaire ou radiologique</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratome/guide_national/INTERROGATOIRE.PDF\"><B>Interrogatoire et description des circonstances accidentelles</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratome/guide_national/CONTAMINATION.PDF\"><B>CAT en cas de contamination</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratome/guide_national/IRRADIATION.PDF\"><B>Prise en charge en cas d'irradiation'</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratome/guide_national/lesions.pdf\"><B>CAT en cas de lésions radiocontaminées</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratome/guide_national/PROXIMITE.PDF\"><B>Accueil dans une structure médicalisée de proximité</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratome/guide_national/hopital.pdf\"><B>Accueil dans une structure hospitalière</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratome/guide_national/fiches.pdf\"><B>Fiches techniques</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratome/guide_national/TRAITEMENT.PDF\"><B>CAT selon le produit</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratome/guide_national/adresses.pdf\"><B>Adresses utiles</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratome/guide_national/textes.pdf\"><B>Textes</B></a>");
	TblFinLigne();
	
	// PIRATOX
	TblDebutLigne();TblCellule("___________");TblFinLigne();
	TblDebutLigne();
		TblCellule("<B>PIRATOX</B>");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratox/circulaire_700.pdf\"><B>Circulaire 700</B></a>");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratox/annexe_700.pdf\"><B>Annexes circulaire 700</B></a>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratox/chlore.pdf\"><B>Chlore</B></a>");
		TblCellule("<div align=\"left\"><a href=\"../docs/piratox/phosgene.pdf\"><B>Phosgène</B></a>");
	TblFinLigne();
TblFin();		
print("<hr>");// barre horizontale
print("<div align=\"left\">");
print("</div>");
print("</body>");
print("</html>");

?>
