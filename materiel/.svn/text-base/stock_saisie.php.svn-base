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
//	programme: 		stock_saisie.php													   //
//	date de création: 	20/08/2004															   //
//	auteur:				jcb																	   //
//	description:		Saisie d'une dotation
//						ATTENTION: ne vérifie pas si doublon									 				   //
//	version:			1.0																	   //
//	maj le:														                       //
//																							   //  
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
//require("../biotox_utilitaires.php");
require("materiel_utilitaires.php");

print("<head>");
print("<title> stock </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM NAME=\"materiel\" action=\"biotox_inventaire_enregistre.php\" method=\"get\">");
$back = "biotox_materiel.php";// mettre un champ caché
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

if($_GET[type_ville])
{

	$requete="SELECT ville_nom FROM ville WHERE ville_ID = '$_GET[type_ville]'";
	$resultat = ExecRequete($requete,$connexion);
	$ville=mysql_fetch_array($resultat);
	print("<input type=\"hidden\" name=\"ville_id\" value=\"$_GET[type_ville]\">");

	$requete="SELECT materiel_nom FROM materiel WHERE materiel_ID = '$_GET[type_materiels]'";
	$resultat = ExecRequete($requete,$connexion);
	$mat=mysql_fetch_array($resultat);
	print("<input type=\"hidden\" name=\"materiel_id\" value=\"$_GET[type_materiels]\">");

	print("<TABLE 100%>");
		print("<TR><TD class=\"grise\">$ville[ville_nom]</TD></TR>");
		print("<TR><TD class=\"red\">$mat[materiel_nom]</TD></TR>");
	print("</TABLE>");

	$requete = "SELECT dotation_ID,dotation.ville_ID,dotation_qte, dotation.materiel_ID, fournisseur_ID , acheteur_ID,
	 			date_achat,marque_ID,ville.ville_nom,materiel_nom
			FROM dotation,ville,materiel
			WHERE dotation.ville_ID = '$_GET[type_ville]'
			AND dotation.materiel_ID = '$_GET[type_materiels]'
			AND ville.ville_ID = dotation.ville_ID
			AND materiel.materiel_ID = dotation.materiel_ID
			";
	if($_GET["type_fournisseur"]==0) $requete .= " AND fournisseur_ID LIKE '%' ";
	else $requete .= " AND fournisseur_ID = '$_GET[type_fournisseur]'";

	$resultat = ExecRequete($requete,$connexion);
	$num_rows = 0;
	$num_rows = mysql_num_rows($resultat);	// si $num_rows > 1 => plusieurs réponses à afficher
									// si $num_rows = 0 => nouveau produit
	print("<input type=\"hidden\" name=\"num_rows\" value=\"$num_rows\">");

//print("requête: ".$requete."<br>");

print("<TABLE 100%>");
print("<TR class=\"Style24\">");
	print("<TD class=\"blue\">N°</TD>");
	print("<TD class=\"blue\">fournisseur</TD>");
	print("<TD class=\"blue\">acheteur</TD>");
	print("<TD class=\"blue\">type</TD>");
	print("<TD class=\"blue\">date (aaaa-mm-jj)</TD>");
	print("<TD class=\"blue\">quantité</TD>");
print("</TR>");

$inventaire_id=array();
// nouveau produit
	if($num_rows == 0)
	{
		print("<TR>");
			print("<TD >xxxx</TD>");
			print("<TD>");
				liste_fournisseurs($connexion,$_GET[type_fournisseur],$langue);//id_fournisseur[]
			print("</TD>");
			print("<TD>");
				liste_acheteurs($connexion,$_GET[type_acheteur],$langue);
			print("</TD>");
			print("<TD>$rub[marque_ID]</TD>");
			print("<TD>");
				print("<input type=\"text\" name=\"date[]\" value=\"$rub[date_achat]\">");
			print("</TD>");
			print("<TD>");
				print("<input type=\"text\" name=\"qte[]\" value=\"$rub[dotation_qte]\">");
			print("</TD>");
		print("</TR>");
	}
	else
	{
		$total = 0;
		while($rub=mysql_fetch_array($resultat))
		{
			print("<TR>");
			print("<TD>$rub[dotation_ID]</TD>");
			print("<input type=\"hidden\" name=\"inventaire[]\" value=\"$rub[dotation_ID]\">");
			print("<TD>");
				liste_fournisseurs($connexion,$rub[fournisseur_ID],$langue);//id_fournisseur[]
			print("</TD>");
			print("<TD>");
				liste_acheteurs($connexion,$rub[acheteur_ID],$langue);
			print("</TD>");
			print("<TD>$rub[marque_ID]</TD>");
			print("<TD>");
				print("<input type=\"text\" name=\"date[]\" value=\"$rub[date_achat]\">");
			print("</TD>");
			print("<TD>");
				print("<input type=\"text\" name=\"qte[]\" value=\"$rub[dotation_qte]\">");
				$total = $total + $rub[dotation_qte];
			print("</TD>");
			print("</TR>");
		}
		print("<TR><TD>&nbsp;</TD><TD>&nbsp;</TD><TD>&nbsp;</TD><TD>&nbsp;</TD><TD>&nbsp;</TD><TD class=\"red\">Total = $total</TD></TR>");
	}
	print("</TABLE>");

	print("<input type=\"submit\" name=\"ok\" value=\"valider\">");
}

print("</FORM>");
?>
