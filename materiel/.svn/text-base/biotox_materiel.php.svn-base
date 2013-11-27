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

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$back = "biotox_materiel.php";
print("<FORM NAME=\"materiel\" action=\"biotox_inventaire_enregistre.php?back=$back\" method=\"post\">");

print("<H2>Saisie d'une dotation NRBC</H2><BR>");

$requete = "SELECT ville_ID,dotation_qte, materiel_ID, fournisseur_ID , acheteur_ID, date_achat,marque_ID
			FROM dotation
			WHERE dotation_ID = '$_GET[last_ID]'";
print($last_ID."<BR>");			
$resultat = ExecRequete($requete,$connexion);
$rub=mysql_fetch_array($resultat);
print($rub[0]." - ".$rub[1]." - ".$rub[2]." - ".$rub[3]." - ".$rub[4]."<BR>");

print("<TABLE 100%>");
	print("<TR>");
		print("<TD>");
			print("Localisation");
		print("</TD>");
		print("<TD>");
			liste_ville($connexion,$rub[ville_ID]);//type_ville
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>");
			print("Matériel");
		print("</TD>");
		print("<TD>");
			liste_materiel($connexion,$rub[materiel_ID]);//type_materiels
		print("</TD>");
		print("<TD>");
			print("<A HREF=\"materiel_nouveau.php?back=biotox_materiel.php\">Ajouter un matériel</A>");
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>");
			print("fournisseur");
		print("</TD>");
		print("<TD>");
			liste_fournisseurs($connexion,$rub[fournisseur_ID]);//type_fournisseur
		print("</TD>");
		print("<TD>");
			print("<A HREF=\"fournisseur_nouveau.php?back=biotox_materiel.php\">Ajouter un fournisseur</A>");
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>");
			print("acheteur");
		print("</TD>");
		print("<TD>");
			liste_acheteur($connexion,$rub[acheteur_ID]);
		print("</TD>");
		print("<TD>");
			print("<A HREF=\"acheteur_nouveau.php?back=biotox_materiel.php\">Ajouter un acheteur</A>");
		print("</TD>");
	print("</TR>");

	print("<TR>");
		print("<TD>");
		print("");
		print("</TD>");
		print("<TD>");
		print("<A HREF=\"affiche_stock.php?type_ville=$type_ville\">Stock existant</A>");
		print("</TD>");
	print("</TR>");

	print("<TR>");
		print("<TD>");
			print("quantité");
		print("</TD>");
		print("<TD>");
			print("<INPUT TYPE=\"text\" name=\"qte\" VALUE=\"$rub[dotation_qte]\">");
		print("</TD>");
	print("</TR>");

	print("<TR>");;
		print("<TD>");
			print("date d'achat");
		print("</TD>");
		print("<TD>");
			print("<INPUT TYPE=\"text\" name=\"achat\" VALUE=\"$rub[date_achat]\">");
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>");
			print("type de matériel");
		print("</TD>");
		print("<TD>");
			print("<INPUT TYPE=\"text\" name=\"type_materiel\">");
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>");
			print("<A HREF=\"biotox_menu.php\">Retourner au menu principal</A>");
		print("</TD>");
		print("<TD>");
			print("<INPUT TYPE =\"submit\" name=\"ok\" value=\"valider\">");
		print("</TD>");
	print("</TR>");
print("</TABLE>");

print("</FORM>");

?>
