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
//----------------------------------------- SAGEC ---------------------------------------------//
//																							   //
//	programme: 			biotox_materiel.php													   //
//	date de création: 	02/02/2004															   //
//	auteur:				jcb																	   //
//	description:		Saisie d'une dotation
//						ATTENTION: ne vérifie pas si doublon									 				   //
//	version:			1.0																	   //
//	maj le:				02/02/2004										                       //
//																							   //  
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../biotox_utilitaires.php");

print("<HTML>");
print("<head>");
print("<title> stock gauche </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM NAME=\"gauche\" method=\"get\" action=\"stock_saisie.php\" target=\"midle\">");
print("<H3>Saisie d'une dotation NRBC</H3><BR>");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$back = "biotox_materiel.php";

print("<TABLE 100%>");
	print("<TR><TD>Localisation</TD></TR>");
	print("<TR><TD>");
		liste_ville($connexion,$rub[ville_ID]);//type_ville
	print("</TD></TR>");

	print("<TR><TD>Matériel</TD></TR>");
	print("<TR><TD>");
		liste_materiel($connexion,$rub[materiel_ID]);//type_materiels
	print("</TD></TR>");

	print("<TR><TD>Fournisseur</TD></TR>");
	print("<TR><TD>");
		liste_fournisseurs($connexion,$rub[fournisseur_ID]);//type_fournisseur
	print("</TD></TR>");

	print("<TR><TD>Acheteur</TD></TR>");
	print("<TR><TD>");
		liste_acheteur($connexion,$rub[acheteur_ID]);//type_acheteur
	print("</TD></TR>");

	print("<TR><TD>");
	print("<INPUT TYPE =\"submit\" name=\"ok\" value=\"valider\">");
	print("</TD></TR>");

	print("<TR><TD class=\"red\">");
	print("<A href=\"biotox_menu.php\" target=\"_top\">RETOUR</A>");
	print("</TD></TR>");

	//print("<A HREF=\"materiel_nouveau.php?back=biotox_materiel.php\">Ajouter un matériel</A>");
	//print("<A HREF=\"fournisseur_nouveau.php?back=biotox_materiel.php\">Ajouter un fournisseur</A>");
	//print("<A HREF=\"acheteur_nouveau.php?back=biotox_materiel.php\">Ajouter un acheteur</A>");

print("</TABLE>");

print("</FORM>");
print("</HTML>");
?>
