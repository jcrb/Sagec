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
//----------------------------------------- SAGEC --------------------------------------------------------
/**
*	programme: 		stockage_saisie.php
*	date de création: 	01/10/2004
*	@author:			jcb
*	description:		saisie des caractéristiques d'un médicament
*	@version:			1.0
*	maj le:			01/10/2004
*/
//--------------------------------------------------------------------------------------------------------

session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
include("utilitaires_MED.php");

print("<html>");
print("<head>");
print("<title> Médicaments </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("<LINK REL = stylesheet TYPE = \"text/css\" HREF = \"pharma.css\">");
print("</head>");

print("<BODY BGCOLOR=\"#ffffff\" >");
print("<FORM name =\"Services\"  ACTION=\"stockage_enregistre\" METHOD=\"GET\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

if($_GET['stock'])// c'est une mise à jour
{
	$requete="SELECT * FROM stock_conteneur WHERE conteneur_ID = '$_GET[stock]'";
	$resultat = ExecRequete($requete,$connexion);
	$stock=mysql_fetch_array($resultat);
	print("<p>conteneur enregistré</p>");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj\" VALUE=\"$_GET[stock]\">");
}
else
	print("<p>Nouveau conteneur</p>");

print("<table>");
print("<tr>");
	print("<td>Type de stockage</td>");
	print("<td>");
		select_stock($connexion,$stock[med_type_stock]);//ID_stock
	print("</td>");
	print("<td>Nom du stockage</td>");
	print("<td>");
		select_med_localisation($connexion,$stock[med_localisation]);//$ID_medlocal
	print("</td>");
print("</tr>");

print("<tr>");
print("<td>Nom du conteneur</td>");
	print("<td>");
		select_psm($connexion,$stock[conteneur_nom]); //ID_psm
	print("</td>");
	print("<td>numéro</td>");
	print("<td><input type=\"text\" name=\"no_malle\" value=\"$stock[conteneur_no]\"></td>");
print("</tr>");

print("<tr>");
	print("<td>Localisation</td>");
	print("<td>");
		select_stockage($connexion,$stock[stockage_ID]); //$ID_stockage
	print("</td>");
	//print("<td>numéro</td>");
	//print("<td><input type=\"text\" name=\"no_malle\" value=\"$stock[conteneur_no]\"></td>");
	print("<td>Poids ");
	print("<input type=\"text\" name=\"poids\" value=\"\" size=\"3\"> kg</td>");
	print("<td>Volume ");
	print("<input type=\"text\" name=\"volume\" value=\"\" size=\"3\"> m&sup3;</td>");
print("</tr>");

print("</table>");

//if($_GET['stock'])
	print("<br><input type=\"submit\" value=\"modifier\" name=\"ok\">");
//else
	print("<input type=\"submit\" value=\"enregistrer\" name=\"ok\">");
print("<input type=\"submit\" value=\"supprimer\" name=\"ok\"><br><br>");

print("<br>Contenu de la malle<br>");

$requete = "SELECT med_lot_ID,special_nom,dci_nom,med_lot_qte,presentation_nom,medic_dosage,unite_abrev,med_lot_perime
			FROM med_lot,med_specialite,medicament,med_dci,med_presentation,med_unites
			WHERE conteneur_ID = '$_GET[stock]'
			AND med_lot.medic_ID = medicament.medic_ID
			AND medicament.medic_nom = med_specialite.special_ID
			AND medicament.medic_dci = dci_ID
			AND medicament.medic_presentation = presentation_ID
			AND medicament.medic_dosage_unite = unite_ID
			ORDER BY special_nom
			";
				
$resultat = ExecRequete($requete,$connexion);
print("<table>");
	print("<tr bgcolor=\"yellow\">");
		print("<td bgcolor=\"yellow\">Produit</th>");
		print("<td>DCI</td>");
		print("<td>Quantité</td>");
		print("<td>Péremption</td>");
		print("<td>&nbsp;</td>");
		print("<td>&nbsp;</td>");
	print("</tr>");
while($rub=mysql_fetch_array($resultat))
{	
	print("<tr>");
		print("<td>".$rub['special_nom']."</td>");
		print("<td>".$rub['dci_nom']."</td>");
		print("<td>".$rub['med_lot_qte']." ".$rub['presentation_nom']." ".$rub['medic_dosage']." ".$rub['unite_abrev']."</td>");
		print("<td>".$rub['med_lot_perime']."</td>");
		print("<td><a href=\"medicament_lot.php?lot=$rub[med_lot_ID]\">modifier</a></td>");
		print("<td><a href=\"\">supprimer</a></td>");
	print("</tr>");
}
print("</table>");

print("</FORM>");
print("</html>")

?>
