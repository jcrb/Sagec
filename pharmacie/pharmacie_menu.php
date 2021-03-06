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
//	programme: 		pharmacieo_menu.php
//	date de cr�ation: 	26/10/2004
//	auteur:			jcb
//	description:		affiche un choix d'options
//	version:			1.0
//	maj le:			26/10/2004
//
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
print("<title> menu service </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY>");
print("<FORM name=\"menu\" method=\"get\" TARGET=\"midle\" action=\"carto_main.php\">");

print("<UL>");
		print("<LI><A HREF = \"../sagec67.php\" TARGET=\"_TOP\">Retour</A>");
print("</UL>");
//------------------------------------- M�dicaments -------------------------------------
print("<fieldset class=\"time_v\">");
print("<legend>M�dicaments</legend>");
print("<LI><A HREF = \"medicament_fiche.php\" TARGET=\"middle\">Nouveau</A>");
print("<LI><A HREF = \"med_liste.php\" TARGET=\"middle\">Liste</A>");
print("</fieldset>");
//------------------------------------- M�dico-technique --------------------------------
print("<fieldset class=\"time_v\">");
print("<legend>M�dico-Technique</legend>");
print("<LI><A HREF = \"materiel_fiche.php\" TARGET=\"middle\">Nouveau</A>");
print("<LI><A HREF = \"materiel_liste.php\" TARGET=\"middle\">Liste</A>");
print("<LI><A HREF = \"materiel_lot.php\" TARGET=\"middle\">Lots</A>");
print("<LI><A HREF = \"materiel_liste_lot.php\" TARGET=\"middle\">Liste Lots</A>");
print("</fieldset>");
//------------------------------------- Conteneurs -------------------------------------
print("<fieldset class=\"time_r\">");
print("<legend>Conteneurs</legend>");
print("<LI><A HREF = \"stockage_saisie.php\" TARGET=\"middle\">nouveau</A>");
print("<LI><A HREF = \"conteneur_liste.php\" TARGET=\"middle\">liste</A>");
print("<LI><A HREF = \"cree_psm.php\" TARGET=\"middle\">Cr�e PSM2</A>");
print("</fieldset>");
//------------------------------------- Locaux ---------------------------------------
print("<fieldset class=\"time_r\">");
print("<legend>Locaux</legend>");
print("<LI><A HREF = \"stockage_liste.php\" TARGET=\"middle\">Zones de stockage</A>");
print("<LI><A HREF = \"local_saisie.php\" TARGET=\"middle\">Nouvelle zone</A>");
print("</fieldset>");
//------------------------------------- Lots -------------------------------------------
print("<fieldset class=\"time_r\">");
print("<legend>Lots</legend>");
print("<LI><A HREF = \"medicament_lot.php\" TARGET=\"middle\">nouveau</A>");
print("<LI><A HREF = \"medicament_liste.php\" TARGET=\"middle\">liste</A>");
print("<LI><A HREF = \"Dialog.html\" TARGET=\"middle\">TEST</A>");
print("<LI><A HREF = \"tabsTest.php\" TARGET=\"middle\">TEST TAB</A>");
print("<LI><A HREF = \"accordion.php\" TARGET=\"middle\">ACCORDION</A>");
print("</fieldset>");


//print("<br><input type = \"submit\" name = \"ok\" value=\"executer\">");

print("</FORM>");
print("</BODY>");
print("</html>");
?>
