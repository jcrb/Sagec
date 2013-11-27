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
//	programme: 			biotox_inventaire_menu.php													   //
//	date de création: 	02/02/2004															   //
//	auteur:				jcb																	   //
//	description:		Création de cartes
//						ATTENTION: CE PROGRAMME NE DOIT COMPORTER AUCUNE SORTIE D'ECRAN
//						FAIT APPEL A HEADER									 				   //
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

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<FORM NAME=\"xx\" TARGET =\"centre\" ACTION=\"biotox_inventaire_resultats.php?type_ville=$type_ville&type_materiels=$type_materiels\" method=\"get\">");
print("<TABLE 100%>");
	print("<TR>");
		print("<TD>");
			print("Localisation");
		print("</TD>");
	print("<TR>");
		print("<TD>");
			liste_ville($connexion,$type_ville);
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>");
			print("Matériel");
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>");
			liste_materiel($connexion,$type_materiels);
		print("</TD>");
	print("</TR>");
	print("<TR>");
	//	print("<TD>");
	//		print("<INPUT TYPE=\"submit\" NAME=\"OK\" VALUE=\"Voir\">");
	//	print("</TD>");
		print("<TD>");
			print(" ");
		print("</TD>");
	print("</TR>");
	

	print("<TR>");
		print("<TD>");
			print("<A HREF=\"fournisseur_nouveau.php?back=biotox_inventaire_resultats.php\" target=\"centre\">Ajouter un fournisseur</A>");
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>");
			print("<A HREF=\"acheteur_nouveau.php?back=biotox_inventaire_resultats.php\" target=\"centre\">Ajouter un acheteur</A>");
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>");
			print("<A HREF=\"materiel_nouveau.php?back=biotox_inventaire_resultats.php\" target=\"centre\">Ajouter un matériel</A>");
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>");
			print("<INPUT TYPE=\"submit\" NAME=\"OK\" VALUE=\"Voir\">");
		print("</TD>");
	print("</TR>");
	print("<TD>");
			print("<A HREF=\"biotox_menu.php\" TARGET=\"_TOP\">Retourner au menu principal</A>");
	print("</TD>");
print("<TABLE>");
print("</FORM>");
?>
