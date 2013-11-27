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
//	programme: 			biotox_inventaire_resultats.php													   //
//	date de création: 	02/02/2004															   //
//	auteur:				jcb																	   //
//	description:		Création de cartes
//														 				   //
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
$back = "biotox_inventaire_resultats.php";
print("<FORM NAME=\"materiel\" action=\"biotox_inventaire_maj.php?back=$back\" method=\"get\">");

$requete = "SELECT dotation_ID,dotation_qte, dotation.fournisseur_ID , dotation.acheteur_ID, date_achat,marque_ID,
					fournisseur_nom, acheteur_nom,materiel_nom,ville_nom
			FROM dotation,fournisseur,acheteur,materiel,ville ";
	if($_GET['type_ville'] > 0)
			$requete = $requete."WHERE dotation.ville_ID = '$_GET[type_ville]' ";
	else
			$requete = $requete."WHERE dotation.ville_ID LIKE '%' ";
	if($_GET['type_materiels'] > 0)
		$requete = $requete."AND materiel.materiel_ID = '$_GET[type_materiels]' ";
	else
		$requete = $requete."AND materiel.materiel_ID LIKE '%' ";

	$requete = $requete."AND fournisseur.fournisseur_ID = dotation.fournisseur_ID ";
	$requete = $requete."AND acheteur.acheteur_ID = dotation.acheteur_ID ";
	$requete = $requete."AND materiel.materiel_ID = dotation.materiel_ID ";
	$requete = $requete."AND ville.ville_ID = dotation.ville_ID ";
	$requete.="ORDER BY materiel_nom";
	//print($requete."<BR>");
$resultat = ExecRequete($requete,$connexion);
print("<TABLE 100% BORDER=\"1\" CELLSPACING=\"0\">");
	print("<TR BGCOLOR=\"silver\">");
		print("<TD>Matériel</TD>");
		print("<TD>Localisation</TD>");
		print("<TD>Acheteur</TD>");
		print("<TD>Fournisseur</TD>");
		print("<TD>Date achat</TD>");
		print("<TD>Type</TD>");
		print("<TD>Quantité</TD>");
	print("</TR>");
while($rub=mysql_fetch_array($resultat))
{
	print("<TR>");
		print("<TD>$rub[materiel_nom]</TD>");
		print("<TD>$rub[ville_nom]</TD>");
		print("<TD>$rub[acheteur_nom]</TD>");
		print("<TD>$rub[fournisseur_nom]</TD>");
		print("<TD>$rub[date_achat]</TD>");
		print("<TD>$rub[marque_ID]</TD>");
		print("<TD align=\"right\">$rub[dotation_qte]</TD>");
	print("</TR>");
}
print("</TABLE>");

print("<INPUT TYPE=\"hidden\" name=\"dotation_ID\" VALUE=\"$rub[dotation_ID]\">");
print("<INPUT TYPE=\"hidden\" name=\"type_ville\" VALUE=\"$_GET[type_ville]\">");
print("<INPUT TYPE=\"hidden\" name=\"type_materiels\" VALUE=\"$_GET[type_materiels]\">");
print("<INPUT TYPE=\"hidden\" name=\"fournisseur\" VALUE=\"$rub[fournisseur_ID]\">");
print("<INPUT TYPE=\"hidden\" name=\"acheteur\" VALUE=\"$rub[acheteur_ID]\">");





print("</FORM>");


?>
